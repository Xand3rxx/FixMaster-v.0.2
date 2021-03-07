<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;
use Route;
use Auth;
use App\Traits\Loggable;


class TransactionController extends Controller
{
    use Loggable;
    public function eWallet()
    {
        $user = auth()->user()->id;
       
        return view('client.wallet', compact('user'));
    }


    /*public function store(Request $request) { 
        $contact = new Contact;
  
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->mobile_number = $request->mobile_number;
        $contact->message = $request->message;
  
        $contact->save();
        
        return response()->json(['success'=>'Form is successfully submitted!']);
  
      }*/



    public function initiateTransaction(Request $request)
    {
        $data = request()->validate([
            'amount' => 'required',
        ]);

        $transaction = new Transaction;

        $transaction->amount = $request->amount;
        $transaction->transaction_type_id = $request->amount;
        $transaction->wallet_id = $request->amount;
        $transaction->opening_balance = $request->amount;
        $transaction->closing_balance = $request->amount;
        $transaction->external_reference = $request->amount;
        $transaction->receipt_no= Str::random(6);
        $transaction->status= Str::random(2);
        //$transaction->id = auth()->user()->id;
        $transaction->reference = Str::random(6);//this will enable us to trace the transaction from our end

        $transaction->save();

       /* DB::beginTransaction();

        try {
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        
        }*/
    
        
    }

    public function updateTransaction(Request $request, $id)
    {
        $data = request()->validate([
            'external_reference' => 'string',
            'status' => 'string',
            
        ]);

        
        $transaction = Transaction::where('reference', $data)->first();

        $paymentProcessor = PaymentProcessor::find($transaction->id);  
    
        $class = 'Class'.$paymentProcessor;
        $paymentProcessor = new $class();
        
        $transaction->external_reference = $data->external_reference;
        $transaction->status = $data->status;
        
        $transaction->save();

        DB::beginTransaction();

        try {
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        
        }
    }


    public function userTransaction($language, Transaction $userTransaction)
    {
      
        $user_id = auth()->user()->id; // gets the current user id
       
        $userTransaction = Transaction::where('id', $user_id)->orderBy('id', 'DESC')->paginate(15);
        
        //$states = State::all();
        return view('client.user_wallet_transaction', compact('userTransaction'));
        
              
    }
    //Handles all clients transaction view from the admin end
    public function adminUserTransaction($language, Transaction $userTransaction)
    {
      
           
        $userTransaction = Transaction::all();
        return view('client.wallet_transaction_history', compact('userTransaction'));
            
    }

    public function adminTransactionSummary($language, Transaction $transaction)
    {
        return view('admin.ewallet.transaction_summary', compact('transaction'));
    }

// handles Transaction approved status
    public function transactionApproval($language, Transaction $transaction)
    {
        $approveTransaction = $transaction->update([
            'status'  => '1'
            //'is_active'  => '0'
        ]);

        if($approveTransaction) {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' approved '.$transaction->id;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.wallet_transaction', app()->getLocale())->with('success', 'Transaction approved');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to approve this transaction'.$transaction->wallet_id;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }
//handles transaction pending status
    public function transactionPending($language, Transaction $transaction)
    {
        $approveTransaction = $transaction->update([
            'status'  => '0'
            //'is_active'  => '0'
        ]);

        if($approveTransaction) {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' pending '.$transaction->id;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.wallet_transaction', app()->getLocale())->with('success', 'Transaction has been changed to Pending');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to approve this transaction'.$transaction->wallet_id;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }
    //Handles deleting transaction. only admin can do this

    public function deleteTransaction($language, Transaction $transaction)
    {
        $deleteTransaction = $transaction->delete();
        if ($deleteTransaction){
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$transaction->estate_name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.wallet_transaction', app()->getLocale())->with('success', 'Transaction deleted successfully');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to delete '.$transaction->reference;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    
    //Handles the display of all e-wallet service request
    public function userEwalletPayment($language, Transaction $userTransaction)
    {
      
        $user_id = auth()->user()->id; // gets the current user id
       
        $userTransaction = Transaction::where('id', $user_id)->orderBy('id', 'DESC')->paginate(15);
        
        return view('client.wallet_payment', compact('userTransaction'));
                      
    }
    //Handles the summary view of each e-wallet service request
    public function eWalletServiceRequestSummary($language, Transaction $transaction)
    {
        return view('client.wallet_service_request_summary', compact('transaction'));
    }
    //Handles all client e-wallet service request
    public function allUserEwalletPayment($language, Transaction $userTransaction)
    {
      
        $userTransaction = Transaction::all();
        return view('admin.ewallet.all_user_wallet_service_request', compact('userTransaction'));
                   
    }
    //Handles summary of client e-wallet service request at the admin end
    public function adminEWalletServiceRequestSummary($language, Transaction $transaction)
    {
        return view('admin.ewallet.wallet_service_request_summary', compact('transaction'));
    }

    public function refund($language, Transaction $transaction)
    {
        return view('admin.ewallet.wallet_service_request_summary', compact('transaction'));
    }
}
 