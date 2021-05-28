<div id="serviceRequestSummary" class="tab-pane pd-20 pd-xl-25">
    <div class="divider-text">Diagnostic Reports</div>
    <div class="card-group">
        <div class="card">
            <div class="card-body shadow-none bd-primary overflow-hidden">
                <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">1</div>

                <p class="card-text">After discussion with Mr Kelvin Adesanya, tentatively I
                    beleive his laptop has overheating issues. On-premise diagnosis has to be
                    carried out.</p>
                <p class="card-text"><small class="text-muted">Date Created:
                        {{ \Carbon\Carbon::now('UTC') }}</small></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body shadow-none bd-primary overflow-hidden">
                <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">2</div>
                <p class="card-text">After discussion with Mr Kelvin Adesanya, tentatively I
                    beleive his laptop has overheating issues. On-premise diagnosis has to be
                    carried out.</p>
                <p class="card-text"><small class="text-muted">Date Created:
                        {{ \Carbon\Carbon::now('UTC') }}</small></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body shadow-none bd-primary overflow-hidden">
                <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">3</div>

                <p class="card-text">After discussion with Mr Kelvin Adesanya, tentatively I
                    beleive his laptop has overheating issues. On-premise diagnosis has to be
                    carried out.</p>
                <p class="card-text"><small class="text-muted">Date Created:
                        {{ \Carbon\Carbon::now('UTC') }}</small></p>
            </div>
        </div>
    </div>

    <div class="divider-text">Service Request Progress</div>
    <h5 class="mt-4">Service Request Progress</h5>
    <div class="table-responsive mb-4">
        <table class="table table-hover mg-b-0">
            <thead class="">
                <tr>
                    <th class="text-center">#</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th class="text-center">Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($request_progress as $key => $progress)
                    <tr>
                        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                        <td class="tx-medium">
                            {{ Str::title($progress['user']['account']['last_name'] . ' ' . $progress['user']['account']['first_name']) }}
                            ({{ $progress['user']['roles'][0]['name'] }})</td>
                        <td class="tx-medium text-success">
                            {{ $progress['substatus']['name'] }} </td>
                        <td class="text-center">
                            {{ Carbon\Carbon::parse($progress['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- table-responsive -->

    <div class="divider-text">Tools Request</div>
    <h5 class="mt-4">Tools Requests</h5>
    <div class="table-responsive mb-4">
        <table class="table table-hover mg-b-0">
            <thead class="">
                <tr>
                    <th class="text-center">#</th>
                    <th>Batch Number</th>
                    <th>Client</th>
                    <th>Approved By</th>
                    <th>Requested By</th>
                    <th>Status</th>
                    <th>Date Requested</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                @php $z = 0; @endphp
                <tr>
                    <td class="tx-color-03 tx-center">{{ ++$z }}</td>
                    <td class="tx-medium">TRF-C85BEA04</td>
                    <td class="tx-medium">Kelvin Adesanya</td>
                    <td class="tx-medium">Charles Famoriyo</td>
                    <td class="tx-medium">David Akinsola (CSE)</td>
                    <td class="text-medium text-success">Approved</td>

                    <td class="text-medium">
                        {{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                    </td>
                    <td class=" text-center">
                        <a href="#toolsRequestDetails" data-toggle="modal"
                            class="btn btn-sm btn-primary" title="View TRF-C85BEA04 details"
                            data-batch-number="TRF-C85BEA04" data-url="#"
                            id="tool-request-details">Details</a>
                    </td>

                </tr>
            </tbody>
        </table>
    </div><!-- table-responsive -->

    <div class="divider-text">RFQ's</div>
    <h5 class="mt-4">Request For Quotation</h5>
    <div class="table-responsive">

        <table class="table table-hover mg-b-0 mt-4">
            <thead class="">
                <tr>
                    <th class="text-center">#</th>
                    <th>Batch Number</th>
                    <th>Client</th>
                    <th>Issued By</th>
                    <th>Status</th>
                    <th class="text-center">Total Amount</th>
                    <th>Date Created</th>
                    @if (Auth::user()->type->url != 'admin')
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php $y = 0; @endphp
                <tr>
                    <td class="tx-color-03 tx-center">{{ ++$y }}</td>
                    <td class="tx-medium">RFQ-C85BEA04 </td>
                    <td class="tx-medium">Kelvin Adesanya</td>
                    <td class="tx-medium">David Akinsola</td>
                    <td class="text-medium text-success">Payment received</td>
                    <td class="tx-medium text-center">₦{{ number_format(5000) ?? 'Null' }}
                    </td>
                    <td class="text-medium">
                        {{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                    </td>

                    <td class=" text-center">
                        <a href="#rfqDetails" data-toggle="modal" class="btn btn-sm btn-primary"
                            title="View RFQ-C85BEA04 details" data-batch-number="RFQ-C85BEA04"
                            data-url="#" id="rfq-details"></i> Details</a>
                    </td>

                </tr>
            </tbody>
        </table>
    </div><!-- table-responsive -->
</div>