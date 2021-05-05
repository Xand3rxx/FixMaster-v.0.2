<div class="table-responsive mt-4">
    <table class="table table-striped table-sm mg-b-0">
    <tbody>
        <tr>
            <td class="tx-medium" width="25%">Job Reference</td>
            <td class="tx-color-03" width="75%">{{ $dispatch['rfq']['serviceRequest']['unique_id'] }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">RFQ Batch Number</td>
            <td class="tx-color-03" width="75%">{{ $dispatch['rfq']['unique_id'] }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Dispatch Code</td>
            <td class="tx-color-03" width="75%">{{ $dispatch->unique_id }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">CSE Status</td>
            @if($dispatch->cse_status == 'Pending')
                <td width="75%" class="text-medium text-warning">Pending</td>
            @elseif($dispatch->cse_status == 'Accepted')
                <td width="75%" class="text-medium text-success">Accepted</td>
            @else
                <td width="75%" class="text-medium text-danger">Declined</td>
            @endif
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Supplier Status</td>
            @if($dispatch->supplier_status == 'Processing')
                <td width="75%" class="text-medium text-warning">Processing</td>
            @elseif($dispatch->supplier_status == 'Delivered')
                <td width="75%" class="text-medium text-success">Delivered</td>
            @else
                <td width="75%" class="text-medium text-info">In-Transit</td>
            @endif
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Dispatched Date</td>
            <td class="tx-color-03" width="75%"3">{{ Carbon\Carbon::parse($dispatch->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Courier Name</td>
            <td class="tx-color-03" width="75%"3">{{ $dispatch->courier_name }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Courier Phone Number</td>
            <td class="tx-color-03" width="75%"3">{{ $dispatch->courier_phone_number }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Delivery Medium</td>
            <td class="tx-color-03" width="75%">{{ $dispatch->delivery_medium }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Comment</td>
            <td class="tx-color-03" width="75%">{{ $dispatch->comment }}</td>
        </tr>
    </tbody>
    </table>
</div>