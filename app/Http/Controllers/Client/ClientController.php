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
use App\Models\Account; 
use App\Models\Phone; 
use App\Models\Address;
use App\Models\Servicerequest;
use App\Helpers\CustomHelpers;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Traits\RegisterPaymentTransaction;
use App\Traits\Services;
use App\Traits\PasswordUpdator;
use Auth;


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
            'popularRequests'   =>  $popularRequests ,
            // 'myWallet'          =>  $myWallet,
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
    public function serviceQuote($language, $uuid){

        //Return Service details
        return view('client.services.quote', [
            'service'       =>  $this->service($uuid),
            'bookingFees'   =>  $this->bookingFees(),
            'discounts'     =>  $this->clientDiscounts(),
        ]);
    }

    // $serviceRequests = ServiceRequestAssigned::where('user_id', Auth::id())->with('service_request')->get();

    // return $serviceRequests;

    public function serviceRequest(Request $request){
        // $validatedData = $request->validate([            
        //     'service_fee'               =>   'required',
        //     'description'               =>   'required',
        //     'timestamp'                 =>   'required',
        //     'phone_number'              =>   'required',
        //     'address'                   =>   'required',
        //     'payment_method'            =>   'required',          
        //   ]);
        
        //   $all = $request->all();
        //     dd($all);


            //Determine if User has a discount of 5% auth()->user()->client->discounted == 1
            // if($request->client_discount_id == 1){
                // $discountServiceFee = null;
                $amount = $request->booking_fee;    
            // }else {
                // $discountServiceFee = 0.95 * $serviceFee;
                // $amount = $discountServiceFee;
            // }

          $service_request                        = new Servicerequest;  
          $service_request->cliend_id             = auth()->user()->id;
          $service_request->service_id            = $request->service_id;
          $service_request->unique_id             = 'REF-'.$this->generateReference();
          $service_request->price_id              = $request->price_id;
          $service_request->phone_id              = $request->phone_number;
          $service_request->address_id            = $request->address;
          $service_request->client_discount_id    = $request->client_discount_id;
          $service_request->client_security_code  = 'SEC-'.strtoupper(substr(md5(time()), 0, 8));
          $service_request->status_id             = '1';
          $service_request->description           = $request->description;
          $service_request->total_amount          = $amount;
          $service_request->preferred_time        = $request->timestamp;
          dd($service_request); 
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

}
