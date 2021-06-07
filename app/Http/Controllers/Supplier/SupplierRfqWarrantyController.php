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

class SupplierRfqWarrantyController extends Controller
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

        return view('supplier.rfq.warranty.index', [
            'rfqs'   =>  Rfq::orderBy('created_at', 'DESC')->where('type', '=', 'warranty')->get(),
        ])->with('i');
    }

    /**
     * Display the specified resource.
     *
     * 
     * 
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function rfqDetails($language, $uuid){

        return view('supplier.rfq.warranty._details', [
            'rfqDetails'    =>  Rfq::where('uuid', $uuid)->with('rfqSupplier','rfqBatches')->firstOrFail(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * 
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function linkRfqDetails($language, $uuid){

        return view('supplier.rfq.show', [
            'rfqDetails'    =>  Rfq::where('uuid', $uuid)->firstOrFail(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function sendInvoice($language, $uuid){

        return view('supplier.rfq.warranty.send_supplier_invoice', [
            'rfqDetails'    =>  Rfq::where('uuid', $uuid)->where('type', '=', 'warranty')->firstOrFail(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){


        //Send Quote for a specific RFQ
        //Validate user input fields
        $this->validateRequest();

        $supplierInvoiceExists = RfqSupplierInvoice::where('rfq_id', $request->rfq_id)->where('supplier_id', Auth::id())->count();

        if($supplierInvoiceExists > 0){
            return redirect()->route('supplier.rfq', app()->getLocale())->with('error', 'Sorry, you already sent an invoice for this RFQ');
        }

        $rfqUniqueId = Rfq::where('id', $request->rfq_id)->firstOrFail()->unique_id;

        (bool) $supplierinvoice = false;
        (bool) $supplierInvoiceBatch = false;
        

        DB::transaction(function () use ($request, &$supplierinvoice, &$supplierInvoiceBatch) {

            $newRecord = RfqSupplierInvoice::create([
                'rfq_id'        =>  $request->rfq_id,
                'supplier_id'   =>  Auth::id(),
                'delivery_fee' =>  $request->delivery_fee,  
                'delivery_time' =>  $request->delivery_time,
                'total_amount'  =>  $request->total_amount,
            ]);


            foreach ($request->rfq_batch_id as $item => $value){

                $totalAmount = ($request->unit_price[$item] * $request->quantity[$item]);

                RfqSupplierInvoiceBatch::create([
                    'rfq_supplier_invoice_id'   =>  $newRecord->id,
                    'rfq_batch_id'              =>  $request->rfq_batch_id[$item],
                    'quantity'                  =>  $request->quantity[$item],  
                    'unit_price'                =>  $request->unit_price[$item],
                    'total_amount'              =>  $totalAmount,
                ]);
            }

            //Set variables as true to be validated outside the DB transaction
            $supplierInvoice = true;
            $supplierInvoiceBatch = true;

        });

        if($supplierInvoiceBatch){

            //Code to send mail to FixMaster, CSE and Supplier who sent the quote

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

        return view('supplier.rfq.sent_invoices', [
            'rfqs'  =>  Auth::user()->supplierSentInvoices()->get(),
        ]);
       
    }

    public function sentInvoiceDetails($language, $id){

        $rfqDetails =  RfqSupplierInvoice::where('id', $id)->with('rfq', 'issuer')->firstOrFail();

        dd($rfqDetails);
        // return $rfqDetails;

        return view('supplier.rfq._sent_invoice_details', [
            'rfqDetails'    =>  RfqSupplierInvoice::where('id', $id)->with('rfq', 'issuer')->firstOrFail(),
        ])->with('i');
    }

    public function approvedInvoices(){

        return view('supplier.rfq.approved_invoices', [
            'rfqs'  =>  Auth::user()->supplierSentInvoices()->where('accepted', 'Yes')->get(),
        ]);
    }

    public function declinedInvoices(){

        return view('supplier.rfq.declined_invoices', [
            'rfqs'  =>  Auth::user()->supplierSentInvoices()->where('accepted', 'No')->get(),
        ]);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rfqDetailsImage($language, $id){
        return view('supplier.rfq._details_image', [
            'rfqDetails'    =>  \App\Models\RfqBatch::select('image')->where('id', $id)->first(),
        ]);
    }

    public function warrantyReplacementNotify($language, $id){
     
    }
}
