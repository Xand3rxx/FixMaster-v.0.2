<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;


use App\Traits\Loggable;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestReport;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequestProgress;

trait StoreInDatabase
{
    use Loggable;

    /**
     * Store details filled by the cse in the service request
     *
     * @param  array $parameters
     * 
     * @return boolean
     */
    protected static function saveAction(array $params)
    {
        (bool) $registred = false;
        // Run DB Transaction to update all necessary records after confirmation Technician is not already on the Service Request
        DB::transaction(function () use ($params, &$registred) {
            // dd($params, 'all parameters');
            foreach ($params as $table) {

                if (!empty($table['service_request_assigned'])) {
                    ServiceRequestAssigned::create($table['service_request_assigned']);
                }

                if (!empty($table['trfs'])) {
                    // save on tool_requests
                    $tool_request = \App\Models\ToolRequest::create($table['trfs']);
                    foreach ($table['trfs']['tool_requests']['tool_id'] as $key => $tool_id) {
                        \App\Models\ToolRequestBatch::create([
                            'tool_request_id'  => $tool_request->id,
                            'tool_id'           => $tool_id,
                            'quantity'          => $table['trfs']['tool_requests']['tool_quantity'][$key],
                        ]);
                    }
                }
                if (!empty($table['rfqs'])) {
                    // save on rfqs table
                    $rfq = \App\Models\Rfq::create($table['rfqs']);
                    // save each of the component name on the rfqbatch table
                    foreach ($table['rfqs']['rfq_batches']['component_name'] as $key => $component_name) {
                        \App\Models\RfqBatch::create([
                            'rfq_id'                => $rfq->id,
                            'component_name'        => $component_name,
                            'manufacturer_name'     => $table['rfqs']['rfq_batches']['manufacturer_name'][$key],
                            'model_number'          => $table['rfqs']['rfq_batches']['model_number'][$key],
                            'quantity'              => $table['rfqs']['rfq_batches']['quantity'][$key],
                            'image'                 => $table['rfqs']['rfq_batches']['image'][$key]->store('assets/rfq-images', 'public'),
                            'unit_of_measurement'   => $table['rfqs']['rfq_batches']['unit_of_measurement'][$key] ?? "",
                            'size'                  => $table['rfqs']['rfq_batches']['size'][$key]
                        ]);
                    }
                    \App\Traits\Invoices::rfqInvoice($rfq->service_request_id, $rfq->id);
                }

                if (!empty($table['service_request_reports'])) {
                    ServiceRequestReport::create($table['service_request_reports']);
                }

                if (!empty($table['service_request_progresses'])) {
                    ServiceRequestProgress::create($table['service_request_progresses']);
                }

                if (!empty($table['log'])) {
                    ActivityLog::create($table['log']);
                }
            }

            // 6. update registered to be true
            $registred = true;
        });
        return $registred;
    }
}
