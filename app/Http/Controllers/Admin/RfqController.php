<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Auth;
use Route;
use App\Models\Rfq;
use App\Models\RfqBatch;
use App\Models\RfqSupplier;
use App\Models\RfqSupplierInvoice;
use App\Models\RfqSupplierInvoiceBatch;
use DB;

class RfqController extends Controller
{
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index(){

        $rfqs = Rfq::orderBy('created_at', 'DESC')->get();

        return view('admin.rfq.index', [
            'rfqs'   =>  $rfqs,
        ])->with('i');
    }

    public function rfqDetails($language, $uuid){

        $rfqDetails = Rfq::where('uuid', $uuid)->firstOrFail();

        return view('admin.rfq._details', [
            'rfqDetails'    =>  $rfqDetails,
        ])->with('i');
    }

    public function supplierInvoices(){
        $supplierInvoices = RfqSupplierInvoice::orderBy('created_at', 'DESC')->get();

        return view('admin.rfq.supplier_invoices', [
            'rfqs'   =>  $supplierInvoices,
        ])->with('i');
    }

    public function supplierInvoiceDetails($language, $id){
        
        $supplierInvoice = RfqSupplierInvoice::where('id', $id)->firstOrFail();


        // $supplierInvoiceBatches = RfqSupplierInvoiceBatch::where('id', $supplierInvoice->id)->get();

        // return $supplierInvoiceBatches;

        return view('admin.rfq._supplier_invoice_details', [

            'supplierInvoice'   =>  $supplierInvoice,
            'supplierInvoiceBatches'    =>  RfqSupplierInvoiceBatch::where('rfq_supplier_invoice_id', $supplierInvoice->id)->get(),

        ])->with('i');
    }

    public function acceptSupplierInvoice($language, $id){

        $supplier = RfqSupplierInvoice::where('id', $id)->firstOrFail();

        $supplierId = $supplier->supplier_id;

        $supplierRfqId = $supplier->rfq_id;

        $supplierInvoiceBatches =  RfqSupplierInvoiceBatch::where('rfq_supplier_invoice_id', $supplierRfqId)->get();

        DB::transaction(function () use ($supplierInvoiceBatches, $supplierRfqId,  &$supplierUpdate, &$rfqBatchUpdate) {

            // $rfq = Rfq::where('id', $id)->firstOrFail();
            // $supplierUpdate = RfqSupplier::where()->update([
            //     'rfq_id'        =>  ,
            //     'supplier_id'   =>  ,
            //     'devlivery_fee' =>  ,
            //     'delivery_time' =>  ,
            // ]);

            foreach ($supplierInvoiceBatches as $item => $value){

            }
        }


        // return $supplierInvoiceBatches;


    }
}
