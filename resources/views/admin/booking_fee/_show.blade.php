<h5><strong>Tax Percentage History for {{ $priceName }}</strong></h5>

<div class="table-responsive">
    <table class="table table-hover mg-b-0" id="basicExample">
      <thead class="thead-primary">
        <tr>
          <th class="text-center">#</th>
          <th>Created By</th>
          <th class="text-center">Percentage</th>
          <th>Date Created</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($priceHistories as $priceHistory)
            <tr>
                <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                <td>{{ $priceHistory->user->email }}</td>
                <td class="tx-medium text-center">{{ $priceHistory->amount }}</td>
                <td>{{ Carbon\Carbon::parse($priceHistory->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
            </tr>
          @endforeach
      </tbody>
    </table>
  </div>