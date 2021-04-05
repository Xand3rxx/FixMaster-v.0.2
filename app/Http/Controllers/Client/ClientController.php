<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use App\Models\Category;
use App\Models\Service;
use App\Models\PaymentGateway;
use App\Models\Payment;
use App\Models\WalletTransaction;
use App\Models\User;
use App\Models\Client; 
use App\Models\State;
use App\Models\Lga;
use App\Models\ClientDiscount;
use App\Models\Account; 
use App\Models\Phone; 
use App\Models\Address; 
use App\Models\Contact;
use App\Models\Cse;
use App\Models\ServiceRequestSetting;
use DB;
use App\Models\ServiceRequest;
use App\Helpers\CustomHelpers;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Traits\RegisterPaymentTransaction;
use App\Traits\Services;
use App\Traits\PasswordUpdator;
use Auth;
use App\Models\LoyaltyManagement;
use App\Models\ClientLoyaltyWithdrawal;
use App\Models\ServiceRequestProgress;
use App\Models\ServiceRequestCancellation;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Session; 


class ClientController extends Controller
{
    use RegisterPaymentTransaction, Generator, Services, PasswordUpdator;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $myRequest = Client::where('user_id', auth()->user()->id)->with('service_requests')->firstOrFail();
        $myServiceRequests = $myRequest->service_request;
   
        //Get total available serviecs
        $totalServices = Service::count();

        if($totalServices < 3){
            $popularRequests = Service::select('id', 'uuid', 'name', 'image')->take(10)->get()->random(1);
        }else{
            $popularRequests = Service::select('id', 'uuid', 'name', 'image')->take(10)->get()->random(3);
        }

        $user = Auth::user();

        return view('client.home', [
            // data
            'totalRequests' => $user->clientRequests()->count(),
            'completedRequests' => $user->clientRequests()->where('status_id', 4)->count(),
            'cancelledRequests' => $user->clientRequests()->where('status_id', 3)->count(),
            'user' => auth()->user()->account,
            'client' => [
                'phone_number' => '0909078888'
            ],
            'popularRequests'  =>  $popularRequests,
            'userServiceRequests' =>  $myServiceRequests, 
         
        ]);
    }

    public function clientRequestDetails($language, $request){
        $requestDetail = ServiceRequest::where('uuid', $request)->first();
        foreach ($requestDetail->technicians as $value) {
            if( $value->roles[0]->slug == 'technician-artisans'){
              $technician = $value;
            }
        }
      
        $data = [
            'requestDetail'   =>  $requestDetail,
            'technician'      =>    $technician
        ];
        return view('client.request_details', $data);
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

        $updateContactRequest = Contact::where('user_id', auth()->user()->id)->update([
            'phone_number'          =>   $request->phone_number,
            'address'               =>   $request->address,
        ]);

        if($updateServiceRequest){
          //acitvity log
            return redirect()->route('client.requests', app()->getLocale())->with('success', $requestExist->unique_id.' was successfully updated.');

        }else{

     //acitvity log
            return back()->with('error', 'An error occurred while trying to update a '.$requestExist->unique_id.' service request.');
        }
       
        return back()->withInput();
    }


    public function cancelRequest(Request $request, $language, $id){

        $requestExists = ServiceRequest::where('uuid', $id)->first();
       

        if($requestExists->status_id == '3'){
            return back()->with('error', 'Sorry! This service request('.$requestExists->unique_id.') has already been completed.');
        }

        //Validate user input fields
        $request->validate([
            'reason'       =>   'required',
        ]);

        if(!empty($requestExists->clientDiscounts)){
            $rate = $requestExists->clientDiscounts[0]->discount->rate;
            $refundAmount = floor( (float)$requestExists->total_amount -((float)$rate * (float)$requestExists->total_amount / 100) );
        }else{
            $refundAmount = $requestExists->total_amount;
        }


        $walTrans = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
        $closingBalance =  $walTrans->closing_balance;
        $NewWalletbalance = floor((float)$refundAmount + (float)$closingBalance);

        //service_request_status_id = Pending(1), Ongoing(4), Completed(3), Cancelled(2) 
        $cancelRequest = ServiceRequest::where('uuid', $id)->update([
            'status_id' =>  '2',
        ]);

        $jobReference = $requestExists->unique_id;

        //Create record in `service_request_progress` table
        $recordServiceProgress = ServiceRequestProgress::create([
            'user_id'                       =>  Auth::id(), 
            'service_request_id'            =>  $requestExists->id, 
            'status_id'                     => '2',
            'sub_status_id'                 => '1'
        ]);

        $recordCancellation = ServiceRequestCancellation::create([
            'user_id'                       =>  Auth::id(), 
            'service_request_id'            =>  $requestExists->id, 
            'reason'                        =>  $request->reason,
        ]);
  
      
        $walTrans = new WalletTransaction;
        $walTrans->user_id = auth()->user()->id;
        $walTrans->payment_id = '12';
        $walTrans->amount =  $requestExists->total_amount;
        $walTrans->payment_type = 'refund';
        $walTrans->unique_id = $requestExists->unique_id;
        $walTrans->transaction_type = 'credit';
        $walTrans->opening_balance =  $closingBalance;
        $walTrans->closing_balance = $NewWalletbalance;
        $walTrans->save();


        $clientId = $requestExists->client->id;
        $clientName = $requestExists->client->account->first_name. ' '.$requestExists->client->account->last_name;
        $clientEmail = $requestExists->client->email;
        $reason = $request->reason;
        $jobReference = $requestExists->unique_id;
        $supervisorId = 'dev@fix-master.com';

     

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

            //Record crurrenlty logged in user activity
            //activity log
            return redirect()->route('client.requests', app()->getLocale())->with('success', $requestExists->unique_id.' was successfully updated.');

        }else{
            //Record Unauthorized user activity
         //activity log
            return back()->with('error', 'An error occurred while trying to cancel '.$jobReference.' service request.');
        }

        return back()->withInput();
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
        // return view('client.profile', $data);
        // $data['client'] = Client::where('user_id',auth()->user()->id)->first();
        $data['client'] = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
       
        // $data['user'] =  User::where('id', auth()->user()->id)->first();
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();

        $data['lgas'] = Lga::select('id', 'name')->orderBy('name', 'ASC')->get();
        // dd($data['lga'] );       
        // echo "<pre>";
        // print_r($data['client']->user->phones[0]->number);
        // echo "<pre>";
        return view('client.settings', $data);
    }


    public function update_profile(Request $request)
    {
        $img = $request->file('profile_avater');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $validatedData = $request->validate([            
            'first_name'  => 'required|max:255',
            'middle_name' => 'required|max:255',
            'last_name'   => 'required|max:255',
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

         //user table
        $user_data = User::find(auth()->user()->id);
        $user_data['email'] = $request->email; 
        $user_data->update(); 
        // dd($validatedData);        

        // update phones
        $phones = Phone::where('user_id', auth()->user()->id)->orderBy('id','DESC')->first();         
        $phones->number = $request->phone_number;
        $phones->update();
        // update address
        $addresses = Address::where('user_id', auth()->user()->id)->orderBy('id','DESC')->first();         
        $addresses->address = $request->full_address;
        $addresses->update();
        

            //  $client_data = Account::find(auth()->user()->id); 
             $client_data = Account::where('user_id', auth()->user()->id)->orderBy('id','DESC')->first();
            // if ($client_data->user_id) {                
                //account table                         
                $client_data->first_name = $request->first_name;
                $client_data->middle_name = $request->middle_name;
                $client_data->last_name = $request->last_name;     
                $client_data->gender = $request->gender;      
                
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
                    $client_data->avatar = $imageName; 
                }else{
                    // $imageName = $request->input('old_avatar'); profile_avater
                    $client_data->avatar = $request->input('old_avatar');                    
                }
                    
                $client_data->state_id = $request->state_id;                      
                $client_data->lga_id = $request->lga_id;  
                $client_data->save();
                // dd($client_data);
            // } 


        // if($user_data){
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

            // if (!WalletTransaction::where('unique_id', '=', $client['unique_id'])->exists()) {
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
            // }else{
            //     $walTrans = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
            //     $walTrans['opening_balance'] = $walTrans->closing_balance;
            //     $walTrans['closing_balance'] = $walTrans->opening_balance + $data->amount;
            //     $walTrans->update(); 
            // }

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
        //Return Service details     
        $data['myContacts'] = Contact::where('user_id', auth()->user()->id)->get();   
        // dd($data['myContacts']);
        return view('client.services.quote', $data);
    }

    // $serviceRequests = ServiceRequestAssigned::where('user_id', Auth::id())->with('service_request')->get();

    // return $serviceRequests;

    public function serviceRequest(Request $request){
        $validatedData = $request->validate([            
            'balance'                   =>   'required',
            // 'booking_fee'               =>   'required',
            'timestamp'                 =>   'required',
            'payment_method'            =>   'required',          
          ]);
        
            $all = $request->all();
            // dd($all);

            // if payment method is wallet
            if($request->payment_method == 'Wallet'){
                // if wallet balance is less than the service fee
                if($request->balance > $request->booking_fee){
                    $service_request                        = new Servicerequest;  
                    $service_request->uuid                  = auth()->user()->uuid;
                    $service_request->client_id             = auth()->user()->id;
                    $service_request->service_id            = $request->service_id;
                    $service_request->unique_id             = 'REF-'.$this->generateReference();
                    $service_request->price_id              = $request->price_id;
                    $service_request->phone_id              = $request->phone_number;
                    $service_request->address_id            = $request->address;
                    $service_request->client_discount_id    = $request->client_discount_id;
                    $service_request->client_security_code  = 'SEC-'.strtoupper(substr(md5(time()), 0, 8));
                    $service_request->status_id             = '1';
                    $service_request->description           = $request->description;

                    $theDiscount = ClientDiscount::with('discount')->orderBy('id','DESC')->firstOrFail();
                    if ($service_request->client_discount_id == '1') {                
                        $service_request->total_amount          = $request->booking_fee;
                        // $service_request->total_amount          = (100 - $theDiscount->discount->rate ) / 100 * $request->booking_fee  ;
                    
                        // $user_data = ClientDiscount::find(auth()->user()->id);
                        // $client_discount = ClientDiscount::where('client_id', auth()->user()->id)->orderBy('id','DESC')->firstOrFail();
                        // $client_discount['availability'] = 'used'; 
                        // $client_discount->update();
                        
                    }else {
                        $service_request->total_amount          = $request->booking_fee;
                    }                   
                    // $var = $request->timestamp;
                    // $formattedDate = str_replace('/', '-', $var); 

                    $service_request->preferred_time        = date("Y-m-d");

                    $client = \App\Models\Client::where('user_id', $request->user()->id)->with('user')->orderBy('id','DESC')->firstOrFail();
                    // dd($client->user->account->state_id);

                    if ($request->use_my_address === 'yes') {
                        // dd($client->user->contact->state_id);
                        $service_request->state_id        = $client->user->account->state_id;
                        $service_request->lga_id          = $client->user->account->lga_id;
                        
                    // }elseif ($service_request->use_my_address == null) {
                        # else...
                        // $service_request->state_id        = $request->alternate_address;
                        // $service_request->lga_id          = $request->alternate_address;
                    }
                    if ($request->use_my_phone_number == 'yes') { 
                        $service_request->phone_id        = $client->user->contact->id;
                        $service_request->address_id      = $client->user->contact->id;
                    // }elseif ($service_request->use_my_phone_number == null) {
                        # else...
                        // $service_request->state_id        = $request->alternate_phone_number;
                    }
                    // $service_request->town_id         = '';
                    $service_request->save();
                   
                    // fetch the Client Table Record
                    $client = \App\Models\Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
                    // generate reference string for this transaction            
                    $generatedVal = $this->generateReference();        
                    // call the payment Trait and submit record on the
                    $payment = $this->payment($service_request->total_amount, 'wallet', 'service-request', $client['unique_id'], 'success', $generatedVal);
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

                            return back()->with('success', 'Success! Transaction was successful and your request has been placed.');
                        }                        
                    }
                    
                }else{
                     return back()->with('error', 'Sorry!, your current wallet balance is less than the booking fee. Please use other payment methods.');
                    }           
                } 
                if ($request->payment_method == 'Online') {
                    return back()->with('error', 'online payment coming soon');
                } else{
                    return back()->with('error', 'sorry!, an error occured please try again');
                  } 

                if ($request->payment_method == 'Offline') {
                    return back()->with('error', 'please send us a ticket with your payment reference, we would contact you');
                } else{
                    return back()->with('error', 'sorry!, an error occured please try again');                    
                }
            }
            
            public function getDistanceDifference(Request $request){

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
                // // ->select(DB::raw('contacts.*,1.609344 * 3956 * 2 * ASIN(SQRT( POWER(SIN((" . $latitude . " - abs(address_latitude)) *  pi()/180 / 2), 2) + COS(" . $latitude . " * pi()/180) * COS(abs(address_latitude) * pi()/180) * POWER(SIN((" . $longitude . " - address_longitude) * pi()/180 / 2), 2)  )) AS calculatedDistance'))
                ->select(DB::raw('cses.*, contacts.address, accounts.first_name, users.email,  6353 * 2 * ASIN(SQRT( POWER(SIN(('.$latitude.' - abs(address_latitude)) * pi()/180 / 2),2) + COS('.$latitude.' * pi()/180 ) * COS(abs(address_latitude) *  pi()/180) * POWER(SIN(('.$longitude.' - address_longitude) *  pi()/180 / 2), 2) )) as distance'))
                ->having('distance', '<=', $radius)
                ->orderBy('distance', 'DESC')
                ->get();
               
                // if ( count($cse) > 0) {
                    // dd($cse);
                    foreach ($cse as $key => $cses){
                        // dd($cses['email']);
                        // echo $cse[$key]->email;
                    

                        $mail = new PHPMailer;
                        $mail->isSMTP();                            // Set mailer to use SMTP
                        $mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
                        $mail->SMTPAuth = true;                     // Enable SMTP authentication
                        $mail->Username = 'denkogy@gmail.com'; // your email id
                        $mail->Password = 'Chemistry!1'; // your password
                        $mail->SMTPSecure = 'tls';                  
                        $mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
                        $mail->setFrom('denkogy@gmail.com', 'Name');
                        $mail->addAddress('denkogee@yahoo.com');   // Add a recipient
                        $mail->isHTML(true);  // Set email format to HTML
        
                        $bodyContent = '<h1>HeY!,</h1>';
                        $bodyContent .= '<p>This is a email that Radhika send you From LocalHost using PHPMailer</p>';
                        $mail->Subject = 'Email from Localhost by Radhika';
                        $mail->Body    = $bodyContent;
                        if(!$mail->send()) {
                        echo 'Message was not sent.';
                        echo 'Mailer error: ' . $mail->ErrorInfo;
                        } else {
                        echo 'Message has been sent.';
                        }

                    // $mail = new PHPMailer(true);

                    // try {
                    //     //Server settings
                    //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    //     $mail->isSMTP();                                            //Send using SMTP
                    //     $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    //     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    //     $mail->Username   = 'denkogy@gmail.com';                     //SMTP username
                    //     $mail->Password   = 'Chemistry!1';                               //SMTP password
                    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    //     $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    
                    //     //Recipients
                    //     $mail->setFrom('denkogy@gmail.com', 'New Request!');

                    //     // for ($i=0; $i < count($cse); $i++) { 
                    //         // echo json_encode($cse[$i]["email"]);
                    //         // echo $cse[$i]->email;
                    //         $mail->addAddress($cse[$key]->email);
                    //     // }                       
                    // $denko = 'Denkogee';
                    //     //Content
                    //     $mail->isHTML(true);        
                    //     $mail->Subject = 'Request Successful!';
                    //      $mail->Body  = 'First Name: <strong>' .$denko. 
                    //                       '<br/>';
                    //             $mail->send();
                    //                 if ( $mail->send() ) { 
                    //                 return back()->with('success', 'Your Request has been sent Successful');
                    //                 }
                    //             echo 'Message has been sent';
                    //         } catch (Exception $e) {
                    //             echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    //         }
                }
            }
            // }


            public function sendMailToAdmin(Request $request){
                $mail = new PHPMailer(true);
                $user = Auth::user();
    
                // dd($setting);
                // if ($setting->is_smtp == 1) {    
                //     try {
                //         //Server settings
                //         $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                //         $mail->isSMTP();                                            //Send using SMTP
                //         $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                //         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                //         $mail->Username   = 'denkogy@gmail.com';                     //SMTP username
                //         $mail->Password   = 'Chemistry!1';                               //SMTP password
                //         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                //         $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    
                //         //Recipients
                //         $mail->setFrom('denkogy@gmail.com', 'New Order Placed!!!');
                //         $mail->addAddress($request->email, $request->FirstName);
                    
                //         //Content
                //         $mail->isHTML(true);        
                //         $mail->Subject = 'Request Successful!';
                //          $mail->Body  = 'First Name: <strong>' .$request['f_name']. 
                //                           '<br/>
                //                           Last Name: <strong>' .$request->LastName.  
                //                           '<br/>';
                //                 $mail->send();
                //                     if ( $mail->send() ) { 
                //                     return back()->with('success', 'Your Request has been sent Successful');
                //                     }
                //                 echo 'Message has been sent';
                //             } catch (Exception $e) {
                //                 echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                //             }    
                // }
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

    /**
     * Get all my contact for all the services i have requested
     * @return \Illuminate\Http\Response
     */
    // public function myContactList(){
    //     // $data['myContacts'] = Contact::orderBy('id','DESC')->get();
    //     $myContacts = Client::where('user_id', auth()->user()->id)->with('contact')->get();
    //     // dd($data['myContacts']);
    //     return $myContacts;
    // }

    public function myServiceRequest(){
        $myRequest = Client::where('user_id', auth()->user()->id)->with('service_request')->firstOrFail();
        $data['myServiceRequests'] = $myRequest->service_request;
        // return $data['myServiceRequests'];
        return view('client.services.list', $data);

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


}
