@extends('layouts.dashboard')
@section('title', 'Create New Service')
@include('layouts.partials._messages')
@section('content')
<input class="d-none" id="locale" type="hidden" value="{{ app()->getLocale() }}">

<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.services.index', app()->getLocale()) }}">Services List</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create New Service</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Create New Service</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-12 justify-content-center text-center align-items-center">
          <a href="{{ route('admin.services.index', app()->getLocale()) }}" class="btn btn-primary float-right"><i class="fas fa-arrow-left"></i> Services List</a>
        </div>

        <div class="col-lg-12 col-xl-12">
          <form method="POST" action="{{ route('admin.services.store', app()->getLocale()) }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
              <div class="form-row mt-4">
                <div class="form-group col-md-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') }}" autocomplete="off">
                    @error('name')
                      <x-alert :message="$message" />
                    @enderror
                </div>
                <div class="form-group col-md-3">
                  <label>Service</label>
                  <select class="custom-select @error('category_id') is-invalid @enderror" name="category_id">
                    <option selected value="">Select...</option>
                    @foreach($categories as $category)
                      @if($category->id != 1)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                      @endif
                    @endforeach
                  </select>
                  @error('category_id')
                    <x-alert :message="$message" />
                  @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="service_charge">Service Charge</label>
                    <input type="number" min="1" maxlength="5" class="form-control @error('service_charge') is-invalid @enderror" name="service_charge" id="service_charge" placeholder="Service Charge" value="{{ old('service_charge') }}" autocomplete="off">
                    @error('service_charge')
                      <x-alert :message="$message" />
                    @enderror
                </div>
                <div class="form-group col-md-3">
                  <label>Category Cover Image</label>
                  <div class="custom-file">
                    <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="image">
                    <label class="custom-file-label" id="image-name" for="image">Upload Category Image</label>
                    
                  </div>
                  {{-- <small class="text-danger"> Preferred category cover image size is 350x259.</small> --}}
                  @error('image')
                    <x-alert :message="$message" />
                  @enderror
                </div>
                
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Description</label>
                  <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') }}</textarea>
                  @error('description')
                    <x-alert :message="$message" />
                  @enderror
                </div>
              </div>

              <div class="divider-text">Add Sub Services</div>
              <div class="form-row mt-4">
                <div class="form-group col-md-3">
                    <label for="sub_service_name">Sub Service Name</label>
                    <input type="text" class="form-control @error('sub_service_name') is-invalid @enderror" name="sub_service_name[]" id="sub_service_name" placeholder="Name" value="{{ old('sub_service_name') }}" autocomplete="off">
                    @error('sub_service_name')
                      <x-alert :message="$message" />
                    @enderror
                </div>
                
                <div class="form-group col-md-3">
                    <label for="first_hour_charge">First Hour Charge</label>
                    <input type="number" min="1" maxlength="5" class="form-control @error('first_hour_charge') is-invalid @enderror" name="first_hour_charge[]" id="first_hour_charge" placeholder="First Hour Charge" value="{{ old('first_hour_charge') }}" autocomplete="off">
                    @error('first_hour_charge')
                      <x-alert :message="$message" />
                    @enderror
                </div>
                <div class="form-group col-md-3">
                  <label for="subsequent_hour_charge">Subsequent Hour Charge</label>
                  <input type="number" min="1" maxlength="5" class="form-control @error('subsequent_hour_charge') is-invalid @enderror" name="subsequent_hour_charge[]" id="subsequent_hour_charge" placeholder="Subsequent Hour Charge" value="{{ old('subsequent_hour_charge') }}" autocomplete="off">
                  @error('subsequent_hour_charge')
                    <x-alert :message="$message" />
                  @enderror
                </div>
                <div class="form-group col-md-3">
                  <button type="button" class="btn btn-primary add-sub-service" style="margin-top: 1.8rem !important;"><i class="fas fa-plus"></i> Add</button>
                </div>
                
              </div>

              <span class="add-new-sub-service"></span>
            </div>

            <div class="col-md-12 mt-4">
                <button type="submit" class="btn btn-primary">Create Service</button>
            </div>

          </form>
    
        </div><!-- col -->

      </div>

    </div>
</div>


@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/1e65edf0-c8e5-432c-8bbf-a7ed7847990f.js') }}"></script>

  <script>

  function addSubService(){

      let html = '<div class="form-row remove-sub-service-row"><div class="form-group col-md-3"> <label for="sub_service_name">Sub Service Name</label> <input type="text" class="form-control @error(" sub_service_name ") is-invalid @enderror" name="sub_service_name[]" id="sub_service_name" placeholder="Name" value="{{ old("sub_service_name") }}" autocomplete="off">@error("sub_service_name") <x-alert :message="$message" />@enderror</div><div class="form-group col-md-3"> <label for="first_hour_charge">First Hour Charge</label> <input type="number" min="1" maxlength="5" class="form-control @error("first_hour_charge") is-invalid @enderror" name="first_hour_charge[]" id="first_hour_charge" placeholder="First Hour Charge" value="{{ old(" first_hour_charge") }}" autocomplete="off">@error("first_hour_charge") <x-alert :message="$message" />@enderror</div><div class="form-group col-md-3"> <label for="subsequent_hour_charge">Subsequent Hour Charge</label> <input type="number" min="1" maxlength="5" class="form-control @error("subsequent_hour_charge") is-invalid @enderror" name="subsequent_hour_charge[]" id="subsequent_hour_charge" placeholder="Subsequent Hour Charge" value="{{ old("subsequent_hour_charge") }}" autocomplete="off">@error("subsequent_hour_charge") <x-alert :message="$message" />@enderror</div><div class="form-group col-md-3"> <button class="btn btn-danger remove-sub-service" type="button" style="margin-top: 1.8rem !important;"><i class="fas fa-minus"></i> Remove</button></div></div>';

      $('.add-new-sub-service').append(html);
  }
</script>
@endpush

@endsection