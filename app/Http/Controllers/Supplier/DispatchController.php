<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Auth;
use Route;
use DB;
use App\Traits\Loggable;
use App\Traits\GenerateUniqueIdentity;
use App\Models\RfqSupplierDispatch;

class DispatchController extends Controller
{
    use Loggable, GenerateUniqueIdentity;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return RfqSupplierDispatch::where('supplier_id', Auth::id())->with('rfq', 'supplierInvoice')->get();

        return view('supplier.materials.index', [
            'dispatches'    =>  RfqSupplierDispatch::where('supplier_id', Auth::id())->with('rfq')->get()
        ]);
    }

    /**
     * Show the form for generating a new unique string.
     * 
     * @return \Illuminate\Http\Response
     */
    public function generateDeliveryCode()
    {
        return static::generate('rfq_supplier_dispatches', 'DEV-');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;

        $request->validate([
            'rfq'                   =>  'required',
            'rfq_id'                =>  'required',
            'rfq_supplier_invoice'  =>  'required',
            'unique_id'             =>  'required|unique:rfq_supplier_dispatches,unique_id',
            'courier_name'          =>  'required',
            'courier_phone_number'  =>  'required',
            'delivery_medium'       =>  'required',
            'comment'               =>  'sometimes',
        ]);

        //Set `createDispatch` to false before Db transaction and pass by reference
        (bool) $createDispatch  = false;

        // Set DB to rollback DB transacations if error occurs
        DB::transaction(function () use ($request, &$createDispatch) {
            $createDispatch = RfqSupplierDispatch::create([
                'rfq_id'                =>  $request->rfq_id,
                'rfq_supplier_invoice'  =>  $request->rfq_supplier_invoice,
                'supplier_id'           =>  Auth::id(),
                'unique_id'             =>  $request->unique_id,
                'courier_name'          =>  $request->courier_name,
                'courier_phone_number'  =>  $request->courier_phone_number,
                'delivery_medium'       =>  $request->delivery_medium,
                'comment'               =>  $request->comment,
            ]);

            //Set variables as true to be validated outside the DB transaction
            $createDispatch =  true;
        });

        if($createDispatch){

            //Record crurrenlty logged in user activity
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' created '.$request->unique_id.' dispatch code for '.$request->rfq.' RFQ.';
            $this->log($type, $severity, $actionUrl, $message);
 
            return redirect()->route('supplier.dispatches', app()->getLocale())->with('success', 'Your '.$request->rfq.' RFQ has been labelled.');
 
        }else{
 
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to create '.$request->unique_id.' dispatch code for '.$request->rfq.' RFQ.';
            $this->log($type, $severity, $actionUrl, $message);
 
            return back()->with('error', 'An error occurred while trying to create dispatch code for '.$request->rfq.' RFQ.');
        }
 
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dispatchDetails($language, $id){

        // return RfqSupplierDispatch::with('rfq', 'supplierInvoice')->findOrFail($id);

        return view('supplier.materials._details', [
            'dispatch'    =>  RfqSupplierDispatch::with('rfq', 'supplierInvoice')->findOrFail($id),
        ]);
    }
}
