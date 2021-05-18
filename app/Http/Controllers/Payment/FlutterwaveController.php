<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Payment; 
use App\Models\PaymentGateway;
use App\Models\Client;

use App\Traits\RegisterPaymentTransaction;
use App\Traits\GenerateUniqueIdentity as Generator;

use App\Http\Controllers\Payment\FlutterwaveController;

use App\Http\Controllers\Client\ClientController;
use Session;


class FlutterwaveController extends Controller
{
    use RegisterPaymentTransaction, Generator;


    public $public_key;
    private $private_key;

    public function __construct()
    {
        $data = PaymentGateway::whereKeyword('flutterwave')->first()->convertAutoData();
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

        $valid = $this->validate($request, [
            // List of things needed from the request like 
            'booking_fee'      => 'required',
            'payment_channel'  => 'required',
            'payment_for'     => 'required',
        ]);
         $all = $request->all();
        // dd($all);
        // Session::put('order_data', $all);
        $request->session()->put('order_data', $all);


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
                $curl = curl_init();
                
                $payment = Payment::find($paymentId);                 
                
                $request = [
                    'tx_ref' => $payment->reference_id,
                    'amount' => $payment->amount,
                    'currency' => 'NGN',
                    'payment_options' => 'card',
                    'redirect_url' => route('flutterwave-verify', app()->getLocale() ),
                    'customer' => [
                        'email' => auth()->user()->email,
                    ],
                    'meta' => [
                        'price' => $payment->amount
                    ],
                    'customizations' => [
                        'title' => 'Paying for a sample product',
                        'description' => 'sample',
                        'logo' => 'https://assets.piedpiper.com/logo.png'
                    ]
                ];

                //* Call fluterwave initiate payment endpoint
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($request),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$this->private_key,
                    'Content-Type: application/json'
                ),
                ));

                $response = curl_exec($curl);                

                curl_close($curl);
    
                $res = json_decode($response); 

                if($res->status == 'success')
                {                    
                    return redirect($res->data->link);
                }

                else
                {
                    return redirect($cancel_url)->with('error', 'We can not process your payment: Curl returned error: ' . $err);
                }

    }


    public function verify(Request $request)
    {        
        $input_data = $request->all();  

        $trans_id = $request->get('tx_ref', '');

        $paymentDetails = Payment::where('reference_id', $trans_id)->orderBy('id', 'DESC')->first();        
                 

        if( $input_data['status']  == 'successful'){

            $txid = $request->get('transaction_id', '');
            $curl = curl_init();

            //* Call fluterwave verify endpoint
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txid}/verify",
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

           curl_close($curl);

            $resp = \json_decode($response);

            // return dd($resp);

            if(($resp->status ?? '') == "success"){
               $paymentDetails['transaction_id'] = $resp->data->flw_ref ?? '';
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
                        
                        $client_controller->saveRequest( $request->session()->get('order_data') );
                        
                        return redirect()->route('client.service.all' , app()->getLocale() )->with('success', 'payment was successful');
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
