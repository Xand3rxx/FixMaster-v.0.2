<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierReportController extends Controller
{
    //

    public function index()
    {
        return view('admin.reports.suppliers.index', [
            'suppliers' => \App\Models\Role::where('slug', 'supplier-user')->with('users')->firstOrFail()
        ]);
    }
}
