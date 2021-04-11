<?php

namespace App\Http\Controllers;

use App\Models\Payment;
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

    public function __construct() {
        $this->middleware('auth:web');
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
        // Get the values for calculation
        $get_fixMaster_royalty = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Royalty')->first();
        $get_logistics = Income::select('amount', 'percentage')->where('income_name', 'Logistics Cost')->first();
        $get_taxes = Tax::select('percentage')->where('name', 'VAT')->first();
        $serviceCharge = $invoice->serviceRequest->service->service_charge;

        $tax = $get_taxes->percentage / 100;
        $fixMaster_royalty_value = $get_fixMaster_royalty->percentage;
        $logistics_cost = $get_logistics->amount;
        $materials_cost = $invoice->materials_cost == null ? 0 : $invoice->materials_cost;
        $sub_total = $materials_cost + $invoice->labour_cost;
        // End here

        $fixMasterRoyalty = '';
        $subTotal = '';
        $bookingCost = '';
        $tax_cost = '';
        $total_cost = '';
        $warranty = Warranty::where('name', 'Free Warranty')->first();

        if ($invoice->invoice_type == 'Diagnosis Invoice') {
            $subTotal = $serviceCharge;
            $fixMasterRoyalty = $fixMaster_royalty_value * ($subTotal);
            $bookingCost = $invoice->serviceRequest->price->amount;
            $tax_cost = $tax * ($subTotal + $logistics_cost + $fixMasterRoyalty);
            $total_cost = $serviceCharge + $fixMasterRoyalty + $tax_cost + $logistics_cost - $bookingCost;
        } else {
            $warrantyCost = 0.1 * ($invoice->labour_cost + $materials_cost);
            $bookingCost = $invoice->serviceRequest->price->amount;
            $fixMasterRoyalty = $fixMaster_royalty_value * ($invoice->labour_cost + $materials_cost + $logistics_cost);
            $tax_cost = $tax * $sub_total;
            $total_cost = $materials_cost + $invoice->labour_cost + $fixMasterRoyalty + $warrantyCost + $logistics_cost - $bookingCost - 1500 + $tax_cost;
        }

//        dd($total_cost);

        return view('frontend.invoices.invoice')->with([
            'invoice' => $invoice,
            'rfqExists' => $invoice->rfq_id,
            'serviceRequestID' => $invoice->serviceRequest->id,
            'serviceRequestUUID' => $invoice->serviceRequest->uuid,
            'get_fixMaster_royalty' => $get_fixMaster_royalty,
            'fixmaster_royalty_value' => $fixMaster_royalty_value,
            'subTotal' => $subTotal,
            'bookingCost' => $bookingCost,
            'fixmasterRoyalty' => $fixMasterRoyalty,
            'tax' => $tax_cost,
            'logistics' => $logistics_cost,
            'warranty' => $warranty->percentage,
            'total_cost' => $total_cost
        ]);
    }

    public function savePayment(Request $request)
    {
//         dd($request);
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
        if($invoice['status'] == '1')
        {
            $invoice['status'] = '2';
            $invoice->update();
        }

        /** Finally return the callback view for the end user */
        return redirect()->route('invoice', [app()->getLocale(), $invoiceUUID])->with('success', 'Invoice payment was successful!');
    }
}
