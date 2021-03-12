<?php

namespace App\Http\Controllers\QualityAssurance;
use Auth;
use Session;
use App\Http\Controllers\Controller;
use App\Models\PaymentDisbursed;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function get_qa_disbursed_payments(Request $request){

        // $user = Auth::user();
        // $payments = $user->payments();
        $payments = PaymentDisbursed::where('recipient_id',Auth::id())->get();
        return view('qa.payments', compact('payments'));
    }

    public function get_technician_disbursed_payments(Request $request){

        // $user = Auth::user();
        // $payments = $user->payments();
        $payments = PaymentDisbursed::where('recipient_id',Auth::id())->get();
        return view('technician.payments', compact('payments'));
    }
}
