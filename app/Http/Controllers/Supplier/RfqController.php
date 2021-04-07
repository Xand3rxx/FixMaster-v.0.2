<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Route;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\UserType;
use App\Traits\Loggable;
use Illuminate\Support\Facades\URL;
use App\Models\Rfq;
use DB;
use App\Models\RfqSupplierInvoice;
use App\Models\RfqSupplierInvoiceBatch;

class RfqController extends Controller
{
    use Loggable; 

    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index(){

        $rfqs = Rfq::orderBy('created_at', 'DESC')->get();

        return view('supplier.rfq.index', [
            'rfqs'   =>  $rfqs,
        ])->with('i');
    }

    public function rfqDetails($language, $uuid){

        $rfqDetails = Rfq::where('uuid', $uuid)->firstOrFail();

        return view('supplier.rfq._details', [
            'rfqDetails'    =>  $rfqDetails,
        ])->with('i');
    }

    public function sendInvoice($language, $uuid){

        $rfqDetails = Rfq::where('uuid', $uuid)->firstOrFail();

        return view('supplier.rfq._send_supplier_invoice', [
            'rfqDetails'    =>  $rfqDetails,
        ])->with('i');
    }

    public function store(Request $request){

        //Validate user input fields
        $this->validateRequest();

        $supplierInvoiceExists = RfqSupplierInvoice::where('rfq_id', $request->rfq_id)->where('supplier_id', Auth::id())->count();

        if($supplierInvoiceExists > 0){
            return back()->with('error', 'Sorry, you already sent an invoice for this RFQ');
        }

        $rfqUniqueId = Rfq::where('id', $request->rfq_id)->firstOrFail()->unique_id;

        DB::transaction(function () use ($request, &$supplierinvoice, &$supplierInvoiceBatch) {

            $supplierInvoice = $newRecord = RfqSupplierInvoice::create([
                'rfq_id'        =>  $request->rfq_id,
                'supplier_id'   =>  Auth::id(),
                'delivery_fee' =>  $request->delivery_fee,  
                'delivery_time' =>  $request->delivery_time,
                'total_amount'  =>  $request->total_amount,
            ]);

            $supplierInvoice = true;

            foreach ($request->rfq_batch_id as $item => $value){

                $totalAmount = ($request->unit_price[$item] * $request->quantity[$item]);

                $supplierInvoiceBatch = RfqSupplierInvoiceBatch::create([
                    'rfq_supplier_invoice_id'   =>  $newRecord->id,
                    'rfq_batch_id'              =>  $request->rfq_batch_id[$item],
                    'quantity'                  =>  $request->quantity[$item],  
                    'unit_price'                =>  $request->unit_price[$item],
                    'total_amount'              =>  $totalAmount,
                ]);
            }

            $supplierInvoiceBatch = true;

        });

        if($supplierInvoiceBatch){

            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' sent an invoice for '.$rfqUniqueId.' RFQ';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('supplier.rfq_sent_invoices', app()->getLocale())->with('success', 'Your invoice for '.$rfqUniqueId.' RFQ has been sent.');

        }else{

            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to sent an invoice for '.$rfqUniqueId.' RFQ';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to send your invoice for '.$rfqUniqueId.' RFQ.');
        }
    }

    /**
     * Validate user input fields
     */
    private function validateRequest(){
        return request()->validate([
            'rfq_id'            =>   'required|numeric',
            'rfq_batch_id'    =>   'required|array',
            'quantity'        =>   'required|array',
            'unit_price'      =>   'required|array',
            'delivery_fee'      =>   'required|numeric',
            'delivery_time'     =>   'required',
        ]);
    }

    public function sentInvoices(){
        // return Auth::user()->supplierSentInvoices()->get();

        return view('supplier.rfq.sent_invoices', [
            'rfqs'  =>  Auth::user()->supplierSentInvoices()->get(),
        ])->with('i');
    }

    public function sentInvoiceDetails($language, $id){

        $rfqDetails = Rfq::where('rfq_supplier_invoice_id', $id)->firstOrFail();

        return view('supplier.rfq._sent_invoice_details', [
            'rfqDetails'    =>  $rfqDetails,
        ])->with('i');
    }
}