@extends('layouts.app')
@section('title', 'All Services')
@section('contents')

<!-- All Services -->
<section class="section">
    <div class="container" style="margin-top: 3rem;">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <div class="section-title mb-4 pb-2">
                <h4 class="title mb-4">All Services</h4>
                <p class="text-muted para-desc mb-0 mx-auto text-center">Start working with <span class="texty font-weight-bold">FixMaster</span> that can provide everything you need to make your life easier and better.</p>
            </div>
        </div>
        <!--end col-->
    </div>
    
    <div class="text-center pt-md-1 mb-4">
        <form class="rounded p-4 mt-4 bg-white">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control search-category" required placeholder="Keywords">
                    </div>
                </div><!--end col-->
                
                <div class="col-lg-6 col-md-6">
                    <div class="row align-items-center">
                        <div class="col-md-6 mt-4 mt-sm-0">
                            <div class="form-group mb-0">
                                <select class="form-control custom-select" id="sort-category">
                                    <option selected value="">Select...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end col-->

                    </div><!--end row-->
                </div> <!---end col-->
            </div><!--end row-->
        </form>

        <p class="text-muted mb-0 mt-4"><span class="text-dark">Keywords :</span>  Electronics, Generator, Tiling, etc...</p>
        <p class=" mb-0 mt-4"><a href="#requestQuote" data-toggle="modal" class="text-primary">Can't find a Service that matches your need?</a></p>

    </div>

    <div class="d-none search-result">
        <!-- Modal displays here -->
        <div id="spinner-icon"></div>
    </div>
    
    @foreach ($services as $service)
    <div class="col-lg-12 col-md-8 col-12 mt-5 pt-2 mt-sm-0 pt-sm-0 services-list">
        <div class="row align-items-center">
            <div class="col-lg-9 col-md-7">
                <div class="title-heading">
                <h4 class="mb-0 serv__1 mt-4 mb-2">{{ $service->name }}</h4>
                </div>
            </div><!--end col-->
        </div><!--end row-->
        <div class="row mt-4">
            @foreach($service->services as $item)
                <div class="col-lg-4 mt-4 pt-2">
                    <div class="card blog rounded border-0 shadow">
                        <div class="position-relative">
                            <img class="ult1 card-img-top rounded-top" src="{{ asset('assets/service-images/'.$item->image) }}" alt="{{ $item->name }}">

                            <div class="overlay rounded-top bg-dark"></div>
                        </div>
                        <div class="card-body content">
                        <h5 class="serv__2">{{ $item->name }} <a href="{{ route('services.details', ['service'=>$item->uuid, 'locale'=>app()->getLocale()]) }}" title="View {{ $item->name }} service details"> <i data-feather="info" class="text-primary"></i></a></h5>
                            <div class="post-meta d-flex justify-content-between mt-2">
                                {{-- <p class="serv__3 text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias commodi.</p> --}}
                            </div>
                            <a href="" class="btn btn-outline-fix btn-block">Request Service</a>
                            {{-- <p class="text-center mb-0 mt-1"><a class="btn btn-primary btn-sm" href="{{ route('page.services_details') }}">Details</a></p> --}}
                            

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div><!--end col-->
    @endforeach
    
</div>
</section>
<!-- All Services End -->

<div class="modal fade" id="requestQuote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg wd-sm-650" role="document">
      <div class="modal-content">
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
          <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <h5 class="mg-b-2"><strong>Custom Service Quotation</strong></h5>
          <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">First Name</label>
                <input type="text" class="form-control" id="inputEmail4" placeholder="First Name">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">Last Name</label>
                <input type="text" class="form-control" id="inputEmail4" placeholder="Last Name">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">E-Mail</label>
                <input type="email" class="form-control" id="inputEmail4" placeholder="E-Mail">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">Phone Number</label>
                <input type="text" class="form-control" id="inputEmail4" placeholder="Phone Number">
            </div>
            <div class="col-md-4">
                <div class="form-group position-relative">
                    <label>Date & Time</label>
                    <input name="name" type="datetime-local" class="form-control pl-5"   id="service-date-time">
                </div>
            </div><!--end col-->
            <div class="col-md-4">
                <div class="form-group">
                    <label>L.G.A</label>
                    <select class="custom-select" id="request-sorting">
                        <option>Select...</option>
                        <option value="1">Alimosho</option>
                        <option value="2">Kosofe</option>
                        <option value="2">Mushin</option>
                        <option value="2">Oshodi-Isolo</option>
                        <option value="2">Ojo</option>
                        <option value="2">Badagry</option>
                    </select>
                </div>
            </div><!--end col-->

            <div class="col-md-4">
                <div class="form-group position-relative">
                    <label>Town/City</label>
                    <select class="custom-select" id="request-sorting">
                        <option>Select...</option>
                        <option value="1">Abule Ijesha</option>
                        <option value="2">Bariga</option>
                        <option value="2">Coker</option>
                        <option value="2">Eti Osa</option>
                        <option value="2">Ibeju-Lekki</option>
                    </select>
                </div>
            </div>

          <div class="form-group col-md-6">
            <label for="inputAddress2">Full Address</label>
            <textarea rows="4" class="form-control" id="inputAddress2"></textarea>
          </div>
          <div class="form-group col-md-6">
            <label for="inputAddress2">Request Description</label>
            <textarea rows="4" class="form-control" id="inputAddress2" placeholder="Kindly describe in the details your request"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Send Request</button>

        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

@push('scripts')
<script>

    $(document).ready(function (){
        $(document).on('keyup', '.search-category', function(){
            let query = $(this).val();
            let type = 'Name';

            if($.trim(query).length <= 0){
                $('.search-result').html('');
                $('.search-result').addClass('d-none');
                $('.services-list').removeClass('d-none');
            }

            if($.trim(query).length > 5){
                $('.services-list').addClass('d-none');
                $('.search-result').removeClass('d-none');
                searchCategory(type, query);
            }

        });

        $(document).on('change','#sort-category', function(){

            let query = $(this).find("option:selected").val();
            let type = 'ID';

            if($.trim(query).length <= 0){
                $('.search-result').html('');
                $('.search-result').addClass('d-none');
                $('.services-list').removeClass('d-none');
            }

            if($.trim(query).length > 0){
                $('.services-list').addClass('d-none');
                $('.search-result').removeClass('d-none');
                searchCategory(type, query);
            }

        });

    });

    function searchCategory(type, query){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var route = '{{ route("services.search", app()->getLocale()) }}';

        $.ajax({
                url: route,
                beforeSend: function() {
                    $(".search-result").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                method: 'POST',
                data: {'type': type, 'query': query},
                // return the result
                success: function(result) {
                    $('.search-result').html('');
                    $('.search-result').html(result);
                },
                complete: function() {
                    $("#spinner-icon").hide();
                },
                timeout: 8000
        });
    }

</script>
@endpush
@endsection