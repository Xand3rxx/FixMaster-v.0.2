<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.invoices.index');
    }

   public static function storeDiagnosticInvoice($user_id, $service_request_id, $invoice_type, $total_amount, $amount_due, $amount_paid) {
        $createDiagnosticInvoice = Invoice::create([
            'uuid' => Str::uuid('uuid'),
            'user_id' => $user_id,
            'service_request_id'
        ]);

   }

    public static function storeRFQInvoice($user_id, $service_request_id, $invoice_type, $total_amount, $amount_due, $amount_paid) {

    }

    public static function storeSupplierInvoice($user_id, $service_request_id, $invoice_type, $total_amount, $amount_due, $amount_paid) {

    }

    public static function storeTotalInvoice($user_id, $service_request_id, $invoice_type, $total_amount, $amount_due, $amount_paid) {

    }
}
