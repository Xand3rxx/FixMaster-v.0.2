<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Payment; 
use App\Models\WalletTransaction;
use App\Models\Client; 

use App\Traits\RegisterPaymentTransaction;
use App\Models\ServiceRequestPayment;
use App\Traits\GenerateUniqueIdentity as Generator;

use App\Http\Controllers\Client\ClientController;
use Session;


class EwalletController extends Controller
{
    use RegisterPaymentTransaction, Generator;

    public function store(Request $request)
    {

        $valid = $this->validate($request, [
            // List of things needed from the request like 
            'booking_fee'      => 'required',
            'payment_channel'  => 'required',
            'payment_for'     => 'required',
        ]);

        $client_controller = new ClientController;
        

        if($request->balance > $request->booking_fee){
            // $SavedRequest = $this->saveRequest($request);
            $SavedRequest = $client_controller->saveRequest( $request);
            
            // dd($service_request); 
            if ($SavedRequest) {
    
            // fetch the Client Table Record
            $client = Client::where('user_id', $request->user()->id)->with('user')->firstOrFail();
            // generate reference string for this transaction
            $generatedVal = $this->generateReference();
            // call the payment Trait and submit record on the
            $payment = $this->payment($SavedRequest->total_amount, 'wallet', 'service-request', $client['unique_id'], 'success', $generatedVal);
            // save the reference_id as track in session
            Session::put('Track', $generatedVal);
                if ($payment) {
                    //   new starts here
                    $user_id = auth()->user()->id;
                    // $track = Session::get('Track');
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
                            $service_reqPayment->avatar = $imageName;
                        }
    
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

       
    }


