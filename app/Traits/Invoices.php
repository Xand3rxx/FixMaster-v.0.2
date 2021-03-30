<?php


namespace App\Traits;


use App\Models\Income;
use App\Models\Invoice;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Integer;

trait Invoices
{
    /**
     * Create a Diagnostic Invoice
     *
     * @param  int  $client_id
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

    public static function diagnosticInvoice(int $client_id, int $service_request_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string $hours_spent, string  $status)
    {
        return self::createDiagnosticInvoice($client_id, $service_request_id, $invoice_type, $total_amount, $amount_due, $amount_paid, $status);
    }

    protected static function createDiagnosticInvoice(int $client_id, int $service_request_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string  $status)
    {
        return collect(Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
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
     * @param  int  $client_id
     * @param  int  $service_request_id
     * @param  int  $rfq_id
     * @param  string  $invoice_type
     * @param  string  $status
     *
     * @return boolean
     */

    public static function rfqInvoice(int $client_id, int $service_request_id, int $rfq_id, string $invoice_type, string  $status)
    {
        return self::createRfqInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $status);
    }

    protected static function createRfqInvoice(int $client_id, int $service_request_id, int $rfq_id, string $invoice_type, string $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
            'service_request_id'    => $service_request_id,
            'rfq_id'                => $rfq_id,
            'invoice_number'        => 'INV-'.strtoupper(substr(md5(time()), 0, 8)),
            'invoice_type'          => $invoice_type,
            'status'                => $status
        ]);
    }

    public static function supplierInvoice(int $client_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string  $status)
    {
        return self::createSupplierInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $total_amount, $amount_due, $amount_paid, $status);
    }

    protected static function createSupplierInvoice(int $client_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string  $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
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

    public static function completedServiceInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $materials_cost, $hours_spent,  $status)
    {
        $amount_paid = 0.00;
        $fixMasterMarkup = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Markup')->first();
        $total_hours_spent = 0;

        if($hours_spent == 1)
        {
            $total_hours_spent = 3000;
        }else
        {
            $total_hours_spent = 3000 * 1 + 1000 * ($hours_spent - 1);
        }

        $markupPrice = $fixMasterMarkup->percentage * $total_hours_spent;
        $labour_cost = $total_hours_spent + $markupPrice;
        $total_amount = + $labour_cost + $materials_cost;

        return self::createcompletedServiceInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $labour_cost, $materials_cost, $hours_spent, $total_amount,$amount_paid, $status);
    }

    protected static function createcompletedServiceInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $labour_cost, $materials_cost, $hours_spent, $total_amount, $amount_paid, $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
            'service_request_id'    => $service_request_id,
            'rfq_id'                => $rfq_id,
            'invoice_number'        => 'INV-'.strtoupper(substr(md5(time()), 0, 8)),
            'invoice_type'          => $invoice_type,
            'labour_cost'           => $labour_cost,
            'materials_cost'        => $materials_cost,
            'hours_spent'           => $hours_spent,
            'total_amount'          => $total_amount,
            'amount_due'            => $total_amount,
            'amount_paid'           => $amount_paid,
            'status'                => $status
        ]);
    }

    public static function estimatedInvoices(int $client_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_paid, int $hours_spent, string $status)
    {
        return self::createEstimateInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $total_amount, $amount_paid, $hours_spent, $status);
    }

    protected static function createEstimateInvoice(int $client_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_paid, int $hours_spent, string $status)
    {

    }



}
