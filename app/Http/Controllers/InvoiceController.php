<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Client\ClientController;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Category;
use App\Models\PaymentGateway;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestReport;
use App\Models\SubService;
use App\Models\ServiceRequestWarranty;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequestPayment;
use App\Models\User;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Traits\RegisterPaymentTransaction;
use Session;

use App\Models\Income;
use App\Models\Invoice;
use App\Models\Tax;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Traits\AddCollaboratorPayment;

class InvoiceController extends Controller
{
    use RegisterPaymentTransaction, Generator, AddCollaboratorPayment;

    public $public_key;
    private $private_key;

    public function __construct() {
        $this->middleware('auth:web');
        $data = PaymentGateway::whereKeyword('flutterwave')->first()->convertAutoData();
        $this->public_key = $data['public_key'];
        $this->private_key = $data['private_key'];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.invoices.index')->with([
            'invoices' => \App\Models\Invoice::latest('invoices.created_at')->get(),
        ]);
    }

    public function invoice($language, Invoice $invoice)
    {
        $service_request_assigned = ServiceRequestAssigned::where('service_request_id', $invoice['serviceRequest']['id'])->where('assistive_role', 'CSE')->firstOrFail();
        $technician_assigned = ServiceRequestAssigned::where('service_request_id', $invoice['serviceRequest']['id'])->where('assistive_role', 'Technician')->firstOrFail();
        $get_qa_assigned = ServiceRequestAssigned::where('service_request_id', $invoice['serviceRequest']['id'])->where('assistive_role', 'Consultant')->first();
        $qa_assigned = $get_qa_assigned ?? null;

//        $root_cause = ServiceRequestReport::where('service_request_id', $invoice['service_request_id'])->where('type', 'Root-Cause')->first()->report;
//        dd($root_cause);

        $getCategory = $invoice['serviceRequest']['service']['category'];
        $labourMarkup = $getCategory['labour_markup'];
        $materialsMarkup = $getCategory['material_markup'];
        $get_logistics = Income::select('amount', 'percentage')->where('income_name', 'Logistics Cost')->first();
        $get_fixMaster_royalty = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Royalty')->first();
        $get_retention_fee = Income::select('percentage')->where('income_name', 'Retention Fee')->first();
        $fixMasterRoyaltyValue = $get_fixMaster_royalty['percentage'];
        $logistics = $get_logistics['amount'];
        $retentionFee = $get_retention_fee['percentage'];
        $bookingFee = $invoice['serviceRequest']['price']['amount'];
        $warranty = $invoice['warranty_id'] === null ? 0 : Warranty::where('id', $invoice['warranty_id'])->firstOrFail();
        $warrantyValue = $warranty['percentage']/100;
        $ActiveWarranties = Warranty::orderBy('id', 'ASC')->get();
        $supplierDeliveryFee = $invoice['rfqs']['rfqSupplierInvoice']['delivery_fee'] ?? 0;

        $total = 0;
        $amount = '';
        $subTotal = '';
        $diagnosisCharge = '';
        $fixMasterRoyalty = '';
        $totalQuotation ='';
        $totalLabourCost ='';
        $discount = '';
        $amountDue = '';
        $vat = '';
        $totalAmount = '';
        $warrantyCost = '';
        $materialsMarkupPrice = '';
        $actual_labour_cost = '';
        $newTotal='';


        if($invoice['rfq_id'])
        {
            foreach ($invoice['rfqs']['rfqBatches'] as $item) {
                $total += $item['amount'];
            }
            $markupPrice = $total*$materialsMarkup;
            $materialsMarkupPrice = $total+$markupPrice;
        }
        else
        {
            $materialsMarkupPrice = 0;
        }


        (array) $sub_services = $invoice['serviceRequest']['sub_services'];
        $subServices = array();
        $labourCosts = array();
        if ($invoice->invoice_type == 'Diagnosis Invoice') {
            if($invoice['hours_spent'] === 1) {
                $charge = $invoice['serviceRequest']['service']['service_charge'];
                $subTotal = $charge;
            }
            else
            {
                $first_hour_charge = $invoice['serviceRequest']['service']['service_charge'];
                $sub_hour_charge = $invoice['serviceRequest']['service']['diagnosis_subsequent_hour_charge'];

                $subTotal = $first_hour_charge + ($sub_hour_charge * ($invoice['hours_spent'] -1));
            }

            $fixMasterRoyalty = $fixMasterRoyaltyValue * $subTotal;
            $amountDue = $subTotal + $fixMasterRoyalty - $bookingFee;
            $tax = 0.075;
            $vat = $tax * $amountDue;
            $totalAmount = $amountDue + $vat;

        } else if($invoice->invoice_type == 'Final Invoice') {

            foreach ($sub_services as $sub_service)
            {
                $subServices = SubService::where('uuid', $sub_service['uuid'])->firstOrFail();
                $data[] = ['sub_service' => $subServices, 'num' => $sub_service];
            }
            foreach ($data as $element)
            {
                $subs = $element['sub_service'];
                $quan = $element['num'];
                $amount = '';
                if($subs['cost_type'] === 'Fixed'){
                    $actual_labour_cost = $subs['labour_cost'] * $quan['quantity'];
                    $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                    $amount = $actual_labour_cost + $labourMarkupPrice;
                }
                elseif($subs['cost_type'] === 'Variable')
                {
                    $unitPrice = $subs['labour_cost'];
                    $quantity = $quan['quantity'];

                    if($quantity === '1')
                    {
                        $actual_labour_cost = $subs['labour_cost'] * $quan['quantity'];
                        $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                        $amount = $actual_labour_cost + $labourMarkupPrice;
                    }

                    elseif($quantity === '2' || $quantity <= '10')
                    {
                        $percentageValue = $unitPrice*0.5;
                        if($quantity === '2') {
                            $actual_labour_cost = $percentageValue + $unitPrice;
                            $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                            $amount = $actual_labour_cost + $labourMarkupPrice;
                        }
                        else
                        {
                            $oldTotal = $percentageValue + $unitPrice;
                            $newAmount = $percentageValue * ($quantity-2);
                            $actual_labour_cost = $oldTotal + $newAmount;
                            $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                            $amount = $actual_labour_cost + $labourMarkupPrice;
                        }
                    }

                    elseif($quantity === '11' || $quantity <= '20')
                    {
                        $percentageValue = $unitPrice * 0.4;
                        $oldAmount = ($unitPrice*0.5) * (10-2);
                        $oldCount = ($unitPrice*0.5) + $unitPrice;
                        $oldTotal = $oldCount + $oldAmount;

                        if($quantity === '11')
                        {
                            $actual_labour_cost = $percentageValue + $oldTotal;
                            $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                            $amount = $actual_labour_cost + $labourMarkupPrice;
                        }
                        else
                        {
                            $newAmount = $percentageValue * ($quantity-10);
                            $actual_labour_cost = $oldTotal + $newAmount;
                            $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                            $amount = $actual_labour_cost + $labourMarkupPrice;
                        }

                    }

                    elseif($quantity === '21' || $quantity <= '50')
                    {
                        $percentageValue = $unitPrice * 0.3;
                        $oldAmount = ($unitPrice * 0.4) * 10;
                        $oldCount = $oldAmount + (($unitPrice * 0.5) + $unitPrice);
                        $oldTotal = $oldCount + $oldAmount;

                        if($quantity === '21')
                        {
                            $actual_labour_cost = $percentageValue + $oldTotal;
                            $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                            $amount = $actual_labour_cost + $labourMarkupPrice;
                        }
                        else
                        {
                            $newAmount = $percentageValue * ($quantity-20);
                            $actual_labour_cost = $oldTotal + $newAmount;
                            $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                            $amount = $actual_labour_cost + $labourMarkupPrice;
                        }

                    }
                    elseif($quantity > '50')
                    {
                        $percentageValue = $unitPrice * 0.25;
                        $oldAmount = ($unitPrice * 0.4) * 10;
                        $oldCount = $oldAmount + (($unitPrice * 0.5) + $unitPrice);
                        $oldTotal = $oldCount + $oldAmount + 9000;

                        if($quantity === '51')
                        {
                            $actual_labour_cost = $percentageValue + $oldTotal;
                            $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                            $amount = $actual_labour_cost + $labourMarkupPrice;
                        }
                        else
                        {
                            $newAmount = $percentageValue * ($quantity - 50);
                            $actual_labour_cost = $oldTotal + $newAmount;
                            $labourMarkupPrice = $actual_labour_cost * $labourMarkup;
                            $amount = $actual_labour_cost + $labourMarkupPrice;
                        }
                    }


                }

                $labourCosts[] = ['subService' => $subs, 'quantity' => $quan, 'amount' => $amount];

            }
            foreach ($labourCosts as $totalCost)
            {
                $totalFig[] = $totalCost['amount'];
                $totalLabourCost = array_sum($totalFig);
            }

            $subTotal = $materialsMarkupPrice + $supplierDeliveryFee + $totalLabourCost;
            $fixMasterRoyalty = $fixMasterRoyaltyValue * $subTotal;
            $totalQuotation = $subTotal + $logistics + $fixMasterRoyalty;
            $amountDue = $totalQuotation - $bookingFee;
            if($invoice['serviceRequest']['client_discount_id'] != null)
            {
                $discount = $amountDue * 0.5;
            }
            else
            {
                $discount = $amountDue * 0;
            }
            $warrantyCost = $subTotal * $warrantyValue;
            $tax = 0.075;
            $vat = ($amountDue - $discount) * $tax;
            $totalAmount = $amountDue - $discount + $vat + $warrantyCost;
//            dd($totalAmount);

        }
//        dd(\App\Models\Earning::where('role_name', 'QA')->first()->earnings);
        return view('frontend.invoices.invoice')->with([
            'invoice'   => $invoice,
            'labourMarkup' => $labourMarkup,
            'root_cause' => ServiceRequestReport::where('service_request_id', $invoice['service_request_id'])->where('type', 'Root-Cause')->first()->report ?? null,
            'other_comments' => ServiceRequestReport::where('service_request_id', $invoice['service_request_id'])->where('type', 'Other-Comment')->first()->report ?? null,
            'materialsMarkup' => $materialsMarkup,
            'service_request_assigned' => $service_request_assigned,
            'technician_assigned' => $technician_assigned,
            'qa_assigned' => $qa_assigned,
            'materialsMarkupPrice' => $materialsMarkupPrice,
            'labourCosts' => $labourCosts,
            'logistics' => $logistics,
            'bookingFee' => $bookingFee,
            'supplierDeliveryFee' => $supplierDeliveryFee,
            'subTotal' => $subTotal,
            'warranty' => $warranty,
            'ActiveWarranties' => $ActiveWarranties,
            'warrantyCost' => $warrantyCost,
            'totalLabourCost' => $totalLabourCost,
            'fixMasterRoyalty' => $fixMasterRoyalty,
            'totalQuotation' => $totalQuotation,
            'discount' => $discount,
            'amountDue' => $amountDue,
            'vat' => $vat,
            'material_markup' => $materialsMarkup*$total,
            'actual_material_cost' => $total+$supplierDeliveryFee,
            'labour_markup' => $labourMarkup*$actual_labour_cost,
            'actual_labour_cost' => $actual_labour_cost,
            'retention_fee' => $retentionFee,
            'totalAmount' => $totalAmount
        ]);
    }

    public function updateInvoice($language, Request $request, Invoice $invoice)
    {
//        dd($invoice['uuid'], $request);
        $updateWarranty = $invoice->update([
            'warranty_id'  => $request->input('warranty_id'),
            'phase' => '2'
        ]);
        if($updateWarranty)
        {
            return redirect()->route('invoice', ['invoice' => $invoice['uuid'], 'locale' => app()->getLocale()])->with('success', 'Warranty selected successfully.');
        }
        else
        {
            return redirect()->route('invoice', ['invoice' => $invoice['uuid'], 'locale' => app()->getLocale()])->with('error', 'An unknown error occurred.');
        }
    }

    public function saveInvoiceRecord($paymentRecord, $paymentDetails) 
    {
        // dd($paymentRecord);
        $booking_fee = $paymentRecord['booking_fee'];
        $actual_labour_cost = $paymentRecord['actual_labour_cost'];
        $labour_retention_fee = $paymentRecord['retention_fee'] * $paymentRecord['actual_labour_cost'];
        $labour_cost_after_retention = $paymentRecord['actual_labour_cost'] - $labour_retention_fee;
        $labourMarkup = $paymentRecord['labour_markup'];
        $actual_material_cost = $paymentRecord['actual_material_cost'];
        $material_retention_fee = $paymentRecord['retention_fee'] * $paymentRecord['actual_material_cost'];
        $material_cost_after_retention = $paymentRecord['actual_material_cost'] - $material_retention_fee;
        $materialMarkup = $paymentRecord['material_markup'];
        $cse_assigned = $paymentRecord['cse_assigned'];
        $technician_assigned = $paymentRecord['technician_assigned'];
        $supplier_assigned = $paymentRecord['supplier_assigned'];
        $qa_assigned = $paymentRecord['qa_assigned'];

        $royaltyFee = $paymentRecord['royalty_fee'];
        $logistics = $paymentRecord['logistics_cost'];
        $tax = $paymentRecord['tax'];

        $invoice = Invoice::where('uuid', $paymentRecord['invoiceUUID'])->first();

        $serviceRequest = ServiceRequest::where('id', $invoice['service_request_id'])->firstOrFail();

        (bool)$status = false;
        DB::transaction(function () use ($invoice, $paymentDetails, $serviceRequest, $booking_fee, $cse_assigned, $qa_assigned, $technician_assigned, $supplier_assigned, $paymentRecord, $labour_retention_fee, $material_retention_fee, $actual_labour_cost, $actual_material_cost, $labour_cost_after_retention, $material_cost_after_retention, $labourMarkup, $materialMarkup, $royaltyFee, $logistics, $tax, &$status){
            $this->addCollaboratorPayment($invoice['service_request_id'],$cse_assigned,'Regular',\App\Models\Earning::where('role_name', 'CSE')->first()->earnings,null,null,\App\Models\Earning::where('role_name', 'CSE')->first()->earnings, null, null, null, null, $royaltyFee, $logistics, $tax);
            if($qa_assigned !== null)
            {
                $this->addCollaboratorPayment($invoice['service_request_id'], $qa_assigned, 'Regular', \App\Models\Earning::where('role_name', 'QA')->first()->earnings, null, null, \App\Models\Earning::where('role_name', 'QA')->first()->earnings, null, null, null, null, $royaltyFee, $logistics, $tax);
            }
            $this->addCollaboratorPayment($invoice['service_request_id'],$technician_assigned,'Regular',null,$actual_labour_cost,null, $labour_cost_after_retention, $labour_cost_after_retention,$labour_retention_fee, $labourMarkup, null, $royaltyFee, $logistics, $tax);
            if($invoice['rfq_id'] !== null)
            {
                $this->addCollaboratorPayment($invoice['service_request_id'], $supplier_assigned, 'Regular', null, null, $actual_material_cost, $material_cost_after_retention, $material_cost_after_retention, $material_retention_fee, null, $materialMarkup, $royaltyFee, $logistics, $tax);
            }

            $serviceRequest->update([
                'total_amount' => $booking_fee
            ]);
            $paymentType='';
            if($invoice['invoice_type'] === 'Diagnosis Invoice')
            {
                $paymentType = 'diagnosis-fee';
                \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $invoice['service_request_id'], '2', \App\Models\SubStatus::where('uuid', '17e3ce54-2089-4ff7-a2c1-7fea407df479')->firstOrFail()->id);
                \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $invoice['service_request_id'], '2', \App\Models\SubStatus::where('uuid', '8936191d-03ad-4bfa-9c71-e412ee984497')->firstOrFail()->id);
            }
            elseif ($invoice['invoice_type'] === 'Final Invoice')
            {
                $paymentType = 'final-invoice-fee';
                \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $invoice['service_request_id'], '2', \App\Models\SubStatus::where('uuid', 'c0cce9c8-1fce-47c4-9529-204f403cdb1f')->firstOrFail()->id);
                \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $invoice['service_request_id'], '2', \App\Models\SubStatus::where('uuid', 'b82ea1c6-fc12-46ec-8138-a3ed7626e0a4')->firstOrFail()->id);
            }

            ServiceRequestPayment::create([
                'user_id' => $invoice['client_id'],
                'payment_id' => $paymentDetails['id'],
                'service_request_id' => $invoice['service_request_id'],
                'amount' => $booking_fee,
                'unique_id' => static::generate('invoices', 'REF-'),
                'payment_type' => $paymentType,
                'status' => 'success'
            ]);

            $invoice->update([
                'status' => '2',
                'phase' => '2'
            ]);

            $status = true;

        });
        return $status;

    }
}
