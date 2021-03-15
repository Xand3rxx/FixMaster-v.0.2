<?php


namespace App\Traits;


use App\Models\Invoice;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Integer;

trait Invoices
{
    /**
     * Create a Diagnostic Invoice
     *
     * @param  int  $user_id
     * @param  int  $service_request_id
     * @param  string  $invoice_type
     * @param  int  $total_amount
     * @param  int  $amount_due
     * @param  int  $amount_paid
     * @param  string  $hours_spent
     * @param  string  $status
     * @param  float  $discount_fee
     *
     * @return boolean
     */

    public static function diagnosticInvoice(int $user_id, int $service_request_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string $hours_spent, string  $status)
    {
        return self::createDiagnosticInvoice($user_id, $service_request_id, $invoice_type, $total_amount, $amount_due, $amount_paid, $status);
    }

    protected static function createDiagnosticInvoice(int $user_id, int $service_request_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string  $status)
    {
        return collect(Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'user_id'               => $user_id,
            'service_request_id'    => $service_request_id,
            'invoice_number'        => 'INV-'.strtoupper(substr(md5(time()), 0, 8)),
            'invoice_type'          => $invoice_type,
            'total_amount'          => $total_amount,
            'amount_due'            => $amount_due,
            'amount_paid'           => $amount_paid,
            'status'                => $status
        ]))->isNotEmpty() ? true : false ;
    }

    /**
     * Create a Diagnostic Invoice
     *
     * @param  int  $user_id
     * @param  int  $service_request_id
     * @param  int  $rfq_id
     * @param  string  $invoice_type
     * @param  string  $status
     *
     * @return boolean
     */

    public static function rfqInvoice(int $user_id, int $service_request_id, int $rfq_id, string $invoice_type, string  $status)
    {
        return self::createRfqInvoice($user_id, $service_request_id, $rfq_id, $invoice_type, $status);
    }

    protected static function createRfqInvoice(int $user_id, int $service_request_id, int $rfq_id, string $invoice_type, string $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'user_id'               => $user_id,
            'service_request_id'    => $service_request_id,
            'rfq_id'                => $rfq_id,
            'invoice_number'        => 'INV-'.strtoupper(substr(md5(time()), 0, 8)),
            'invoice_type'          => $invoice_type,
            'status'                => $status
        ]);
    }

    public static function supplierInvoice(int $user_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string  $status)
    {
        return self::createSupplierInvoice($user_id, $service_request_id, $rfq_id, $invoice_type, $total_amount, $amount_due, $amount_paid, $status);
    }

    protected static function createSupplierInvoice(int $user_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string  $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'user_id'               => $user_id,
            'service_request_id'    => $service_request_id,
            'rfq_id'                => $rfq_id,
            'invoice_number'        => 'INV-'.strtoupper(substr(md5(time()), 0, 8)),
            'invoice_type'          => $invoice_type,
            'total_amount'          => $total_amount,
            'amount_due'            => $amount_due,
            'amount_paid'           => $amount_paid,
            'status'                => $status
        ]);
    }

    public static function completedServiceInvoice(int $user_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_paid, int $hours_spent, string  $status)
    {
        $total_hours_spent = 2000 * $hours_spent;
        $total_amount = $total_amount + $total_hours_spent;
        return self::createcompletedServiceInvoice($user_id, $service_request_id, $rfq_id, $invoice_type, $total_amount,$amount_paid, $hours_spent, $status);
    }

    protected static function createcompletedServiceInvoice(int $user_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_paid, string  $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'user_id'               => $user_id,
            'service_request_id'    => $service_request_id,
            'rfq_id'                => $rfq_id,
            'invoice_number'        => 'INV-'.strtoupper(substr(md5(time()), 0, 8)),
            'invoice_type'          => $invoice_type,
            'total_amount'          => $total_amount,
            'amount_due'            => $total_amount,
            'amount_paid'           => $amount_paid,
            'status'                => $status
        ]);
    }



}
