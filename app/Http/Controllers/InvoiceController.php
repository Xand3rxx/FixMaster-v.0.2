<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Client\ClientController;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Category;
use App\Models\PaymentGateway;
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

class InvoiceController extends Controller
{
    use RegisterPaymentTransaction, Generator;

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
        $getCategory = $invoice['serviceRequest']['service']['category'];
        $labourMarkup = $getCategory['labour_markup'];
        $materialsMarkup = $getCategory['material_markup'];
        $get_logistics = Income::select('amount', 'percentage')->where('income_name', 'Logistics Cost')->first();
        $get_fixMaster_royalty = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Royalty')->first();
        $fixMasterRoyaltyValue = $get_fixMaster_royalty['percentage'];
        $logistics = $get_logistics['amount'];
        $bookingFee = $invoice['serviceRequest']['price']['amount'];
        $warranty = $invoice['warranty_id'] === null ? 0 : Warranty::where('id', $invoice['warranty_id'])->firstOrFail();
        $warrantyValue = $warranty['percentage']/100;
//        $ActiveWarranties = Warranty::where('name', '!=', 'Free Warranty')->orderBy('id', 'ASC')->get();
        $ActiveWarranties = Warranty::orderBy('id', 'ASC')->get();

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


        foreach ($invoice['rfqs']['rfqBatches'] as $item) {
            $total += $item['amount'];
        }
        $markupPrice = $total*$materialsMarkup;
        $materialsMarkupPrice = $total+$markupPrice;


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
                    $labourMarkupPrice = ($subs['labour_cost'] * $quan['quantity']) * $labourMarkup;
                    $amount = ($subs['labour_cost'] * $quan['quantity']) + $labourMarkupPrice;
                }
                elseif($subs['cost_type'] === 'Variable')
                {
                    $unitPrice = $subs['labour_cost'];
                    $quantity = $quan['quantity'];

                    if($quantity === '1')
                    {
                        $labourMarkupPrice = ($subs['labour_cost'] * $quan['quantity']) * $labourMarkup;
                        $amount = ($subs['labour_cost'] * $quan['quantity']) + $labourMarkupPrice;
                    }

                    elseif($quantity === '2' || $quantity <= '10')
                    {
                        $percentageValue = $unitPrice*0.5;
                        if($quantity === '2') {
                            $newTotal = $percentageValue + $unitPrice;
                            $labourMarkupPrice = $newTotal * $labourMarkup;
                            $amount = $newTotal + $labourMarkupPrice;
                        }
                        else
                        {
                            $oldTotal = $percentageValue + $unitPrice;
                            $newAmount = $percentageValue * ($quantity-2);
                            $newTotal = $oldTotal + $newAmount;
                            $labourMarkupPrice = $newTotal * $labourMarkup;
                            $amount = $newTotal + $labourMarkupPrice;
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
                            $newTotal = $percentageValue + $oldTotal;
                            $labourMarkupPrice = $newTotal * $labourMarkup;
                            $amount = $newTotal + $labourMarkupPrice;
                        }
                        else
                        {
                            $newAmount = $percentageValue * ($quantity-10);
                            $newTotal = $oldTotal + $newAmount;
                            $labourMarkupPrice = $newTotal * $labourMarkup;
                            $amount = $newTotal + $labourMarkupPrice;
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
                            $newTotal = $percentageValue + $oldTotal;
                            $labourMarkupPrice = $newTotal * $labourMarkup;
                            $amount = $newTotal + $labourMarkupPrice;
                        }
                        else
                        {
                            $newAmount = $percentageValue * ($quantity-20);
                            $newTotal = $oldTotal + $newAmount;
                            $labourMarkupPrice = $newTotal * $labourMarkup;
                            $amount = $newTotal + $labourMarkupPrice;
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
                            $newTotal = $percentageValue + $oldTotal;
                            $labourMarkupPrice = $newTotal * $labourMarkup;
                            $amount = $newTotal + $labourMarkupPrice;
                        }
                        else
                        {
                            $newAmount = $percentageValue * ($quantity - 50);
                            $newTotal = $oldTotal + $newAmount;
                            $labourMarkupPrice = $newTotal * $labourMarkup;
                            $amount = $newTotal + $labourMarkupPrice;
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

            $subTotal = $materialsMarkupPrice + $totalLabourCost;
            $fixMasterRoyalty = $fixMasterRoyaltyValue * $subTotal;
            $totalQuotation = $subTotal + $logistics + $fixMasterRoyalty;
            $amountDue = $totalQuotation - $bookingFee;
            if($invoice['serviceRequest']['client_discount_id'] != null)
            {
                $discountValue = 0.5;
                $discount = $amountDue * 0.5;
            }
            $warrantyCost = $subTotal * $warrantyValue;
            $tax = 0.075;
            $vat = ($amountDue - $discount) * $tax;
            $totalAmount = $amountDue - $discount + $vat + $warrantyCost;
//            dd($totalAmount);

        }
        return view('frontend.invoices.invoice')->with([
            'invoice'   => $invoice,
            'labourMarkup' => $labourMarkup,
            'materialsMarkup' => $materialsMarkup,
            'service_request_assigned' => $service_request_assigned,
            'materialsMarkupPrice' => $materialsMarkupPrice,
            'labourCosts' => $labourCosts,
            'logistics' => $logistics,
            'bookingFee' => $bookingFee,
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

    public function savePayment(Request $request)
    {
//         dd($request);
        $invoice = Invoice::where('uuid', $request->uuid)->first();
        $valid = $this->validate($request, [
            // List of things needed from the request like
            'booking_fee' => 'required',
            'payment_channel' => 'required',
        ]);
        $generatedVal = $this->generateReference();
        $payment = $this->payment($request['booking_fee'], $valid['payment_channel'], 'service-request', $request['unique_id'], 'pending', $generatedVal);

        Session::put('Track', $generatedVal);
        Session::put('InvoiceUUID', $request->uuid);
        // dd($track);
        $data = Payment::where('reference_id', $payment->reference_id)->orderBy('id', 'DESC')->first();
        //    dd($data);

        $user = User::find($data->user_id);
        // dd($user);
        if ($user) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $data->amount * 100,
                    'email' => $user->email,
                    'callback_url' => route('client.invoice.verifyPayment', app()->getLocale())
                ]),
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer sk_test_b612f25bd992c4d84760e312175c7515336b77fc",
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            if ($err) {
                return back()->with('error', $err);
            }

            $tranx = json_decode($response, true);

            if (!$tranx['status']) {
                return back()->with('error', $tranx['message']);
            }

            return redirect($tranx['data']['authorization_url']);

        }

    }

    public function verifyPayment(Request $request)
    {
        $track  = Session::get('Track');
        $invoiceUUID = Session::get('InvoiceUUID');
        $data = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();
        $invoice = Invoice::where('uuid', $invoiceUUID)->first();
        $service_request = ServiceRequest::where('id', $invoice->service_request_id)->first();


        // Store Service_Request_Payments Record
        $service_request_payment = ServiceRequestPayment::create([
            'user_id'               =>    auth()->user()->id,
            'payment_id'            =>    $data->id,
            'service_request_id'    =>    $invoice->service_request_id,
            'amount'                =>    $data->amount,
            'unique_id'             =>    static::generate('invoices', 'REF-'),
            'type'                  =>    $request['invoice_type'] == 'Diagnosis Invoice' ? 'diagnosis-fee' : 'final-invoice-fee',
            'status'                =>    $data->status
        ]);

        if($service_request_payment)
        {
            $service_request->update([
                'total_amount'  => $data->amount
            ]);
        }

        $curl = curl_init();

        /** Check for a reference and return else make empty */
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if (!$reference) {
            die('No reference supplied');
        }

        /** Set the client for url's array values for the Curl's */
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,

            /** Set the client for url header values passed */
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer sk_test_b612f25bd992c4d84760e312175c7515336b77fc",
                "cache-control: no-cache"
            ],
        ));

        /** The response should be executed if successful */
        $response = curl_exec($curl);

        /** If there's an error return the error message */
        $err = curl_error($curl);

        if ($err) {
            print_r('Api returned error ' . $err);
        }

        /** The transaction details and stats would be returned */
        $trans = json_decode($response);
        if (!$trans->status) {
            die('Api returned Error ' . $trans->message);
        }

        /** If the transaction status are successful send to DB */
        if ($data->status == 'pending') {
            $data['status'] = 'success';
            $data['transaction_id'] = rawurlencode($reference);
            $data->update();
            $track = Session::get('Track');
            $data  = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();

            // $client = \App\Models\Client::where('user_id', auth()->user()->id)->with('user')->firstOrFail();
        }

        if($invoice['invoice_type'] == "Diagnosis Invoice"){
            if($invoice['status'] == '1' && $invoice['phase'] == '2')
            {
                $invoice['status'] = '2';
                $invoice->update();
            }
            else if($invoice['status'] == '1' && $invoice['phase'] == '0') {
                $SelectedCompleteInvoice = Invoice::where('service_request_id', $invoice['service_request_id'])->where('invoice_type', 'Completion Invoice')->first();

                $invoice['status'] = '2';
                $invoice['phase'] = '2';
                $invoice->update();

                $SelectedCompleteInvoice['status'] = '0';
                $SelectedCompleteInvoice['phase'] = '0';
                $SelectedCompleteInvoice->update();
            }

            /** Finally return the callback view for the end user */
            return redirect()->route('invoice', [app()->getLocale(), $invoiceUUID])->with('success', 'Invoice payment was successful!');
        }
        else if($invoice['invoice_type'] == "Final Invoice"){
            if($invoice['status'] == '1')
            {
                $invoice['status'] = '2';
                $invoice['phase'] = '2';
                $invoice->update();
            }
    }

        /** Finally return the callback view for the end user */
        return redirect()->route('invoice', [app()->getLocale(), $invoiceUUID])->with('success', 'Invoice payment was successful!');
    }

}
