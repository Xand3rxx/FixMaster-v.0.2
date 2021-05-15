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
use App\Traits\Invoices;

class RfqController extends Controller
{
    use Invoices;

    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index(){

        return view('admin.rfq.index', [
            'rfqs'   =>  Rfq::orderBy('created_at', 'DESC')->get(),
        ])->with('i');
    }

    public function rfqDetails($language, $uuid){

        return view('admin.rfq._details', [
            'rfqDetails'    =>  Rfq::where('uuid', $uuid)->firstOrFail(),
        ])->with('i');
    }

    public function supplierInvoices(){

        return view('admin.rfq.supplier_invoices', [
            'rfqs'   =>  RfqSupplierInvoice::orderBy('created_at', 'DESC')->get(),
        ])->with('i');
    }

    public function supplierInvoiceDetails($language, $uuid){

        $supplierInvoice = RfqSupplierInvoice::where('uuid', $uuid)->firstOrFail();

        return view('admin.rfq._supplier_invoice_details', [
            'supplierInvoice'   =>  $supplierInvoice,
            'supplierInvoiceBatches'    =>  RfqSupplierInvoiceBatch::where('rfq_supplier_invoice_id', $supplierInvoice->id)->get(),

        ])->with('i');
    }

    public function acceptSupplierInvoice($language, $uuid){

        //Get supplier object with uuid
        $supplier = RfqSupplierInvoice::where('uuid', $uuid)->firstOrFail();

        //Assign selected supplier ID to `supplierId`
        $supplierId = $supplier->supplier_id;

        //Assign selected supplier rfq ID to `supplierRfqId`
        $supplierRfqId = $supplier->rfq_id;

        //Assign selected supplier invoice ID to `supplierRfqId`
        $supplierInvoiceId = $supplier->id;

        //Check if the selcted supplier has already been chosen
        $supplierAcceptanceExists = RfqSupplier::where('rfq_id', $supplierRfqId)->where('supplier_id', Auth::id())->count();

        if($supplierAcceptanceExists > 0){
            return back()->with('error', 'Sorry, you already accepted '.$supplier['supplier']['account']['first_name'] ." ". $supplier['supplier']['account']['last_name'].' invoice for this '.$supplier->rfq->unique_id);
        }

        //Get selected supplier rfq batches
        $supplierInvoiceBatches =  RfqSupplierInvoiceBatch::where('rfq_supplier_invoice_id', $supplierInvoiceId)->get();

        (bool) $supplierUpdate = false;
        $grandTotalAmount = 0;

        DB::transaction(function () use ($supplier, $supplierId, $supplierInvoiceBatches, $supplierRfqId, $grandTotalAmount, &$supplierUpdate) {

            RfqSupplier::create([
                'rfq_id'        =>  $supplierRfqId,
                'supplier_id'   =>  $supplierId,
                'devlivery_fee' =>  $supplier->delivery_fee,
                'delivery_time' =>  $supplier->delivery_time,
            ]);

            foreach ($supplierInvoiceBatches as $item => $value){

                RfqBatch::where('id', $value->rfq_batch_id)->update([
                    'amount'    => $value->total_amount,
                ]);

                $grandTotalAmount += $value->total_amount;
            }

            Rfq::where('id', $supplier->rfq_id)->update([
                'status'        =>   'Awaiting',
                'accepted'      =>   'No',
                'total_amount'  =>   $grandTotalAmount + $supplier->delivery_fee,
            ]);

            $supplierUpdate = true;

        });

        if($supplierUpdate){
            $this->supplierInvoice($supplier->rfq->service_request_id, $supplier->rfq_id);
            return back()->with('success', $supplier['supplier']['account']['first_name'] ." ". $supplier['supplier']['account']['last_name'].' invoice has been selected for '.$supplier->rfq->unique_id.' RFQ');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rfqDetailsImage($language, $id){
        return view('admin.rfq._details_image', [
            'rfqDetails'    =>  \App\Models\RfqBatch::select('image')->where('id', $id)->firstOrFail(),
        ]);
    }
}
