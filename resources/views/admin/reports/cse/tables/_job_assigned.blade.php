<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th>Job Ref.</th>
        <th>Job Location</th>
        <th>Booking Date</th>
        <th>Acceptance Date</th>
        <th>Diagnostic Date</th>
        <th>Completion Date</th>
        <th>Status</th>
        <th>Days Btw. Booking & Acceptance</th>
        <th>Days Btw. Acceptance & Completion</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="tx-color-03 tx-center">1</td>
        <td class="tx-medium">Benedict Olaoye </td>
        <td class="tx-medium">REF-39432798</td>
        <td class="tx-medium">Victoria Island</td>
        {{-- <td class="text-medium text-center">₦{{number_format(7000) }}</td> --}}
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-02-14 13:39:55', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-02-15 08:12:39', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-02-15 10:47:32', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">UNAVAILABLE</td>
        <td class="text-medium text-info">Ongoing</td>
        <td class="text-medium text-center">0days</td>
        <td class="text-medium text-center">UNAVAILABLE</td>
      </tr>

      <tr>
        <td class="tx-color-03 tx-center">2</td>
        <td class="tx-medium">Susan Ngozi </td>
        <td class="tx-medium">REF-66EB5A26</td>
        <td class="tx-medium">Ogba</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-23 17:09:23', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-24 06:54:11', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-15 09:12:06', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-15 14:39:43', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
        <td class="text-medium text-success">Completed</td>
        <td class="text-medium text-center">{{ Carbon\Carbon::parse('2021-01-23 17:09:23', 'UTC')->diffInDays(Carbon\Carbon::parse('2021-01-24 06:54:11', 'UTC')) }}days</td>
        <td class="text-medium text-center">{{ Carbon\Carbon::parse('2021-01-24 06:54:11', 'UTC')->diffInDays(Carbon\Carbon::parse('2021-01-15 14:39:43', 'UTC')) }}days</td>
      </tr>

    </tbody>
  </table>