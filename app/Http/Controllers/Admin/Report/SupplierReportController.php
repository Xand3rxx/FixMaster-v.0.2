<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\RfqSupplier;
use Illuminate\Http\Request;
use App\Models\RfqSupplierInvoiceBatch;

class SupplierReportController extends Controller
{
    //

    public function index()
    {
        return view('admin.reports.suppliers.index', [
            'results' => [],
            'suppliers' => \App\Models\Role::where('slug', 'supplier-user')->with('users')->firstOrFail(),
            'cses' => \App\Models\Role::where('slug', 'cse-user')->with('users')->firstOrFail(),
        ]);
    }

    public function itemDeliveredSorting($language, Request $request)
    {
        if($request->ajax()) {
            (array) $filters = $request->only('supplier_id', 'sort_level', 'job_status', 'cse_id', 'date');

            return view('admin.reports.suppliers.tables._item_delivered', [
                // 'results'   =>  RfqSupplierInvoiceBatch::itemDeliveredSorting($filters)
                // ->latest('created_at')->get()
                'results' => RfqSupplierInvoiceBatch::all()
            ]);

        }
    }
}
