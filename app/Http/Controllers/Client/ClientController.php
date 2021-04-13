<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Service;
use App\Models\PaymentGateway;
use App\Models\Payment;
use App\Models\WalletTransaction;
use App\Models\User;
use App\Models\Client;
use App\Models\State; 
use App\Models\Lga;
use App\Models\Town;
use App\Models\Account;
use App\Models\ClientDiscount;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Cse;
use App\Models\ServiceRequestSetting;
use DB;
use App\Models\ServiceRequest;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Traits\RegisterPaymentTransaction;
use App\Traits\Services;
use App\Traits\PasswordUpdator;
use Auth;
use App\Models\LoyaltyManagement;
use App\Models\ClientLoyaltyWithdrawal;
use App\Models\ServiceRequestPayment;
use App\Models\ServiceRequestProgress;
use App\Models\ServiceRequestCancellation;
use App\Models\ServiceRequestWarranty;
use App\Traits\Utility;
use App\Traits\Loggable;
use Session;
use Image;
use App\Http\Controllers\Client\PaystackController;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Carbon\Carbon;

use App\Http\Controllers\Messaging\MessageController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    use RegisterPaymentTransaction, Generator, Services, PasswordUpdator,Utility, Loggable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $myRequest = Client::where('user_id', auth()->user()->id)->with('service_requests')->firstOrFail();

        //Get total available serviecs
        $totalServices = Service::count();

        if($totalServices < 3){
            $popularRequests = Service::select('id', 'uuid', 'name', 'image')->take(10)->get()->random(1);
        }else{
            $popularRequests = Service::select('id', 'uuid', 'name', 'image')->take(10)->get()->random(3);
        }

        $user = Auth::user();

        // return $user->contact->phone_number ?? 'UNAVAILABLE';

        return view('client.home', [
            // data
            'totalRequests' => $user->clientRequests()->count(),
            'completedRequests' => $user->clientRequests()->where('status_id', 4)->count(),
            'cancelledRequests' => $user->clientRequests()->where('status_id', 3)->count(),
            'user' => auth()->user()->account,
            'client' => [
                'phone_number' => $user->contact->phone_number ?? 'UNAVAILABLE',
            ],
            'popularRequests'  =>  $popularRequests,
            'userServiceRequests' =>  $myRequest,

        ]);
    }

    public function clientRequestDetails($language, $request){

        $requestDetail = ServiceRequest::where('uuid', $request)->with('price')->firstOrFail();

        // return \App\Models\ServiceRequestAssigned::where('service_request_id', $requestDetail->id)->where('status', 'Active')->firstOrFail()->status;

        return view('client.request_details', [

            'requestDetail'     =>  $requestDetail,
            'assignedCSE'       =>  \App\Models\ServiceRequestAssigned::where('service_request_id', $requestDetail->id)->where('status', 'Active')->first(),

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

    public function settings(Request $request){
        $data['client'] = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();

        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();

        $data['lgas'] = Lga::select('id', 'name')->where('state_id', Account::where('user_id',auth()->user()->id)->orderBy('id','ASC')->firstOrFail()->state_id)->orderBy('name', 'ASC')->get();

        $data['towns'] = Town::select('id', 'name')->where('lga_id', Account::where('user_id',auth()->user()->id)->orderBy('id','ASC')->firstOrFail()->lga_id)->orderBy('name', 'ASC')->get();

        return view('client.settings', $data);
    }


    public function update_profile(Request $request)
    {
        // $all = $request->all();
        // dd($all);
        // return;
        $img = $request->file('profile_avater');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $validatedData = $request->validate([
            'first_name'  => 'required|max:255',
            'gender'   => 'required',
            'phone_number'   => 'required|max:255',
            'email'       => 'required|email|max:255',
            'profile_avater' => [
                function ($attribute, $value, $fail) use ($request, $img, $allowedExts) {
                    if ($request->hasFile('profile_avater')) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
            'state_id'   => 'required|max:255',
            'lga_id'   => 'required|max:255',
            'full_address'   => 'required|max:255',
          ]);

        // update contact table
        $contact = Contact::where('user_id', auth()->user()->id)->orderBy('id','ASC')->firstOrFail();
        $contact->name              = $request->first_name. ' ' . $request->middle_name.' '. $request->last_name;
        $contact->state_id          = $request->state_id;
        $contact->lga_id            = $request->lga_id;
        $contact->town_id           = $request->town_id;
        $contact->account_id        = Client::where('user_id',auth()->user()->id)->orderBy('id','ASC')->firstOrFail()->account_id;
        $contact->country_id        = '156';
        $contact->phone_number      = $request->phone_number;
        $contact->address           = $request->full_address;
        $contact->address_longitude = $request->user_longitude;
        $contact->address_latitude  = $request->user_latitude;
        $contact->update();

        // update account table
        $account = Account::where('user_id', auth()->user()->id)->orderBy('id','ASC')->firstOrFail();
        $account->state_id = $request->state_id;
        $account->lga_id = $request->lga_id;
        $account->town_id = $request->town_id;
        $account->first_name = $request->first_name;
        $account->middle_name = $request->middle_name;
        $account->last_name = $request->last_name;
        $account->gender = $request->gender;
        // $account->avatar = $request->input('old_avatar');
        if($request->hasFile('profile_avater')){
            $image = $request->file('profile_avater');
            $imageName = sha1(time()) .'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('assets/user-avatars').'/'.$imageName;
            //Delete old image
            if(\File::exists(public_path('assets/user-avatars/'.$request->input('old_avatar')))){
                $done = \File::delete(public_path('assets/user-avatars/'.$request->input('old_avatar')));
                if($done){
                    // echo 'File has been deleted';
                }
            }
            //Move new image to `client-avatars` folder
            Image::make($image->getRealPath())->resize(220, 220)->save($imagePath);
            $account->avatar = $imageName;
        }
        $account->update();

        Session::flash('success', 'Profile updated successfully!');
        return redirect()->back();
    }


    public function wallet()
    {
        $data['gateways']     = PaymentGateway::whereStatus(1)->orderBy('id', 'DESC')->get();
        $data['mytransactions']    = Payment::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('client.wallet', compact('myWallet')+$data);
    }

    public function walletSubmit(Request $request)
    {
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // Instantiate payment controller class in this controller's method
        $paystack_controller = new PaystackController;

        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // validate Request
        $valid = $this->validate($request, [
            // List of things needed from the request like
            // Amount, Payment Channel, Payment for
            'amount'           => 'required',
            'payment_channel'  => 'required',
            'payment_for'      => 'required',
        ]);

        // fetch the Client Table Record of loggedIn user
        $client = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();

        // generate random string
        $generatedVal = $this->generateReference();
        $track  = Session::put('Track', $generatedVal);

        // call the payment Trait and submit record on the payment table
        $payment = $this->payment($valid['amount'], $valid['payment_channel'], $valid['payment_for'], $client['unique_id'], 'pending', $generatedVal);

        // if a payment record is saved to the payment table
        if ($payment) {
            // get the payment record saved in the DB using the generated Value as refId
            $paymentRecord =  Payment::where('reference_id', $generatedVal)->orderBy('id', 'DESC')->first();

            // authenticated user 
            $user = User::find($paymentRecord->user_id);

            // if there is no payment record saved
            if (is_null($paymentRecord)) {
                return redirect()->route('client.wallet', app()->getLocale())->with('error', 'Invalid Deposit Request');
            }
            // if the payment record have been saved and has a status of pending
            if ($paymentRecord->status != 'pending') {
                $return = redirect()->route('client.wallet', app()->getLocale())->with('error', 'Transaction already saved');
            }
            $gatewayData = PaymentGateway::where('keyword', $paymentRecord->payment_channel)->first();
              switch ($paymentRecord->payment_channel) {
                  case 'paystack':              
                    // Use paymentcontroller method in this controller
                    // $return = $paystack_controller->initiatePayment($request, $generatedVal, $paymentRecord, $user);
                    
                    $return = redirect()->route('client.ipn.paystack', app()->getLocale());
                  break;
                  case 'flutterwave': 
                    // $this->initiatePayment(); 
                    // $return = redirect()->route('client.ipn.flutter', app()->getLocale());

                    $flutter['amount'] = $paymentRecord->amount;
                    $flutter['track'] = Session::get('Track');
                    $client = User::find(auth()->user()->id);
                    // dd($flutter);
                    return view('client.payment.flutter', compact('flutter', 'gatewayData', 'paymentRecord', 'myWallet','client'));

                    // $return = redirect()->route('client.ipn.flutter', app()->getLocale());

                  break;
                  
              default:

                $return = redirect()->route('client.wallet', app()->getLocale())->with('error', 'Please select a payment method');
            }
            return (!$return) ? redirect()->route('client.wallet', app()->getLocale())->with('error', 'an error occured') : $return;
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
        $data =  Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();

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
        // dd($data);
        // return;
        /** If the transaction status are successful send to DB */
        if ($data->status == 'pending') {
            $data['status'] = 'success';
            $data['transaction_id'] = rawurlencode($reference);
            $data->update();
            $track = Session::get('Track');
            $data  = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();

            $client = \App\Models\Client::where('user_id', auth()->user()->id)->with('user')->firstOrFail();

            // if (!WalletTransaction::where('unique_id', '=', $client['unique_id'])->exists()) {
                $walTrans = new WalletTransaction;
                $walTrans['user_id'] = auth()->user()->id;
                $walTrans['payment_id'] = $data->id;
                $walTrans['amount'] = $data->amount;
                $walTrans['payment_type'] = 'funding';
                $walTrans['unique_id'] = $data->unique_id;
                $walTrans['transaction_type'] = 'debit';
                // if the user has not used this wallet for any transaction
                if (!WalletTransaction::where('unique_id', '=', $client['unique_id'])->exists()) {
                $walTrans['opening_balance'] = '0';
                $walTrans['closing_balance'] = $data->amount;
                }else{
                    $previousWallet = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
                    $walTrans['opening_balance'] = $previousWallet->closing_balance;
                    $walTrans['closing_balance'] = $previousWallet->closing_balance + $data->amount;
                }
                // dd($walTrans);
                $walTrans->save();
            }else{
                $walTrans = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
                $walTrans['opening_balance'] = $walTrans->closing_balance;
                $walTrans['closing_balance'] = $walTrans->opening_balance + $data->amount;
                $walTrans->update();
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

    /**
     * Return a list of all active FixMaster services.
     *
     * @return \Illuminate\Http\Response
    */
   public function updatePassword(Request $request)
   {
       return $this->passwordUpdator($request);
   }

    /**
     * Return a list of all active FixMaster services.
     *
     * @return \Illuminate\Http\Response
     */
    public function services(){
        //Return all active categories with at least one Service
        return view('client.services.index', $this->categoryAndServices());
    }

    /**
     * Display a service request quote page.
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceQuote($language, $uuid, Request $request){
        $data['gateways']     = PaymentGateway::whereStatus(1)->orderBy('id', 'DESC')->get();
        $data['service']      = $this->service($uuid);
        $data['bookingFees']  = $this->bookingFees();
        $data['discounts']    = $this->clientDiscounts();

        $data['balance']      = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
        // [
        //     'service'       =>  $this->service($uuid),
        //     'bookingFees'   =>  $this->bookingFees(),
        //     'discounts'     =>  $this->clientDiscounts(),
        // ]
        // dd($data['balance']->closing_balance );
        // dd($data['discounts'] );
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();

        // $data['lgas'] = Lga::select('id', 'name')->orderBy('name', 'ASC')->get();

        //Return Service details
        $data['myContacts'] = Contact::where('user_id', auth()->user()->id)->get();
        //Return Service details
        // $data['myContacts'] = Contact::where('user_id', auth()->user()->id)->get();
        // dd($data['myContacts']);

        $data['registeredAccount'] = Account::where('user_id', auth()->user()->id)
                                    ->with('usercontact')
                                    ->orderBy('id','DESC')
                                    ->firstOrFail();
                                    // dd($data['registeredAccount']);
        return view('client.services.quote', $data);
    }

    function ajax_contactForm(Request $request){
             
        $validatedData = $request->validate([
            'firstName'                   =>   'required',
            'lastName'                    =>   'required',
            'phoneNumber'                 =>   'required', 
            'state'                       =>   'required',          
            'lga'                         =>   'required',          
            'town'                        =>   'required',          
            'streetAddress'               =>   'required',          
            'addressLat'                  =>   'required',          
            'addressLng'                  =>   'required',          
          ]);

        $clientContact = new Contact;
        $clientContact->user_id   = auth()->user()->id;
        $clientContact->name      = $request->firstName.' '.$request->lastName;
        $clientContact->state_id  = $request->state;
        $clientContact->lga_id    = $request->lga;
        $clientContact->town_id    = $request->town;
        $client  = Client::where('user_id',auth()->user()->id)->orderBy('id','DESC')->firstOrFail();
        $clientContact->account_id    = $client->account_id;
        $clientContact->country_id    = '156';
        // $clientContact->is_default        = '1';
        $clientContact->phone_number       = $request->phoneNumber;
        $clientContact->address            = $request->streetAddress;
        $clientContact->address_longitude  = $request->addressLat;
        $clientContact->address_latitude   = $request->addressLng;
        if ($clientContact->save()) {
            return view('client.services._contactList', [
                'myContacts'    => Contact::where('user_id', auth()->user()->id)->get(),
            ]);

        } else{
            return back()->with('error', 'sorry!, an error occured please try again');
        }

    }

    // $serviceRequests = ServiceRequestAssigned::where('user_id', Auth::id())->with('service_request')->get();

    // return $serviceRequests;

    public function serviceRequest(Request $request){

            $validatedData = $request->validate([
            'balance'                   =>   'required',
            'booking_fee'               =>   'required',
            'description'               =>   'required', 
            'payment_method'            =>   'required',          
            'myContact_id'              =>   'required',         
          ]);

            // if payment method is wallet
            if($request->payment_method == 'Wallet'){

                // if wallet balance is less than the service fee
                if($request->balance > $request->booking_fee){
                    $SavedRequest = $this->saveRequest($request);
                    
                    // dd($service_request);
                    if ($SavedRequest) {

                    // fetch the Client Table Record
                    $client = \App\Models\Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
                    // generate reference string for this transaction
                    $generatedVal = $this->generateReference();
                    // call the payment Trait and submit record on the
                    $payment = $this->payment($SavedRequest->total_amount, 'wallet', 'service-request', $client['unique_id'], 'success', $generatedVal);
                    // save the reference_id as track in session
                    Session::put('Track', $generatedVal);
                        if ($payment) {
                            //   new starts here
                            $user_id = auth()->user()->id;
                            $track = Session::get('Track');
                            $pay =  Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();
                            //save to the wallet transaction table
                            if ($pay) {
                                $wallet_transaction = new WalletTransaction;
                                $wallet_transaction->user_id = auth()->user()->id;
                                $wallet_transaction->payment_id = $pay->id;
                                $wallet_transaction->amount = $pay->amount;
                                $wallet_transaction->payment_type = $pay->payment_for;
                                $wallet_transaction->unique_id = $pay->unique_id;
                                $wallet_transaction->transaction_type = 'credit';
                                $wallet_transaction->opening_balance = $request->balance;
                                $wallet_transaction->closing_balance = $request->balance - $pay->amount;
                                $wallet_transaction->status = 'success';
                                $wallet_transaction->save();
                                // $this->getDistanceDifference();
                                // return back()->with('success', 'Success! Transaction was successful and your request has been placed.');

                                // save to ServiceRequestPayment table
                                $service_reqPayment = new ServiceRequestPayment;
                                $service_reqPayment->user_id = auth()->user()->id;
                                $service_reqPayment->payment_id = $pay->id;
                                $service_reqPayment->service_request_id = $SavedRequest->id;
                                $service_reqPayment->amount = $pay->amount;
                                $service_reqPayment->unique_id = $pay->unique_id;
                                $service_reqPayment->payment_type = $pay->payment_for;
                                $service_reqPayment->status = 'success';
                            }
                        }
                        return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Service Request was successful!');
                    } else{
                        return back()->with('error', 'sorry!, your service request is not successful');
                    }

                }else{
                    return back()->with('error', 'sorry!, booking fee is greater than wallet balance');
                    }
                }



            // online method
            if ($request->payment_method == 'Online') {
                //  $all = $request->all();
                // dd($all);
                $valid = $this->validate($request, [
                    // List of things needed from the request like
                    'booking_fee'           => 'required',
                    'payment_channel'  => 'required',
                ]);
                // fetch the Client Table Record
                $client = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
                // save the reference_id as track in session
                $generatedVal = $this->generateReference();

            $payment = $this->payment($valid['booking_fee'], $valid['payment_channel'], 'service-request', $client['unique_id'], 'pending', $generatedVal);
                Session::put('Track', $generatedVal);
            if ($payment) {
                // paystack
                if($request->payment_channel == 'paystack'){
                    // if($this->initiatePayment()){

                        $SavedRequest = $this->saveRequest($request);

                        // $this->initiatePayment();
                        return redirect()->route('client.serviceRequest.initiatePayment', app()->getLocale());

                    // }
                 // flutter
                }elseif ($request->payment_channel == 'flutter') {
                    # flutter...
                    // if($this->initiatePayment()){
                        $this->initiatePayment();
                    // }
                }
            }

            } else{
                return back()->with('error', 'Sorry!, an error occured please try again');
                }

           }

            public function initiatePayment(){
                $track  = Session::get('Track');
                // dd($track);
                $data = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();
            //    dd($data);
                $user = User::find($data->user_id);
                if($user){

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => json_encode([
                            'amount' => $data->amount * 100,
                            'email' => $user->email,
                            'callback_url' => route('client.serviceRequest.verifyPayment', app()->getLocale())
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

                }else{
                    return back()->with('error', 'Error occured while making payment');
                }

            }




            public function verifyPayment()
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

                /** If the transaction status are successful send to DB */
                if ($data->status == 'pending') {
                    $data['status'] = 'success';
                    $data['transaction_id'] = rawurlencode($reference);
                    $data->update();
                    $track = Session::get('Track');
                    $data  = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();

                    // $client = \App\Models\Client::where('user_id', auth()->user()->id)->with('user')->firstOrFail();


                }

                /** Finally return the callback view for the end user */
                return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Service Request was successful!');
            }





            public function getDistanceDifference(Request $request){
                // $the_message = new MessageController;
                //         $type = 'email';
                //         $subject = 'new job notice';
                //         $from = 'client@fix-master.com';
                //         $to = 'cse@fix-master.com';
                //         $mail_data = ["firstname"=>"Olaoluwa", "url"=>"www.google.com"];
                //         $feature = 'NEW_JOB_NOTIFICATION';
                // // $the_message->sendMessage( $type, $subject, $from, $to, $mail_data, $feature);
                // $the_message->sendNewMessage( $type, $subject, $from, $to, $mail_data, $feature);
                $client = Client::where('user_id', $request->user()->id)->with('user')->orderBy('id','DESC')->firstOrFail();

                // $latitude  = '3.921007';
                $latitude  = $client->user->contact->address_latitude;
                // $longitude = '1.8386';
                $longitude = $client->user->contact->address_longitude;
                // $radius    = 325;
                $radius        = ServiceRequestSetting::find(1)->radius;

                $cse = DB::table('cses')
                ->join('contacts', 'cses.user_id','=','contacts.user_id')
                ->join('users', 'cses.user_id', '=', 'users.id')
                ->join('accounts', 'cses.user_id', '=', 'accounts.user_id')
                // // // ->select(DB::raw('contacts.*,1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - abs(address_latitude)) *  pi()/180 / 2), 2) + COS(" . $latitude . " * pi()/180) * COS(abs(address_latitude) * pi()/180) * POWER(SIN((" . $longitude . " - address_longitude) * pi()/180 / 2), 2)  )) AS calculatedDistance'))
                ->select(DB::raw('cses.*, contacts.address, accounts.first_name, users.email,  6353 * 2 * ASIN(SQRT( POWER(SIN(('.$latitude.' - abs(address_latitude)) * pi()/180 / 2),2) + COS('.$latitude.' * pi()/180 ) * COS(abs(address_latitude) *  pi()/180) * POWER(SIN(('.$longitude.' - address_longitude) *  pi()/180 / 2), 2) )) as distance'))
                ->having('distance', '<=', $radius)
                // // ->having('town', '=', '')
                ->orderBy('distance', 'DESC')
                ->get();

                if ( count($cse) > 0) {
                    // dd($cse);
                    foreach ($cse as $key => $cses){
                        // dd($cse);
                        dd($cses->id);
                        // dd($cses->distance);
                }


            }
            }

    /**
     * Display a more details about a FixMaster service.
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceDetails($language, $uuid){
        //Return Service details
        return view('client.services.show', ['service' => $this->service($uuid)]);
    }
    /**
     * Search and return a list of FixMaster services.
     * This is an ajax call to sort all FixMaster services
     * present on change of Category select dropdown
     *
     * @return \Illuminate\Http\Response
     */
    public function search($language, Request $request){

        //Return all active categories with at least one Service of matched keyword or Category ID
        return view('client.services._search', $this->searchKeywords($request));
    }

    /**
     * Request for a Custom Service frpm FixMaster.
     * Save custom request
     * @return \Illuminate\Http\Response
     */
    public function customService(){

    }


    public function myServiceRequest(){

        $myServiceRequests = Client::where('user_id', auth()->user()->id)->with('service_requests')->firstOrFail();
        return view('client.services.list', [
            'myServiceRequests' =>  $myServiceRequests,
        ]);
    }

    public function loyalty()
    {
        $data['title']     = 'Fund your Loyalty wallet';
        $data['loyalty']   = ClientLoyaltyWithdrawal::select('wallet', 'withdrawal')->where('client_id', auth()->user()->id)->first();
        $total_loyalty    = LoyaltyManagement::selectRaw('SUM(amount) as amounts, SUM(points) as total_points, COUNT(amount) as total_no_amount')->where('client_id', auth()->user()->id)->get();

        $data['total_loyalty'] = ($total_loyalty[0]->total_points *  $total_loyalty[0]->amounts ) / ($total_loyalty[0]->total_no_amount * 100);

        $json = $data['loyalty']->withdrawal != NULL? json_decode($data['loyalty']->withdrawal): [];


        $ifwithdraw = isset($json->withdraw)? $json->withdraw: '';
        $ifwithdraw_date = isset($json->date)? $json->date: '';
        $data['withdraws']=  empty($json) ? [] : (is_array($ifwithdraw) ? $ifwithdraw : [ 0 => $ifwithdraw]);
        $data['withdraw_date']= empty($json)? [] : ( is_array( $ifwithdraw_date) ?  $ifwithdraw_date: [ 0 =>  $ifwithdraw_date]);

        $data['sum_of_withdrawals'] = empty($json)? 0 : (is_array($ifwithdraw) ? array_sum($ifwithdraw): $ifwithdraw);


        $data['mytransactions']    = Payment::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $walTrans = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
        //  $data['ewallet'] = !isset($json->withdraw)? $walTrans->closing_balance: (is_array($json->withdraw) ?  (float)$walTrans->closing_balance + (float)array_sum($json->withdraw): (float)'1000.000' + (float)$json->withdraw) ;

        $data['ewallet'] =  $walTrans->closing_balance;
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('client.loyalty', compact('myWallet')+$data);
    }


    public function loyaltySubmit(Request $request)
    {
        // dd($request);


       $wallet  = ClientLoyaltyWithdrawal::select('wallet', 'withdrawal')->where('client_id', auth()->user()->id)->first();
       if($wallet->withdrawal != NULL){
        $other_withdrawals = json_decode($wallet->withdrawal, true);
        $withdrawal = array_merge_recursive($other_withdrawals,  ['withdraw' => $request->amount, 'date'=> date('Y-m-d h:m:s')]);
       }

       if($wallet->withdrawal == NULL){
        $withdrawal = [
            'withdraw' => $request->amount,
            'date'=> date('Y-m-d h:m:s')
           ];
       }

       if((float)$wallet->wallet > (float)$request->amount){
        $client = Client::where('user_id', auth()->user()->id)->first();
        $generatedVal = $this->generateReference();
        $payment = $this->payment($request->amount, 'loyalty', 'e-wallet', $client->unique_id, 'success', $generatedVal);
        if($payment){

            $walTrans = new WalletTransaction;
            $walTrans->user_id = auth()->user()->id;
            $walTrans->payment_id = $payment->id;
            $walTrans->amount =  $payment->amount;
            $walTrans->payment_type = 'funding';
            $walTrans->unique_id = $payment->unique_id;
            $walTrans->transaction_type = 'credit';
            $walTrans->opening_balance = $request->opening_balance;
            $walTrans->closing_balance = (float)$payment->amount + (float)$request->opening_balance;
            $walTrans->save();

        $update_wallet = (float)$wallet->wallet - (float)$request->amount;
        ClientLoyaltyWithdrawal::where(['client_id'=> auth()->user()->id])->update([
            'withdrawal'=> json_encode($withdrawal),
            'wallet'=>  $update_wallet
             ]);

             return redirect()->route('client.loyalty', app()->getLocale())
             ->with('success', 'Funds transfered  successfully ');

       }else{

        return redirect()->route('client.loyalty', app()->getLocale())
        ->with('error', 'Insufficient Loyalty Wallet Balance');

       }
    }


    }

    public function payments()
    {
        return view('client.payment.list')->with([
            'payments' => \App\Models\Payment::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get(),
        ]);
    }

    public function paymentDetails($language, Payment $payment)
    {
        return view('client.payment._payment_details')->with([
            'payment' => $payment
        ]);
    }

    public function client_rating(Request $request, RatingController $clientratings)
    {
        return $clientratings->handleClientRatings($request);
    }

    public function update_client_service_rating($language, Request $request, RatingController $updateClientRatings)
    {

        return $updateClientRatings->handleUpdateServiceRatings($request);
    }

    private function saveRequest($request){
        $service_request                        = new ServiceRequest();
        $service_request->client_id             = auth()->user()->id;
        $service_request->service_id            = $request->service_id;
        // $service_request->unique_id             = 'REF-'.$this->generateReference();
        $service_request->price_id              = $request->price_id;
        $service_request->contact_id              = $request->myContact_id;
        $service_request->client_discount_id    = $request->client_discount_id;
        // $service_request->client_security_code  = 'SEC-'.strtoupper(substr(md5(time()), 0, 8));
        $service_request->status_id             = '2';
        $service_request->description           = $request->description;
        $service_request->total_amount          = $request->booking_fee;
        $service_request->preferred_time        = Carbon::parse($request->preferred_time, 'UTC'); 
        $service_request->has_client_rated      = 'No'; 
        $service_request->has_cse_rated         = 'No';
        $service_request->created_at         = Carbon::now()->toDateTimeString();
        // $service_request->updated_at         = Carbon::now()->toDateTimeString();
        if ($service_request->save()) {
                    //Temporary Assign a CSE to a client's request for demo purposes
        //List of CSE's Id's on the DB
        $cseArray = array(2, 3, 4);

        $randomCSE = array_rand($cseArray);

        //Create 2 records to `service_request_progresses`
        $serviceRequestProgresses = array(
            array(
                'user_id'               =>  1,
                'service_request_id'    =>  $service_request->id,
                'status_id'             =>  1,
                'sub_status_id'         =>  1,
            ),
            array(
                'user_id'               =>  1,
                'service_request_id'    =>  $service_request->id,
                'status_id'             =>  1,
                'sub_status_id'         =>  1,
            )
        );

        $serviceRequestAssign = array(
            'user_id'               =>  $cseArray[$randomCSE],
            'service_request_id'    =>  $service_request->id,
            'job_accepted'          =>  'Yes',
            'job_acceptance_time'   =>  \Carbon\Carbon::now('UTC'),
            'status'                =>  'Active',
        );

        DB::table('service_request_progresses')->insert($serviceRequestProgresses);

        //Create CSE record on `service_request_assigned` table
        DB::table('service_request_assigned')->insert($serviceRequestAssign);


        return $service_request;
        }
    }



    public function editRequest($language, $request){

        $userServiceRequest = ServiceRequest::where('uuid', $request)->first();
        $data = [
            'userServiceRequest'    =>  $userServiceRequest,
        ];

        return view('client._request_edit', $data);
    }

    public function updateRequest(Request $request, $language, $id){

        $requestExist = ServiceRequest::where('uuid', $id)->first();

        $request->validate([
            'timestamp'             =>   'required',
            'phone_number'          =>   'required',
            'address'               =>   'required',
            'description'           =>   'required',
        ]);


        $timestamp = \Carbon\Carbon::parse($request->input('timestamp'), 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa');

        $updateServiceRequest = ServiceRequest::where('uuid', $id)->update([
            'preferred_time'             =>   $request->input('timestamp'),
            'description'           =>   $request->description,
        ]);

        $updateContactRequest = Contact::where(['user_id'=> auth()->user()->id, 'id'=>   $requestExist->contact_id ])->update([
            'phone_number'          =>   $request->phone_number,
            'address'               =>   $request->address,
        ]);

        if($updateServiceRequest){
          //acitvity log
          return back()->with('success', $requestExist->unique_id.' was successfully updated.');
        }else{

     //acitvity log
            return back()->with('error', 'An error occurred while trying to update a '.$requestExist->unique_id.' service request.');
        }
       
        return back()->withInput();
    }


    public function cancelRequest(Request $request, $language, $id){

        $requestExists = ServiceRequest::where('uuid', $id)->first();
  
        //Validate user input fields
        $request->validate([
            'reason'       =>   'required',
        ]);

    
        //service_request_status_id = Pending(1), Ongoing(2), Completed(4), Cancelled(3) 
        $cancelRequest = ServiceRequest::where('uuid', $id)->update([
            'status_id' =>  '3',
        ]);

        $jobReference = $requestExists->unique_id;

        //Create record in `service_request_progress` table
        $recordServiceProgress = ServiceRequestProgress::create([
            'user_id'                       =>  Auth::id(), 
            'service_request_id'            =>  $requestExists->id, 
            'status_id'                     => '3',
            'sub_status_id'                 => '25'
        ]);

        $recordCancellation = ServiceRequestCancellation::create([
            'user_id'                       =>  Auth::id(), 
            'service_request_id'            =>  $requestExists->id, 
            'reason'                        =>  $request->reason,
        ]);
 

     

        if($cancelRequest AND $recordServiceProgress AND $recordCancellation){

            /*
            * Code to send email goes here...
            */

            //Notify CSE and Technician with messages
            // $this->cancellationMessage = new EssentialsController();
            // $this->cancellationMessage->clientServiceRequestCancellationMessage($clientName, $clientId, $jobReference, $reason);
            // $this->cancellationMessage->adminServiceRequestCancellationMessage($clientName, $clientId, $jobReference, $reason, $supervisorId);

            // MailController::clientServiceRequestCancellationEmailNotification($clientEmail, $clientName,$jobReference, $reason);
            // MailController::adminServiceRequestCancellationEmailNotification('info@fixmaster.com.ng', $clientName,$jobReference, $reason);

            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') cancelled service request'. $jobReference);
            return back()->with('success', $requestExists->unique_id.' was cancelled successfully.');

        }else{
            //Record Unauthorized user activity
         //activity log
            return back()->with('error', 'An error occurred while trying to cancel '.$jobReference.' service request.');
        }

        return back()->withInput();
    }

    public function warrantyInitiate(Request $request, $language, $id){

        $requestExists = ServiceRequest::where('uuid', $id)->first();
    
        $account = Account::where('user_id', auth()->user()->id)->first();
        $accountAdmin = User::where('id', '1')->first();

        //Validate user input fields
     $request->validate([
            'reason'       =>   'required',
        ]);

      $initateWarranty = ServiceRequestWarranty::where('client_id', auth()->user()->id)->update([
        'status' => 'used',
        'initiated' => 'Yes',
        'reason' => $request->reason

            ]);
        
            $user = (object)[
                'name' => $account->first_name,
                'email' => auth()->user()->email,
                'type' => 'client',
                'service_request_unique' => $requestExists->unique_id,
              ];


              $admin = (object)[
                'name' => 'Admin',
                'email' =>  $accountAdmin->email,
                'client'=> $account->first_name . ' ' .$account->last_name ,
                'client_email' => auth()->user()->email,
                'type' => 'admin',
                'service_request_unique' => $requestExists->unique_id
              ];
              if($initateWarranty){
                $clientEmail = $this->sendWarrantyInitiationMail($user, 'client');
                $adminEmail = $this->sendWarrantyInitiationMail($admin, 'client');
                return redirect()->route('client.service.all', app()->getLocale())->with('success', $requestExists->unique_id.' warranty was successfully initiated.');

              }else{
                return back()->with('error', 'An error occurred while trying to initiate warranty for'.  $requestExists->unique_id.' service request.');
 
              }
    }

    public function reinstateRequest(Request $request, $language, $id){

        $requestExists = ServiceRequest::where('uuid', $id)->first();
        //service_request_status_id = Pending(1), Ongoing(2), Completed(4), Cancelled(3) 
        $cancelRequest = ServiceRequest::where('uuid', $id)->update([
            'status_id' =>  '1',
        ]);

        $jobReference = $requestExists->unique_id;

        //Create record in `service_request_progress` table
        $recordServiceProgress = ServiceRequestProgress::where(['service_request_id'=> $requestExists->id, 'user_id' => Auth::id()])->update([
            'status_id'                     => '1',
            'sub_status_id'                 => '1'
        ]);

        $recordCancellation = ServiceRequestCancellation::where(['service_request_id'=> $requestExists->id, 'user_id' => Auth::id()])->delete();

        if($cancelRequest AND $recordServiceProgress AND $recordCancellation){

            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') reinstated service request'. $jobReference);
            
            return back()->with('success', $requestExists->unique_id.' was reinstated successfully.');

        }else{
            //Record Unauthorized user activity
         //activity log
            return back()->with('error', 'An error occurred while trying to cancel '.$jobReference.' service request.');
        }

    }

    public function markCompletedRequest(Request $request, $language, $id){
     
        $requestExists = ServiceRequest::where('uuid', $id)->first();
        $cancelRequest = ServiceRequest::where('uuid', $id)->update([
            'status_id' =>  '4',
        ]);
        $jobReference = $requestExists->unique_id;
        $recordServiceProgress = ServiceRequestProgress::create([
            'user_id'                       =>  Auth::id(), 
            'service_request_id'            =>  $requestExists->id, 
            'status_id'                     => '4',
            'sub_status_id'                 => '27'
        ]);
        if($cancelRequest AND $recordServiceProgress){
            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') marked as completed service request'. $jobReference);
            return redirect()->route('client.service.all', app()->getLocale())->with('success', $requestExists->unique_id.' was marked as completed successfully.');
        }else{
           
         //activity log
            return back()->with('error', 'An error occurred while trying to complete '.$jobReference.' service request.');
        }
    }

}
