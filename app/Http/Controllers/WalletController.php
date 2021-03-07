<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\WalletTransaction;
use Route;
use Auth;
use App\Traits\Loggable;

use Illuminate\Support\Facades\Input;


class WalletController extends Controller
{
    use Loggable;

    public function walletTransfer(Request $request)
    {
        

        $data = request()->validate([
            'amount' => 'required',
            'destination_wallet_id' => 'string',
                        
        ]);

        $transactionReference = Str::random(6);
        //This part handles transaction debit leg
        $debitTransaction = new Transaction;

        $debitTransaction->amount = $data->amount;
        $debitTransaction->wallet_id = auth()->user()->wallet_id;
        $debitTransaction->reference = $transactionReference;
        $debitTransaction->receipt_number = Str::random(6);
        
        $debitTransaction->save();

        //This part handles transaction credit leg
        $creditTransaction = new Transaction;

        $creditTransaction->amount = $data->amount;
        $creditTransaction->wallet_id = $data->destination_wallet_id;
        $creditTransaction->receipt_number = Str::random(6);
        $creditTransaction->reference = $transactionReference;
        $creditTransaction->save();

        //This part modifies the amount in the model by debiting the user

        $walletToDebit = Wallet::find(auth()->user()->wallet_id);

        $walletToDebit->balance = $walletToDebit->balance - $data->amount;
               
        $walletToDebit->save();

        //This part modifies the amount in the model by crediting the receiver
        $walletToCredit = Wallet::find($data->destination_wallet_id);

        $walletToCredit->balance = $walletToCredit->balance + $data->amount;
               
        $walletToCredit->save();

        DB::beginTransaction();

        try {
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        
        }
        
        }

    public function walletServiceRequestRefund($language, WalletTransaction $userTransaction)
    { 
       
        $userTransaction = WalletTransaction::select('id', 'wallet_id','reference_no', 'firstname', 'lastname', 'email', 'phone', 'amount', 'status', 'opening_balance', 'closing_balance', 'created_at')
            ->orderBy('wallet_transactions.id', 'ASC')
            ->where('wallet_transactions.status', '3')
            ->get();
            return view('admin.ewallet.wallet_service_request_refund', compact('userTransaction'));

    }

    public function walletServiceRequestRefundSummary($language, WalletTransaction $transaction)
    { 
       
        $transaction = WalletTransaction::select('id', 'wallet_id','reference_no', 'firstname', 'lastname', 'email', 'phone', 'amount', 'status', 'opening_balance', 'closing_balance', 'created_at')
            ->orderBy('wallet_transactions.id', 'ASC')
            ->where('wallet_transactions.status', '3')
            ->get();
            return view('admin.ewallet.wallet_service_request_refund_summary', compact('transaction'));

    }


    public function approveRefundSummary($language, Request $request, WalletTransaction $transaction)
    { 
       
       // $this->validateUpdateRequest();
        $amount = $request->input('amount');
        $opening = $request->input('opening_balance');
        $closing = $request->input('closing_balance');
        $new_closing_balance = $amount + $opening;
        
        $updateRefund = $transaction->update([
            'closing_balance' => $new_closing_balance,
            'opening_balance' => $new_closing_balance,
            'amount' => '0'
            ]);

            if($updateRefund) {
                $type = 'Request';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' updated '.$request->input('wallet_id');
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.wallet_refund_summary',['transaction'=>$transaction->id, app()->getLocale()])->with('success', 'Refund has been approved successfully');
                
            } else {
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An Error Occured while '. Auth::user()->email. ' was trying to update '.$request->input('wallet_id');
                $this->log($type, $severity, $actionUrl, $message);
                return back()->with('error', 'An error occurred');
            }

            //return view('admin.ewallet.wallet_service_request_refund_summary', compact('transaction'));
    }

    public function approveRefund($language, Request $request, WalletTransaction $transaction)
    { 
       
       // $this->validateUpdateRequest();
       $request->validate([
        'amount' => 'required',
        'opening_balance' => '',
        'closing_balance' => '',
]);
       $name = Input::get('amount');
        
        //$opening = '7600';
        $amount =$request->input('amount');
        $opening = $request->input('opening_balance');
        $closing = $request->input('closing_balance');
        $new_closing_balance = $amount + $opening;
        dd($name);
        $updateRefund = $transaction->update([
            'closing_balance' => $new_closing_balance,
            'opening_balance' => $new_closing_balance,
            'amount' => '0'
            ]);

            if($updateRefund) {
                $type = 'Request';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' updated '.$request->input('wallet_id');
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.wallet_refund',['transaction'=>$transaction->id, app()->getLocale()])->with('success', 'Refund has been approved successfully');
                
            } else {
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An Error Occured while '. Auth::user()->email. ' was trying to update '.$request->input('wallet_id');
                $this->log($type, $severity, $actionUrl, $message);
                return back()->with('error', 'An error occurred');
            }

            //return view('admin.ewallet.wallet_service_request_refund_summary', compact('transaction'));
    }


    private function validateUpdateRequest()
    {
        return request()->validate([
            'amount'              => 'required'
        ]);
    }

}