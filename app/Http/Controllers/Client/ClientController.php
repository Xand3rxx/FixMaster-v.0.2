<?php

namespace App\Http\Controllers\Client;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Cse;
use App\Models\Lga;
use App\Models\User;
use App\Models\State;
use App\Models\Client;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Town;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Category;
use App\Traits\Services;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\SMTP;
use App\Models\ClientDiscount;
use App\Models\PaymentGateway;
use App\Models\ServiceRequest;
use App\Traits\PasswordUpdator;
use App\Models\LoyaltyManagement;
use App\Models\WalletTransaction;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequestProgress;
use App\Models\ServiceRequestCancellation;
use App\Models\ServiceRequestWarranty;
use App\Traits\Utility;
use App\Traits\Loggable;
use App\Models\ServiceRequestSetting;
use App\Models\ServiceRequestMedia;
use App\Models\Media;
use Image;
use File;
use App\Http\Controllers\Client\PaystackController;

use Illuminate\Support\Facades\Route;
use App\Models\ClientLoyaltyWithdrawal;
use App\Http\Controllers\RatingController;
use App\Traits\RegisterPaymentTransaction;
use App\Traits\GenerateUniqueIdentity as Generator;
use App\Http\Controllers\Messaging\MessageController;
use Illuminate\Support\Facades\Validator; 
use App\Models\Warranty;
use App\Models\ServicedAreas;


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

        return view('client.home', [
            // data
            'totalRequests'     => auth()->user()->clientRequests()->count(),
            'completedRequests' => auth()->user()->clientRequests()->where('status_id', 4)->count(),
            'cancelledRequests' => auth()->user()->clientRequests()->where('status_id', 3)->count(),
            'user' => auth()->user()->account,
            'client' => [
                'phone_number' => auth()->user()->contact->phone_number ?? 'UNAVAILABLE',
                'address' => auth()->user()->contact->address ?? 'UNAVAILABLE',
            ],
            'popularRequests'  =>  $popularRequests,
            'userServiceRequests' =>  $myRequest,

        ]);
    }

    public function clientRequestDetails($language, $request){

        $requestDetail = ServiceRequest::where('uuid', $request)->with('service_request_assignees')->firstOrFail();
        
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
        $validatedData = $request->validate([
            'first_name'  => 'required|max:255',
            'gender'   => 'required',
            'phone_number'   => 'required|max:255',
            'email'       => 'required|email|max:255',
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

        if($request->hasFile('profile_avater')) {
            $image = $request->file('profile_avater');
            $imageName = sha1(time()) . '.'.$image->getClientOriginalExtension();
            $imagePath = public_path('assets/user-avatars').'/'.$imageName;
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
        $data['mytransactions']   = Payment::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->with('wallettransactions')->get();
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // return $data['mytransactions'][0]->wallettransactions->transaction_type;
        // return view('client.wallet', $data);
        return view('client.wallet', compact('myWallet')+$data);
    }

    public function walletSubmit(Request $request)
    {
        // get the last wallet transaction of the loggedIn client
        $myWallet    = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // validate Request
        $valid = $this->validate($request, [
            // List of things needed from the request
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
            //check the payment method selected
              switch ($paymentRecord->payment_channel) {
                  case 'paystack':
                    // Use paymentcontroller method in this controller
                    $return = $this->initiatePayment($request, $generatedVal, $paymentRecord, $user);

                    $return = redirect()->route('client.ipn.paystack', app()->getLocale());
                  break;
                  case 'flutterwave':
                    // $this->initiatePayment();
                    // $return = redirect()->route('client.ipn.flutter', app()->getLocale());

                    $flutter['amount'] = $paymentRecord->amount;
                    $flutter['track'] = Session::get('Track');
                    $client = User::find(auth()->user()->id);

                    // return redirect()->route('client.payment-flutterwave-start', app()->getLocale());
                    // dd($flutter);
                    // return view('client.payment.flutter', compact('flutter', 'client'));

                    $return = $paystack_controller->initiatePayment($request, $generatedVal, $paymentRecord, $user);

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
        $data['myContacts'] = Contact::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
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

            // public function initiatePayment(){
            //     $track  = Session::get('Track');
            //     // dd($track);
            //     $data = Payment::where('reference_id', $track)->orderBy('id', 'DESC')->first();
            //     //  dd($data);
            //     $user = User::find($data->user_id);
            //     if($user){

            //         $curl = curl_init();

            //         curl_setopt_array($curl, array(
            //             CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            //             CURLOPT_RETURNTRANSFER => true,
            //             CURLOPT_CUSTOMREQUEST => "POST",
            //             CURLOPT_POSTFIELDS => json_encode([
            //                 'amount' => $data->amount * 100,
            //                 'email' => $user->email,
            //                 'callback_url' => route('client.serviceRequest.verifyPayment', app()->getLocale())
            //             ]),
            //             CURLOPT_HTTPHEADER => [
            //                 "authorization: Bearer sk_test_b612f25bd992c4d84760e312175c7515336b77fc",
            //                 "content-type: application/json",
            //                 "cache-control: no-cache"
            //             ],
            //         ));

            //         $response = curl_exec($curl);
            //         $err = curl_error($curl);
            //         if ($err) {
            //             return back()->with('error', $err);
            //         }

            //         $tranx = json_decode($response, true);

            //         if (!$tranx['status']) {
            //             return back()->with('error', $tranx['message']);
            //         }
            //         return redirect($tranx['data']['authorization_url']);

            //     }else{
            //         return back()->with('error', 'Error occured while making payment');
            //     }

            // }




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
        $service = $this->service($uuid);
        $rating = Rating::where('service_id', $service->id)
                    ->where('service_request_id', null)
                    ->where('service_diagnosis_by', null)
                    ->where('ratee_id', '!=', null)->get();
        $reviews = Review::where('service_id', $service->id)->where('status', 1)->get();
        return view('client.services.show', compact('service','rating','reviews'));
        //return view('client.services.show', ['service' => $this->service($uuid)]);
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
     * Save custom request ['service_requests']
     * @return \Illuminate\Http\Response
     */
    public function customService(){
        $data['bookingFees']  = $this->bookingFees();
        $data['myContacts'] = Contact::where('user_id', auth()->user()->id)->latest('created_at')->get();
        $data['discounts']    = $this->clientDiscounts();
        $data['gateways']     = PaymentGateway::whereStatus(1)->orderBy('id', 'DESC')->get();
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();
        $data['balance']      = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();

        return view('client.services.service_custom', $data);
    }


    public function myServiceRequest(){

        $myServiceRequests = Client::where('user_id', auth()->user()->id)
            ->with('service_requests.invoices')
            ->whereHas('service_requests', function ($query) {
                        $query->orderBy('created_at', 'ASC');
            })->get();

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

        $data['ewallet'] =  !empty($walTrans->closing_balance) ? $walTrans->closing_balance : 0;
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
            $walTrans->payment_type = 'loyalty';
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

    public function saveRequest($request){
        // return dd($request);

        $service_request                        = new ServiceRequest();
        $service_request->client_id             = auth()->user()->id;
        if ( $request['service_id'] ) {
            $service_request->service_id            = $request['service_id'];
        }
        // $service_request->unique_id             = 'REF-'.$this->generateReference();
        $service_request->price_id              = $request['price_id'];
        $service_request->contact_id              = $request['myContact_id'];
        // $service_request->client_discount_id    = $request['client_discount_id'];
        // $service_request->client_security_code  = 'SEC-'.strtoupper(substr(md5(time()), 0, 8));
        $service_request->status_id             = '2';
        $service_request->description           = $request['description'];
        $service_request->total_amount          = $request['booking_fee'];
        $service_request->preferred_time        = Carbon::parse($request['timestamp'], 'UTC');
        $service_request->has_client_rated      = 'No';
        $service_request->has_cse_rated         = 'No';
        $service_request->created_at            = Carbon::now()->toDateTimeString();
        // $service_request->updated_at         = Carbon::now()->toDateTimeString();

        if ($service_request->save()) {
            $saveToMedia = new Media();
            $saveToMedia->client_id     = auth()->user()->id;
            $saveToMedia->original_name = $media['original_name'];
            $saveToMedia->unique_name   = $media['unique_name'];
            $saveToMedia->save();

        //     $saveServiceRequestMedia = new ServiceRequestMedia;
        //     $saveServiceRequestMedia->media_id            = $saveToMedia->id; 
        //     $saveServiceRequestMedia->service_request_id  = $service_request->id;
        //     $saveServiceRequestMedia->save(); 



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
                'created_at'            =>  \Carbon\Carbon::now('UTC'),
            ),
            array(
                'user_id'               =>  1,
                'service_request_id'    =>  $service_request->id,
                'status_id'             =>  1,
                'sub_status_id'         =>  1,
                'created_at'            =>  \Carbon\Carbon::now('UTC'),
            ),
            array(
                'user_id'               =>  $cseArray[$randomCSE],
                'service_request_id'    =>  $service_request->id,
                'status_id'             =>  2,
                'sub_status_id'         =>  8,
                'created_at'            =>  \Carbon\Carbon::now('UTC'),
            )
        );

        $serviceRequestAssign = array(
            'user_id'               =>  $cseArray[$randomCSE],
            'service_request_id'    =>  $service_request->id,
            'job_accepted'          =>  'Yes',
            'job_acceptance_time'   =>  \Carbon\Carbon::now('UTC'),
            'status'                =>  'Active',
            'created_at'            =>  \Carbon\Carbon::now('UTC'),
        );

        DB::table('service_request_progresses')->insert($serviceRequestProgresses);

        //Create CSE record on `service_request_assigned` table
        DB::table('service_request_assigned')->insert($serviceRequestAssign);


        return $service_request;
        }
    }

    public function editRequest($language, $request){ 
        // return $request;
        $userServiceRequest = ServiceRequest::where('uuid', $request)->with('service_request_medias')->first();

        $data = [
            'userServiceRequest'    =>  $userServiceRequest,
        ];
        // return $data['userServiceRequest']['service_request_medias'][0]['media_files']['unique_name'];
        // return $data['userServiceRequest']['service_request_medias'][0]['media_files']['unique_name'];
        return view('client._request_edit', $data);
    }

    public function updateRequest(Request $request, $language, $id){
        // return $request->servicereq;
        $requestExist = ServiceRequest::where('uuid', $id)->first();

        $request->validate([
            'timestamp'             =>   'required',
            // 'phone_number'          =>   'required', 
            // 'address'               =>   'required',
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
        
        // upload multiple media files
        foreach($request->media_file as $key => $file)
        {
            $originalName[$key] = $file->getClientOriginalName();

            $fileName = sha1($file->getClientOriginalName() . time()) . '.'.$file->getClientOriginalExtension();
            $filePath = public_path('assets/service-request-media-files');
            $file->move($filePath, $fileName);
            $data[$key] = $fileName; 
        }
        $unique_name   = json_encode($data);
        $original_name = json_encode($originalName);

        $saveToMedia = new Media();
        $saveToMedia->client_id     = auth()->user()->id;
        $saveToMedia->original_name = $original_name;
        $saveToMedia->unique_name   = $unique_name;
        $saveToMedia->save();

        $saveServiceRequestMedia = new ServiceRequestMedia;
        $saveServiceRequestMedia->media_id            = $saveToMedia->id; 
        $saveServiceRequestMedia->service_request_id  = $request->servicereq;
        $saveServiceRequestMedia->save();        

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

            /**************************************************************/
            /*******************REFUND MONEY TO WALLET STARTS**************/
            /**************************************************************/
            $client = Client::where('user_id', auth()->user()->id)->firstOrFail();

            // get last payment details
            $lastPayment  = Payment::where('unique_id', $client->unique_id)->orderBy('id', 'DESC')->first();

                $walTrans = new WalletTransaction;
                $walTrans['user_id']          = auth()->user()->id;
                $walTrans['payment_id']       = $lastPayment->id;
                $walTrans['amount']           = $request->amountToRefund;
                $walTrans['payment_type']     = 'refund';
                $walTrans['unique_id']        = $lastPayment->unique_id;
                $walTrans['transaction_type'] = 'credit';
                // if the user has not used this wallet for any transaction
                if (!WalletTransaction::where('unique_id', '=', $client['unique_id'])->exists()) {
                $walTrans['opening_balance'] = '0';
                $walTrans['closing_balance'] = $request->amountToRefund;
                }else{
                    $previousWallet = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
                    $walTrans['opening_balance'] = $previousWallet->closing_balance;
                    $walTrans['closing_balance'] = $previousWallet->closing_balance + $request->amountToRefund;
                }
                // save record
                $walTrans->save();


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




    // public function addToWallet(){

    //     /** If the transaction status are successful send to DB */
    //     // if ($data->status == 'pending') {
    //     //     $data['status'] = 'success';
    //     //     $data['transaction_id'] = rawurlencode($reference);
    //     //     $data->update();
    //     //     $track = Session::get('Track');

    //         // client
    //         $client = Client::where('user_id', auth()->user()->id)->firstOrFail();

    //         // get last payment details
    //         $lastPayment  = Payment::where('unique_id', $client->unique_id)->orderBy('id', 'DESC')->first();

    //         // if (!WalletTransaction::where('unique_id', '=', $client['unique_id'])->exists()) {
    //             $walTrans = new WalletTransaction;
    //             $walTrans['user_id'] = auth()->user()->id;
    //             $walTrans['payment_id'] = $lastPayment->id;
    //             $walTrans['amount'] = $data->amount;
    //             $walTrans['payment_type'] = 'funding';
    //             $walTrans['unique_id'] = $data->unique_id;
    //             $walTrans['transaction_type'] = 'debit';
    //             // if the user has not used this wallet for any transaction
    //             if (!WalletTransaction::where('unique_id', '=', $client['unique_id'])->exists()) {
    //             $walTrans['opening_balance'] = '0';
    //             $walTrans['closing_balance'] = $data->amount;
    //             }else{
    //                 $previousWallet = WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
    //                 $walTrans['opening_balance'] = $previousWallet->closing_balance;
    //                 $walTrans['closing_balance'] = $previousWallet->closing_balance + $data->amount;
    //             }
    //             // dd($walTrans);
    //             $walTrans->save();

    //     }



    public function warrantyInitiate(Request $request, $language, $id){

        $request->validate([
            'reason'       =>   'required',
        ]);

        $admin = User::where('id', 1)->with('account')->first();
        $requestExists = ServiceRequest::where('uuid', $id)->with('client')->first();
        $cses  = \App\Models\Cse::with('user', 'user.account', 'user.contact', 'user.roles')->get();
        $mail1 = '';  $mail2= '';

        $initateWarranty = ServiceRequestWarranty::where('service_request_id',  $requestExists->id)->update([
            'status'            => 'used',
            'initiated'         => 'Yes',
            'reason'            => $request->reason,
            'date_initiated'    =>  \Carbon\Carbon::now('UTC'),
        ]);

        //send mail 1, admin, 2, client, 3 cse
       if($initateWarranty) { 

        $mail_data_admin = collect([
            'email' =>  $admin->email,
            'template_feature' => 'ADMIN_WARRANTY_CLAIM_NOTIFICATION',
            'firstname' =>  $admin->account->first_name,
            'customer_name' => Auth::user()->account->first_name.' '.Auth::user()->account->last_name,
            'customer_email' => Auth::user()->email,
            'job_ref' =>  $requestExists->unique_id
          ]);
          $mail1 =$this->mailAction($mail_data_admin);
       
        }
 
      
        if($mail1) { 
          $mail_data_client = collect([
            'email' =>  Auth::user()->email,
            'template_feature' => 'CUSTOMER_WARRANTY_CLAIM_NOTIFICATION',
            'customer_name' => Auth::user()->account->first_name.' '.Auth::user()->account->last_name,
            'job_ref' =>  $requestExists->unique_id
          ]);
          $mail2 = $this->mailAction($mail_data_client);
        }

        if($mail2) { 
          foreach($cses as $cse){
          
            $mail_data_cse = collect([
                'email' =>   $cse['user']['email'],
                'template_feature' => 'ADMIN_WARRANTY_CLAIM_NOTIFICATION',
                'firstname' => $cse['user']['account']['first_name'] ,
                'customer_name' => Auth::user()->account->first_name.' '.Auth::user()->account->last_name,
                'customer_email' => Auth::user()->email,
                'job_ref' =>  $requestExists->unique_id
              ]);
              $mail1 = $this->mailAction($mail_data_cse);
          };
          
        }

       

        if($initateWarranty){

            return redirect()->route('client.service.all', app()->getLocale())->with('success', $requestExists->unique_id.' warranty was successfully initiated.Please check your mail for notification');

          }else{
            return back()->with('error', 'An error occurred while trying to initiate warranty for'.  $requestExists->unique_id.' service request.');

          }
    }


    public function reinstateRequest(Request $request, $language, $id){

        $requestExists = ServiceRequest::where('uuid', $id)->firstOrFail();
        //service_request_status_id = Pending(1), Ongoing(2), Completed(4), Cancelled(3)
        $reinstateRequest = ServiceRequest::where('uuid', $id)->update([
            'status_id' =>  '1',
        ]);

        $jobReference = $requestExists->unique_id;

        //Create record in `service_request_progress` table
        // $recordServiceProgress = ServiceRequestProgress::where(['service_request_id'=> $requestExists->id, 'user_id' => Auth::id()])->update([
        //     'status_id'                     => '1',
        //     'sub_status_id'                 => '1'
        // ]);

        // $recordCancellation = ServiceRequestCancellation::where(['service_request_id'=> $requestExists->id, 'user_id' => Auth::id()])->delete();

        // if($cancelRequest AND $recordServiceProgress AND $recordCancellation){
        if($reinstateRequest){

            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') reinstated '. $jobReference.' service request.');

            return back()->with('success', $jobReference.' service request was reinstated successfully.');

        }else{
            //Record Unauthorized user activity
         //activity log
            return back()->with('error', 'An error occurred while trying to cancel '.$jobReference.' service request.');
        }

    }

    public function markCompletedRequest(Request $request, $language, $id){

        $requestExists = ServiceRequest::where('uuid', $id)->firstOrFail();

        $updateMarkasCompleted =  $this->markCompletedRequestTrait(Auth::id(), $id);

        if($updateMarkasCompleted ){

            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') marked '.$requestExists->unique_id.' service request as completed.');

            return redirect()->route('client.service.all', app()->getLocale())->with('success', $requestExists->unique_id.' was marked as completed successfully.Please check your mail for notification');
        }else{

         //activity log
            return back()->with('error', 'An error occurred while trying to mark '.$requestExists->unique_id.' service request as completed.');
        }
    }


    public function discount_mail(Request $request ){
        if ($request->ajax())
        {
    
         $data= $request->user;

        $response =  $this->addDiscountToFirstTimeUserTrait($request->user());
        if( $response == '1' ){
            $referralResponse = $this->updateVerifiedUsers($request->user());
        }
      
        return response()->json($referralResponse);
        }
      }
}

