<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Service;
use App\Models\PaymentGateway;
use App\Models\Payment;
use App\Models\WalletTransaction;
use App\Models\User;
use App\Models\Client;
use App\Helpers\CustomHelpers;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Traits\RegisterPaymentTransaction;



use Session;

class ClientController extends Controller
{
    use RegisterPaymentTransaction, Generator;


    //call the profile page with credentials
    public function edit_profile(Request $request)
    {
    }

    public function update_profile(Request $request)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
    }

    public function view_profile(Request $request)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $popularRequests = Service::select('id', 'name', 'url', 'image')->take(10)->get()->random(3);

        return view('client.home', [
            // data
            'totalRequests' => rand(1, 1),
            'completedRequests' => rand(1, 1),
            'cancelledRequests' => rand(1, 1),
            'user' => auth()->user()->account,
            'client' => [
                'phone_number' => '0909078888'
            ],
            'popularRequests'   =>  $popularRequests,
            // JoeBoy Fill this data
            // 1. 'userServiceRequests'
            // 2. 'popularRequests'
            // 3. 'cseName'
        ]);
    }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

    // public function wallet()
    // {
    //     return view('client.wallet')->with('i');
    // }

    public function wallet()
    {
        $data['title']        = 'Fund your wallet';
        $data['gateways']     = PaymentGateway::whereStatus(1)->orderBy('id', 'DESC')->get();
        $data['mytransactions']    = Payment::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // dd($data['myWallet']);
        return view('client.wallet', compact('myWallet')+$data);
    }


    public function walletSubmit(Request $request)
    {
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // validate Request
        $valid = $this->validate($request, [
            // List of things needed from the request like 
            // Amount, Payment Channel, Payment for, Reference Id
            'amount'           => 'required',
            'payment_channel'  => 'required',
            'payment_for'      => 'required',
        ]);
       
        // fetch the Client Table Record
        $client = \App\Models\Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
        // save the reference_id as track in session

        $generatedVal = $this->generateReference();        
        // call the payment Trait and submit record on the
        $payment = $this->payment($valid['amount'], $valid['payment_channel'], $valid['payment_for'], $client['unique_id'], 'pending', $generatedVal);
        Session::put('Track', $generatedVal);
        // $client->user()->email();
        if ($payment) {            
                //   new starts here 
                $user_id = auth()->user()->id;
                $track = Session::get('Track');
                $pay =  Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();

                // dd($track);
                // dd($pay);
                if (is_null($pay)) {
                    return redirect()->route('client.wallet', app()->getLocale())->with('alert', 'Invalid Deposit Request');
                }
                if ($pay->status != 'pending') {
                    return redirect()->route('client.wallet', app()->getLocale())->with('alert', 'Invalid Deposit Request');
                }
                $gatewayData = PaymentGateway::where('keyword', $pay->payment_channel)->first();

                // dd($gatewayData); 
                if ($pay->payment_channel == 'paystack') { 
                    $paystack['amount'] = $pay->amount;
                    $paystack['track'] = $track;
                    $title = $gatewayData->name;
                    $client = User::find(auth()->user()->id);
                    return view('client.payment.paystack', compact('paystack', 'title', 'gatewayData', 'pay', 'myWallet','client'));
                } elseif ($pay->payment_channel == 'flutterwave') {
                    $flutter['amount'] = $pay->amount;
                    $flutter['track'] = $track;
                    $title = $gatewayData->name;
                    $client = User::find(auth()->user()->id);
                    return view('client.payment.flutter', compact('flutter', 'title', 'gatewayData', 'pay', 'myWallet','client'));
                }
        }


    }


    public function directToRightpage()
    {
        $user_id = auth()->user()->id;
        $track = Session::get('Track');
        $pay =  Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();

        if (is_null($pay)) {
            return redirect()->route('client.wallet', app()->getLocale())->with('alert', 'Invalid Deposit Request');
        }
        if ($pay->status != 'pending') {
            return redirect()->route('client.wallet', app()->getLocale())->with('alert', 'Invalid Deposit Request');
        }
        $gatewayData = PaymentGateway::where('id', $data->payment_channel)->first();

        if ($pay->payment_channel == 1) {
            $paystack['amount'] = $pay->amount;
            $paystack['track'] = $track;
            $title = $gatewayData->name;
            return view('client.payment.paystack', compact('paystack', 'title', 'gatewayData', 'data'));
        } elseif ($pay->payment_channel == 2) {
            $flutter['amount'] = $pay->amount;
            $flutter['track'] = $track;
            $title = $gatewayData->name;
            return view('client.payment.flutter', compact('flutter', 'title', 'gatewayData', 'data'));
        }
    }

    public function paystackIPN(Request $request)
    {
        $track  = Session::get('Track');

        $data = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();
        $user = User::find($data->user_id);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $data->amount * 100,
                'email' => $user->email,
                'callback_url' => route('client.ipn.paystackApiRequest', app()->getLocale())
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




    public function apiRequest()
    {
        $track  = Session::get('Track');
        $data = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();

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

        /** If the transaction stats are successful snd to DB */
        if ($data->status == 'pending') {
            $data['status'] = 'success';
            $data['transaction_id'] = rawurlencode($reference);
            $data->update();
            $track = Session::get('Track');
            $data  = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();

            $client = \App\Models\Client::where('user_id', auth()->user()->id)->with('user')->firstOrFail();

            if (!WalletTransaction::where('unique_id', '=', $client['unique_id'])->exists()) {
                // $track = Session::get('Track'); 
                // $data  = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();
                $walTrans = new WalletTransaction;
                $walTrans['user_id'] = auth()->user()->id;
                $walTrans['payment_id'] = $data->id;
                $walTrans['amount'] = $data->amount;
                $walTrans['payment_type'] = 'funding';
                $walTrans['unique_id'] = $data->unique_id;
                $walTrans['transaction_type'] = 'debit';
                $walTrans['opening_balance'] = '0';
                $walTrans['closing_balance'] = $data->amount;
                $walTrans->save();
            }else{
                $walTrans = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
                $walTrans['opening_balance'] = $walTrans->closing_balance;
                $walTrans['closing_balance'] = $walTrans->opening_balance + $data->amount;
                $walTrans->update(); 
            }

        }

        /** Finally return the callback view for the end user */ 
        return redirect()->route('client.wallet', app()->getLocale())->with('success', 'Fund successfully added!');
    } 


    public function flutterIPN(Request $request)
    {
        $track  = Session::get('Track');
        $data = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();
        if ($data->status == 'pending') {
            $data['status'] = 'success';
            $data->update();
        }
        
        // $track = Session::get('Track');
        $client = \App\Models\Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
        if (!WalletTransaction::where('unique_id', '=', $client['unique_id'])->exists()) {
            // $track = Session::get('Track'); 
            // $data  = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();
            $walTrans = new WalletTransaction;
            $walTrans['user_id'] = auth()->user()->id;
            $walTrans['payment_id'] = $data->id;
            $walTrans['amount'] = $data->amount;
            $walTrans['payment_type'] = 'funding';
            $walTrans['unique_id'] = $data->unique_id;
            $walTrans['transaction_type'] = 'debit';
            $walTrans['opening_balance'] = '0';
            $walTrans['closing_balance'] = $data->amount;
            $walTrans->save();
        }else{
            $walTrans = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
            $walTrans['opening_balance'] = $walTrans->closing_balance;
            $walTrans['closing_balance'] = $walTrans->opening_balance + $data->amount;
            $walTrans->update(); 
        }
        // dd()
        return redirect()->route('client.wallet', app()->getLocale())->with('success', 'Fund successfully added!');


    }


}
