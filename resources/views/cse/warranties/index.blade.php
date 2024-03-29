@extends('layouts.dashboard')
@section('title', 'CSE Warranty Claims')
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
                {{-- <li class="breadcrumb-item"><a href="{{ route('cse.requests.index', app()->getLocale()) }}">Requests</a></li> --}}
                <li class="breadcrumb-item active" aria-current="page">Warranty Claims</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Warranty Claims</h4>
        </div>
      </div>

      
       
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Warranty Claims as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Warranties issued by clients on the job you supervised.</p>
                </div>
                
              </div><!-- card-header -->
             
              <table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Client Name</th>
        <th>Warranty</th>
        <th>Job Reference</th>  
        <th>Start Date</th>  
        <th>End Date</th>  
        <th>Warrant Status</th>
        <th>Status</th>
        <th>Assigned CSE</th>
        <th>Assigned Status</th>
       
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($issuedWarranties as $warranty)
        <tr>
          <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
          <td class="tx-medium">{{ $warranty['user']['account']['first_name'].' '.$warranty['user']['account']['last_name'] }}</td>
          <td class="tx-medium">{{ $warranty['warranty']['name'] }}</td>
          <td class="tx-medium">{{ $warranty['service_request']['unique_id'] }}</td>
          <td class="tx-medium">{{ Carbon\Carbon::parse($warranty->start_date ?? '2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class="tx-medium">{{ Carbon\Carbon::parse($warranty->expiration_date ?? '2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          @if($warranty->status == 'used')
            <td class="text-success">Used</td>
          @else
            <td class="text-danger">Unused</td>
          @endif


          @if($warranty->has_been_attended_to == 'Yes')
          <td class="text-success">Resolved</td>
          @else
          <td class="text-danger">Unresolved</td>
          @endif
          @if(is_null($warranty->service_request_warranty_issued))
          <td class="text-danger">None </td>
          @else
          <td class="text-success">Yes</td>
          @endif

          @if(is_null($warranty->service_request_warranty_issued))
          <td class="text-danger">Pending</td>
          @else
          <td class="text-success">Accepted</td>
          @endif
        
        
          <td class=" text-center">
            <div class="dropdown-file">
            <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              @if($warranty->expiration_date >  Carbon\Carbon::now())

              @if(is_null($warranty->service_request_warranty_issued))
              <a href="{{ route('cse.accept_warranty_claim', ['warranty'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Accept</a>
               @endif

               @if(!is_null($warranty->service_request_warranty_issued))
        
               @if($warranty->service_request_warranty_issued->cse_id == Auth::user()->id)
               <a href="{{ route('cse.warranty_details', ['warranty'=>$warranty->service_request->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Details</a>
               <a href="#markAsResolved" id="markas-resolved"
              data-toggle="modal"
              data-url="{{ route('cse.mark_warranty_resolved', ['warranty'=>$warranty->uuid, 'locale'=>app()->getLocale() ]) }}"
              class="dropdown-item details text-success"><i class="fas fa-check"></i>  Mark as Resolved</a>
             
               @else
               <a href="#" class="dropdown-item details text-default"> No Details</a>

               @endif
               @endif

          

              @if($warranty->has_been_attended_to == 'Yes')
            
            <a href="#resolvedDetails" data-toggle="modal" class="dropdown-item details text-primary" 
             data-url="{{ route('cse.warranty_resolved_details', ['warranty'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" 
             id="resolved-details" data-job="{{ $warranty['service_request']['unique_id']}}">
            <i class="far fa-clipboard"></i> Resolved Details</a>
            @endif
            @endif
            @if($warranty->expiration_date <  Carbon\Carbon::now())
            <a href="{{ route('cse.warranty_details', ['warranty'=>$warranty->service_request->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Details</a>

              @endif
              </div>
            </div>
          </td>
        
        </tr>
      @endforeach
    </tbody>
  </table>



  <div class="modal fade" id="markAsResolved" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded shadow border-0">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Kindly state your comment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal-cancel-request">
            <form class="p-4" method="GET" id="markas-resolved-form">
                @csrf
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group position-relative">
                            <label>Comments (optional)</label>
                            <i data-feather="info" class="fea icon-sm icons"></i>
                            <textarea name="comment" id="reason" rows="3" class="form-control pl-5 @error('reason') is-invalid @enderror" placeholder="">{{ old('reason')  }}</textarea>
                            @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col-->

                {{-- </div><!--end row--> --}}

                    <div class="col-sm-12">
                    <button type="submit" class="submitBnt btn btn-primary">Initiate</button>
                    </div><!--end col-->
                </div><!--end row-->
            </form><!--end form-->
        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->

</div><!-- modal -->



<div class="modal fade" id="resolvedDetails" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded shadow border-0">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Resolved Details For <span id="job">
            </span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body" id="modal-body">
     
        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->

</div><!-- modal -->


@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/4823bfe5-4a86-49ee-8905-bb9a0d89e2e0.js') }}"></script>
@endpush

@endsection