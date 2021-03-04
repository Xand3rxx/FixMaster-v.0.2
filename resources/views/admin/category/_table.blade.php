<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th>Created By</th>
        <th class="text-center">Services</th>
        <th>Status</th>
        <th>Date Created</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $service)
        <tr>
          <td class="tx-color-03 tx-center">{{ ++$i }}</td>
          <td class="tx-medium">{{ $service->name }}</td>
        <td class="tx-medium">{{ $service->user->email }}</td>
          <td class="tx-medium text-center">{{ $service->services()->count() }}</td>
          @if(empty($service->deleted_at)) 
          <td class="text-medium text-success">Active</td>
          @else 
            <td class="text-medium text-danger">Inactive</td>
          @endif
          <td class="text-medium">{{ Carbon\Carbon::parse($service->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class=" text-center">
            <div class="dropdown-file">
              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
             
              @if($service->id > '1')
                <a href="#serviceDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $service->name}} details" data-url="{{ route('admin.categories.show', ['category'=>$service->uuid, 'locale'=>app()->getLocale()] ) }}" data-service-name="{{ $service->name}}" id="service-details"><i class="far fa-clipboard"></i> Details</a>

                <a href="#editService" data-toggle="modal" id="service-edit" title="Edit {{ $service->name }}" data-url="{{ route('admin.categories.edit', ['category'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" data-service-name="{{ $service->name }}" data-id="{{ $service->uuid }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>

                @if(empty($service->deleted_at)) 
                  <a data-url="{{ route('admin.categories.deactivate', ['category'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-warning deactivate-entity" title="Deactivate {{ $service->name}}"><i class="fas fa-ban"></i> Deactivate</a>
                @else
                  <a href="{{ route('admin.categories.reinstate', ['category'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success" title="Reinstate {{ $service->name}}"><i class="fas fa-undo"></i> Reinstate</a>
                @endif

                <a href="#serviceReassign" data-toggle="modal" class="dropdown-item details text-warning" id="service-reassign" data-url="{{ route('admin.categories.reassign', ['category'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" data-service-name="{{ $service->name}}" title="Reassign {{ $service->name}} categories"><i class="fas fa-arrows-alt"></i> Reassign</a>

                <a data-url="{{ route('admin.categories.delete', ['category'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item delete-entity text-danger" title="Delete {{ $service->name}}"><i class="fas fa-trash"></i> Delete</a>

              @else

                <a href="#serviceReassign" data-toggle="modal" class="dropdown-item details text-primary" id="service-reassign" data-url="{{ route('admin.categories.reassign', ['category'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" data-service-name="{{ $service->name}}" title="View {{ $service->name}} categories"><i class="fas fa-clipboard"></i> Details</a>
              
              @endif
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>