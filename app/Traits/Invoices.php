<?php


namespace App\Traits;


use App\Models\Income;
use App\Models\Invoice;
use App\Models\Rfq;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\SubService;
use App\Models\Warranty;
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

    public static function diagnosticInvoice(int $service_request_id)
    {
        $serviceRequest = ServiceRequest::where('id', $service_request_id)->first();

        $client_id = $serviceRequest->client_id;
        $service_id = $serviceRequest->service_id;

        $serviceCharge = Service::where('id', $service_id)->first();
        $total_amount = $serviceCharge->service_charge;

        $invoice_type = 'Diagnostic Invoice';
        $amount_paid = 0.00;
        $status= '1';

        return self::createDiagnosticInvoice($client_id, $service_request_id, $invoice_type, $total_amount, $amount_paid, $status);
    }

    protected static function createDiagnosticInvoice(int $client_id, int $service_request_id, string $invoice_type, float $total_amount, float $amount_paid, string  $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
            'service_request_id'    => $service_request_id,
            'invoice_number'        => 'INV-'.strtoupper(substr(md5(time()), 0, 8)),
            'invoice_type'          => $invoice_type,
            'total_amount'          => $total_amount,
            'amount_due'            => $total_amount,
            'amount_paid'           => $amount_paid,
            'status'                => $status
        ]);
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

    public static function rfqInvoice(int $service_request_id, int $rfq_id)
    {
        $serviceRequest = ServiceRequest::where('id', $service_request_id)->first();
        $client_id = $serviceRequest->client_id;

        return self::createRfqInvoice($client_id, $service_request_id, $rfq_id);
    }

    protected static function createRfqInvoice(int $client_id, int $service_request_id, int $rfq_id)
    {
        $invoice_type = 'Rfq Invoice';
        $status = '1';

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

    public static function supplierInvoice(int $service_request_id, int $rfq_id)
    {
        $serviceRequest = ServiceRequest::where('id', $service_request_id)->first();
        $rfq = Rfq::where('id', $rfq_id)->first();

        $invoice_type = 'Supplier Invoice';
        $client_id = $serviceRequest->client_id;
        $total_amount = $rfq->total_amount;
        $amount_paid = 0.00;
        $status = '1';

        return self::createSupplierInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $total_amount, $amount_paid, $status);
    }

    protected static function createSupplierInvoice(int $client_id, int $service_request_id, int $rfq_id, string $invoice_type, float $total_amount, float $amount_paid, string  $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
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

    public static function completedServiceInvoice($service_request_id, $rfq_id, $warranty_id, $sub_service_id, $hours_spent)
    {
        return self::getServiceRequestDetails($service_request_id, $rfq_id, $warranty_id, $sub_service_id, $hours_spent);
    }

    protected static function getServiceRequestDetails($service_request_id, $rfq_id, $warranty_id, $sub_service_id, $hours_spent)
    {
        $invoice_type = 'Completion Invoice';
        $status = 1;
        $amount_paid = 0.00;
        $serviceRequest = ServiceRequest::where('id', $service_request_id)->first();
        $rfq = Rfq::where('id', $rfq_id)->first();
        $warranty = Warranty::where('id', $warranty_id);
        $subService = SubService::where('id', $sub_service_id)->first();

        $client_id = $serviceRequest->client_id;

        $fixMasterMarkup = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Markup')->first();
        $total_hours_spent = 0;

        $materials_cost = $rfq_id!=null ? $rfq->total_amount : 0;

        if($hours_spent == 1)
        {
            $total_hours_spent = $subService->first_hour_charge;
        }
        else
        {
            $total_hours_spent = $subService->first_hour_charge + $subService->subsequent_hour_charge * ($hours_spent - 1);
        }

        $markupPrice = $fixMasterMarkup->percentage * $total_hours_spent;
        $labour_cost = $total_hours_spent + $markupPrice;
        $total_amount = $labour_cost + $materials_cost;

        return self::createcompletedServiceInvoice($client_id, $service_request_id, $rfq_id, $warranty_id, $sub_service_id, $invoice_type, $labour_cost, $materials_cost, $hours_spent, $total_amount, $amount_paid, $status);
    }

    protected static function createcompletedServiceInvoice($client_id, $service_request_id, $rfq_id, $warranty_id, $sub_service_id, $invoice_type, $labour_cost, $materials_cost, $hours_spent, $total_amount, $amount_paid, $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
            'service_request_id'    => $service_request_id,
            'rfq_id'                => $rfq_id,
            'warranty_id'           => $warranty_id,
            'sub_service_id'        => $sub_service_id,
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

    public static function estimatedInvoices( int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_paid, int $hours_spent, string $status)
    {
        return self::createEstimateInvoice($service_request_id, $rfq_id, $invoice_type, $total_amount, $amount_paid, $hours_spent, $status);
    }

    protected static function createEstimateInvoice( int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_paid, int $hours_spent, string $status)
    {
        return 'Working';
    }



}
