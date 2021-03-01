@extends('layouts.client')
@section('title', 'Services')
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12">
    <h5 class="mt-4 mb-0">Book a Service</h5>

    <p class="text-muted mb-0 mt-4"><span class="text-dark">Keywords :</span> Electronics, Generator, Tiling, etc...</p>
    <p class=" mb-0 mt-4"><a href="{{ route('client.service_custom') }}" class="text-primary">Can't find a Service that matches your need?</a></p>
    <form class="rounded p-4 mt-4 bg-white">
        <div class="row">
            <div class="col-lg-5 col-md-6">
                <div class="form-group mb-0">
                    <input type="text" class="form-control search-category" required="" placeholder="Keywords">
                </div>
            </div><!--end col-->
            
            <div class="col-lg-7 col-md-6">
                <div class="row align-items-center">
                    <div class="col-md-4 mt-4 mt-sm-0">
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

    <div class="d-none search-result">
        <!-- Modal displays here -->
        <div id="spinner-icon"></div>
    </div>

    @foreach ($services as $service)
        <div class="services-list">
            <h5 class="mt-4 mb-0">{{ $service->name }}</h5>
            <div class="row">
                @foreach($service->categories as $item)
                    <div class="col-md-4 mt-4 pt-2">
                        <div class="card blog rounded border-0 shadow">
                            <div class="position-relative">
                            <img alt="{{ $item->name }}" src="{{ asset('assets/category-images/'.$item->image) }}"  class="card-img-top rounded-top" />
                                <div class="overlay rounded-top bg-dark"></div>
                            </div>
                            <div class="card-body content">
                                <h5><a href="javascript:void(0)" class="card-title title text-dark">{{ $item->name }}</a> <a href="{{ route('client.services_details', $item->url) }}" title="View {{ $item->name }} service details"> <i data-feather="info" class="text-primary"></i></a></h5>
                                <div class="post-meta d-flex justify-content-between mt-3">
                                    <a href="{{ route('client.service_quote', $item->url) }}" class="text-muted readmore">Request Service <i class="mdi mdi-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                @endforeach

            </div><!--end row-->
        </div>
    @endforeach
    
</div>

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

        $.ajax({
                url: '{{ route("client.services_search") }}',
                beforeSend: function() {
                    $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
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