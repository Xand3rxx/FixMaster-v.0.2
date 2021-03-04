<div class="d-md-block float-right">
    <a href="{{ route('admin.services.edit', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    @if($category->is_active == 0)
        <a href="{{ route('admin.services.reinstate', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-success"><i class="fas fa-undo"></i> Reinstate</a>
    @endif
    <a href="{{ route('admin.services.delete', ['service'=>$category->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
</div>

<h5>{{ $category->name }} Category</h5>

@if(empty($category->image))
    <img src="{{ asset('assets/images/no-image-available.png') }}" class="wd-sm-200 rounded" alt="No image found">
@else
    <img src="{{ asset('assets/service-images/'.$category->image) }}" class="wd-sm-200 rounded" alt="{{ $category->name }}">
@endif
<div class="table-responsive mt-4">
    <table class="table table-striped table-sm mg-b-0">
    <tbody>
        <tr>
            <td class="tx-medium" width="25%">Name</td>
            <td class="tx-color-03" width="75%">{{ $category->name }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Service</td>
            <td class="tx-color-03" width="75%">{{ $category->category->name }}</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Status</td>
            @if(empty($category->deleted_at)) 
                <td class="text-success" width="75%">Active</td>
            @else
                <td class="text-danger" width="75%">Inactive</td>
            @endif
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Requests</td>
            <td class="tx-color-03" width="75%">0</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Franchses</td>
            <td class="tx-color-03" width="75%"3">0</td>
        </tr>
        <tr>
            <td class="tx-medium" width="25%">Description</td>
            <td class="tx-color-03" width="75%">{{ $category->description }}</td>
        </tr>
    </tbody>
    </table>
</div>