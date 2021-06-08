<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPayment;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\Client;
use App\Models\ServicedAreas;
use App\Models\Contact;

use App\Traits\RegisterPaymentTransaction;
use App\Traits\GenerateUniqueIdentity as Generator;

use Session;

use App\Http\Controllers\Client\ClientController;
use Illuminate\Support\Facades\DB;
use App\Traits\AddCollaboratorPayment;


class PaystackController extends Controller
{
    use RegisterPaymentTransaction, Generator, AddCollaboratorPayment;


    public $public_key;
    private $private_key;

    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('paystack')->first()->convertAutoData();
        $this->public_key = $data['public_key'];
        $this->private_key = $data['private_key'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $valid = $this->validate($request, [
            // List of things needed from the request like
            'booking_fee'      => 'required',
            'payment_channel'  => 'required',
            'payment_for'     => 'required',
            // 'myContact_id'    => 'required',
        ]);

//        $Serviced_areas = ServicedAreas::where('town_id', '=', $request['town_id'])->orderBy('id', 'DESC')->first();
//        if ($Serviced_areas === null) {
//            return back()->with('error', 'sorry!, this area you selected is not serviced at the moment, please try another area');
//        }
//
//        // upload multiple media files
//        foreach($request->media_file as $key => $file)
//            {
//                $originalName[$key] = $file->getClientOriginalName();
//
//                $fileName = sha1($file->getClientOriginalName() . time()) . '.'.$file->getClientOriginalExtension();
//                $filePath = public_path('assets/service-request-media-files');
//                $file->move($filePath, $fileName);
//                $data[$key] = $fileName;
//            }
//                $data['unique_name']   = json_encode($data);
//                $data['original_name'] = json_encode($originalName);
//                // return $data;
//
//        // $request->session()->put('order_data', $request);
//        $request->session()->put('order_data', $request->except(['media_file']));
//        $request->session()->put('medias', $data);

        $data = [
            'logistics_cost' => $request['logistics_cost'],
            'retention_fee' => $request['retention_fee'],
            'tax' => $request['tax'],
            'actual_labour_cost' => $request['actual_labour_cost'],
            'actual_material_cost' => $request['actual_material_cost'],
            'labour_markup' => $request['labour_markup'],
            'material_markup' => $request['material_markup'],
            'cse_assigned' => $request['cse_assigned'],
            'technician_assigned' => $request['technician_assigned'],
            'supplier_assigned' => $request['supplier_assigned'],
            'qa_assigned' => $request['qa_assigned'],
            'royalty_fee' => $request['fixMasterRoyalty'],
            'booking_fee' => $request['booking_fee']
        ];

        $request->session()->put('InvoiceUUID', $request->uuid);
        $request->session()->put('collaboratorPayment', $data);


        // fetch the Client Table Record
        $client = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
        // generate reference ID
        $generatedVal = $this->generateReference();
        // save ordered items
        $payment = $this->payment($valid['booking_fee'], $valid['payment_channel'], $valid['payment_for'], $client['unique_id'], 'pending', $generatedVal);

        $payment_id = $payment->id;

        return $this->initiate($payment_id);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function initiate($paymentId)
    {
                if(auth()->user()){
                    $payment = Payment::find($paymentId);

                    $url = "https://api.paystack.co/transaction/initialize";
                    $fields = [
                      'email' => auth()->user()->email,
                      'amount' => $payment->amount * 100,
                      'reference' => $payment->reference_id,
                      'callback_url' => route('paystack-verify', app()->getLocale()),
                    ];
                    $fields_string = http_build_query($fields);
                    //open connection
                    $ch = curl_init();

                    curl_setopt($ch,CURLOPT_URL, $url);
                    curl_setopt($ch,CURLOPT_POST, true);
                    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "Authorization: Bearer ".$this->private_key,
                        "Cache-Control: no-cache",
                    ));

                    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec($ch);
                    $err = curl_error($ch);
                    if ($err) {
                        return back()->with('error', $err);
                    }

                    $tranx = json_decode($response, true);

                    if (!$tranx['status']) {
                        return back()->with('error', $tranx['message']);
                    }
                    return redirect($tranx['data']['authorization_url'])->with('trans',$tranx);

                }else{
                    return back()->with('error', 'Error occured while making payment');
                }
    }


    public function verify(Request $request)
    {
        $input_data = $request->all();

        $invoiceUUID = Session::get('InvoiceUUID');
        $paymentRecord = Session::get('collaboratorPayment');

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

        $invoice = Invoice::where('uuid', $invoiceUUID)->first();

        $serviceRequestPayment = ServiceRequestPayment::where('service_request_id', $invoice['service_request_id'])->firstOrFail();
        $serviceRequest = ServiceRequest::where('id', $invoice['service_request_id'])->firstOrFail();

        $reference = $request->get('reference', '');

        if (!$reference) {
            die('No reference supplied');
        }

        $paymentDetails = Payment::where('reference_id', $reference)->orderBy('id', 'DESC')->first();

        if( $input_data['reference']){

            // $reference = $request->get('reference', '');
            $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
            $curl = curl_init();

            //* Call fluterwave verify endpoint
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" .$reference,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->private_key
            ),
            ));

           $response = curl_exec($curl);
           $err = curl_error($curl);
           curl_close($curl);

            $resp = \json_decode($response);

            // return dd($resp);
            if (!$resp->status) {
                die('Api returned Error ' . $resp->message);
            }

            if($resp->data->status == 'success'){
               $paymentDetails['transaction_id'] = $resp->data->id;
               $paymentDetails['status']         = 'success';
                //if the payment was updated to success

                /*************************************************************************************************
                 * Things to do if you want to use this function(Number 1 to 5) Not important if you don't need it
                 *************************************************************************************************/

                 // NUMBER 1: Instantiate the clientcontroller class in this controller's method in order to save request
                $client_controller = new ClientController;

                if($paymentDetails->update()){
                    // NUMBER 2: add more for other payment process
                    if($paymentDetails['payment_for'] = 'service-request' ){

                        if($invoice) {
                            (bool)$status = false;
                            DB::transaction(function () use ($invoice, $paymentDetails, $serviceRequest, $serviceRequestPayment, $booking_fee, $cse_assigned, $qa_assigned, $technician_assigned, $supplier_assigned, $paymentRecord, $labour_retention_fee, $material_retention_fee, $actual_labour_cost, $actual_material_cost, $labour_cost_after_retention, $material_cost_after_retention, $labourMarkup, $materialMarkup, $royaltyFee, $logistics, $tax, &$status){
                                $this->addCollaboratorPayment($invoice['service_request_id'],$cse_assigned,'Regular',\App\Models\Earning::where('role_name', 'CSE')->first()->earnings,null,null,null, null, null, null, null, $royaltyFee, $logistics, $tax);
                                if($qa_assigned !== null)
                                {
                                    $this->addCollaboratorPayment($invoice['service_request_id'], $qa_assigned, 'Regular', \App\Models\Earning::where('role_name', 'QA')->first()->earnings, null, null, null, null, null, null, null, $royaltyFee, $logistics, $tax);
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
                            if($status){
                                return redirect()->route('invoice', [app()->getLocale(), $invoiceUUID])->with('success', 'Invoice payment was successful!');
                            }
                            else
                            {
                                return redirect()->route('invoice', [app()->getLocale(), $invoiceUUID])->with('error', 'Invoice payment was unsuccessful!');
                            }


                        }
                        else
                        {
                            $client_controller->saveRequest( $request->session()->get('order_data') );

                            return redirect()->route('client.service.all' , app()->getLocale() )->with('success', 'payment was successful');
                        }
                    }
                }
            }else {
                // NUMBER 3: add more for other payment process
                if($paymentDetails['payment_for'] = 'service-request' ){
                    return redirect()->route('client.services.list', app()->getLocale() )->with('error', 'Verification not successful, try again!');
                }

            }

        }else {
            // NUMBER 4: add more for other payment process
            if($paymentDetails['payment_for'] = 'service-request' ){
                return redirect()->route('client.services.list', app()->getLocale() )->with('error', 'Could not initiate payment process because payment was cancelled, try again!');
            }
        }

        // NUMBER 5: add more for other payment process
        if($paymentDetails['payment_for'] = 'service-request' ){
            return redirect()->route('client.services.list', app()->getLocale() )->with('error', 'there was an error, please try again!');
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function verify()
    // {
    //     //
    //     // echo $payment;
    //     // dd(json_decode($payment));
    //     return view('payment.flutterwave-start');
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
