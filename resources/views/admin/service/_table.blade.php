<div class="table-responsive">
                
    <table class="table table-hover mg-b-0" id="basicExample">
      <thead class="thead-primary">
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">Name</th>
          <th>Category</th>
          <th class="text-center">Franchises</th>
          <th class="text-center">Requests</th>
          <th>Status</th>
          <th>Date Created</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($services as $category)
        <tr>
          <td class="tx-color-03 tx-center">{{ ++$i }}</td>
          <td class="tx-medium">{{ $category->name }}</td>
          <td class="tx-medium">{{ $category->category->name }}</td>
          <td class="tx-medium text-center">0</td>
          <td class="tx-medium text-center">0</td>
          @if(empty($category->deleted_at)) 
            <td class="text-medium text-success">Active</td>
          @else 
            <td class="text-medium text-danger">Inactive</td>
          @endif
          <td class="text-medium">{{ Carbon\Carbon::parse($category->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class=" text-center">
            <div class="dropdown-file">
              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              <a href="#serviceCategoryDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $category->name}} details" data-url="{{ route('admin.services.show', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" data-category-name="{{ $category->name}}" id="category-details"><i class="far fa-clipboard"></i> Details</a>

              <a href="#editService" data-toggle="modal" id="service-edit" title="Edit {{ $category->name }}" data-url="{{ route('admin.services.edit', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" data-service-name="{{ $category->name }}" data-id="{{ $category->uuid }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>

              @if(empty($category->deleted_at)) 
                <a data-url=""="{{ route('admin.services.deactivate', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-warning deactivate-entity" title="Deactivate {{ $category->name}}"><i class="fas fa-ban"></i> Deactivate</a>
              @else
                <a href="{{ route('admin.services.reinstate', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success" title="Reinstate {{ $category->name}}"><i class="fas fa-undo"></i> Reinstate</a>
              @endif
              <a data-url=""="{{ route('admin.services.delete', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger delete-entity" title="Delete {{ $category->name}}"><i class="fas fa-trash"></i> Delete</a>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div><!-- table-responsive -->