
<form method="POST" action="{{ route('admin.categories.update', ['category'=>$category->uuid, 'locale'=>app()->getLocale()]) }}">
    @csrf @method('PUT')
    <h5 class="mg-b-2"><strong>Editing {{ !empty($category->name) ? $category->name : 'UNAVAILABLE' }} Category</strong></h5>
    <hr>
    <div class="form-row mt-4">
    <div class="form-group col-md-12">
        <label for="name">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? !empty($category->name) ? $category->name : 'UNAVAILABLE' }}" placeholder="Name" autocomplete="off">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
<form>
