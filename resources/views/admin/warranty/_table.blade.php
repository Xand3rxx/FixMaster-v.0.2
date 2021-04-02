<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Warranty ID</th>
        <th>Warranty Name</th>
        <th>Warranty Type</th>
        <th>Percentage (%)</th>   
        <th>Date Created</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($warranties as $warranty)
        <tr>
          <td class="tx-color-03 tx-center">{{ ++$i }}</td>
          <td class="tx-medium">{{ $warranty->unique_id }}</td>
          <td class="tx-medium">{{ $warranty->name }}</td>
          <td class="tx-medium">{{ $warranty->warranty_type }}</td>
          @if($warranty->amount == null )
                  
          <td>Not Avalaible</td>
          
          @else
            
            
            <td>{{ $warranty->amount}}</td>
          
        @endif
          <td>{{ Carbon\Carbon::parse($warranty->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class=" text-center">
            <div class="dropdown-file">
              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('admin.warranty_summary', ['details'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Details</a>
              <a href="{{ route('admin.edit_warranty', ['details'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>
              <a href="{{ route('admin.edit_warranty', ['details'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a>
  


                
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>