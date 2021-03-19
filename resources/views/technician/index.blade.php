@extends('layouts.dashboard')
@section('title', Auth::user()->type->role->name.' Dashboard' ?? 'Technicians & Artisans Dashboard')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item active">Dashboard</li>
            {{-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> --}}
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Welcome to Fix<span style="color: #E97D1F;">Master</span> {{ Auth::user()->type->role->name ?? 'Technicians & Artisans' }} Dashboard</h4>
      </div>
      {{-- <div class="d-none d-md-block">
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button>
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="upload" class="wd-10 mg-r-5"></i> Export</button>
        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button>
        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="sliders" class="wd-10 mg-r-5"></i> Settings</button>
      </div> --}}
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12">
        <div class="card">
          <div class="row mt-1 mb-1 ml-1 mr-1">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Sort</label>
                    <select class="custom-select" id="request-sorting">
                        <option value="None">Select...</option>
                        <option value="Date">Date</option>
                        <option value="Month">Month</option>
                        <option value="Date Range">Date Range</option>
                    </select>
                </div>
            </div><!--end col-->

            <div class="col-md-4 specific-date d-none">
                <div class="form-group position-relative">
                    <label>Specify Date <span class="text-danger">*</span></label>
                    <input name="name" id="name" type="date" class="form-control pl-5">
                </div>
            </div>

            <div class="col-md-4 sort-by-year d-none">
                <div class="form-group position-relative">
                    <label>Specify Year <span class="text-danger">*</span></label>
                    <select class="form-control custom-select" id="Sortbylist-Shop">
                        <option>Select...</option>
                        <option>2018</option>
                        <option>2019</option>
                        <option>2020</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 sort-by-year d-none">
                <div class="form-group position-relative">
                    <label>Specify Month <span class="text-danger">*</span></label>
                    <select class="form-control custom-select" id="Sortbylist-Shop">
                        <option>Select...</option>
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 date-range d-none">
                <div class="form-group position-relative">
                    <label>From <span class="text-danger">*</span></label>
                    <input name="name" id="name" type="date" class="form-control pl-5">
                </div>
            </div>

            <div class="col-md-4 date-range d-none">
                <div class="form-group position-relative">
                    <label>To <span class="text-danger">*</span></label>
                    <input name="name" id="name" type="date" class="form-control pl-5">
                </div>
            </div>
          </div>
          
          <h5 class="ml-4" >Total Requests: 100</h5><br>

          <div class="row row-xs col-lg-12">
            <div class="col-sm-6 col-lg-3">
              <div class="card card-body">
                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Pending Requests</h6>
                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                <h5 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><a href="#"> 40</a></h5>
                </div>
                
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-body">
                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Completed Requests</h6>
                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                  <h5 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><a href="#">30</a></h5>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-body">
                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Ongoing Requests</h6>
                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                  <h5 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><a href="#">10</a></h5>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card card-body">
                <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Cancelled Requests</h6>
                <div class="d-flex d-lg-block d-xl-flex align-items-end">
                  <h5 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1"><a href="#">20</a></h5>
                </div>
              </div>
            </div>
          </div>


          <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
            <div>
              <h6 class="mg-b-5">Service Request Metrics</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Requests made since inception.</p>
            </div>

            
            <div class="btn-group mg-t-20 mg-sm-t-0">
              {{-- <button class="btn btn-xs btn-white btn-uppercase">Day</button>
              <button class="btn btn-xs btn-white btn-uppercase">Month</button>
              <button class="btn btn-xs btn-white btn-uppercase active">Year</button> --}}
              
            </div><!-- btn-group -->
          </div><!-- card-header -->
          <div class="card-body pd-lg-25">
            <div class="row align-items-sm-end">
              <div class="col-lg-7 col-xl-8">
                <div class="chart-six"><canvas id="chartBar1"></canvas></div>
              </div>
              <div class="col-lg-5 col-xl-4 mg-t-30 mg-lg-t-0">
                <div class="row">
                  <div class="col-sm-6 col-lg-12">
                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                      <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Total Administrators</h6>
                      {{-- <span class="tx-10 tx-color-04">65</span> --}}
                    </div>
                    <div class="d-flex align-items-end justify-content-between mg-b-5">
                      <h5 class="tx-normal tx-rubik lh-2 mg-b-0">12</h5>
                      {{-- <h6 class="tx-normal tx-rubik tx-color-03 lh-2 mg-b-0">20,000</h6> --}}
                    </div>
                    <div class="progress ht-4 mg-b-0 op-5">
                      <div class="progress-bar bg-teal wd-12p" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="25"></div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-12 mg-t-30 mg-sm-t-0 mg-lg-t-30">
                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                      <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Total CSE's</h6>
                      {{-- <span class="tx-10 tx-color-04">45% goal reached</span> --}}
                    </div>
                    <div class="d-flex justify-content-between mg-b-5">
                      <h5 class="tx-normal tx-rubik mg-b-0">5</h5>
                      {{-- <h5 class="tx-normal tx-rubik tx-color-03 mg-b-0"><small>250,000</small></h5> --}}
                    </div>
                    <div class="progress ht-4 mg-b-0 op-5">
                      <div class="progress-bar bg-orange wd-5p" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="25"></div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-12 mg-t-30">
                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                      <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Total Technicians</h6>
                      {{-- <span class="tx-10 tx-color-04">20% goal reached</span> --}}
                    </div>
                    <div class="d-flex justify-content-between mg-b-5">
                      <h5 class="tx-normal tx-rubik mg-b-0">5</h5>
                      {{-- <h5 class="tx-normal tx-rubik tx-color-03 mg-b-0"><small>85,000</small></h5> --}}
                    </div>
                    <div class="progress ht-4 mg-b-0 op-5">
                      <div class="progress-bar bg-pink wd-5p" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="25"></div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-12 mg-t-30">
                    <div class="d-flex align-items-center justify-content-between mg-b-5">
                      <h6 class="tx-uppercase tx-10 tx-spacing-1 tx-color-02 tx-semibold mg-b-0">Clients</h6>
                      {{-- <span class="tx-10 tx-color-04">85% goal reached</span> --}}
                    </div>
                    <div class="d-flex justify-content-between mg-b-5">
                      <h5 class="tx-normal tx-rubik mg-b-0">12</h5>
                      {{-- <h5 class="tx-normal tx-rubik tx-color-03 mg-b-0"><small>30.50%</small></h5> --}}
                    </div>
                    <div class="progress ht-4 mg-b-0 op-5">
                      <div class="progress-bar bg-primary wd-12p" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="25"></div>
                    </div>
                  </div>
                </div><!-- row -->

              </div>
            </div>
          </div><!-- card-body -->
        </div><!-- card -->
      </div>

      <div class="col-md-12 col-xl-12 mg-t-10">
        <div class="card ht-100p">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="mg-b-0">Recent Payments</h6>
            {{-- <div class="d-flex tx-18">
              <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
              <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
            </div> --}}
          </div>
          <ul class="list-group list-group-flush tx-13">
            <li class="list-group-item d-flex pd-sm-x-20">
              <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-teal"><i class="icon ion-md-checkmark"></i></span></div>
              <div class="pd-sm-l-10">
                <p class="tx-medium mg-b-0">Payment from FixMaster for REF-234094623496 job</p>
                <small class="tx-12 tx-color-03 mg-b-0">Apr 3, 2020, 12:56pm</small>
              </div>
              <div class="mg-l-auto text-right">
                <p class="tx-medium mg-b-0"> ₦7,000</p>
                <small class="tx-12 tx-success mg-b-0">Completed</small>
              </div>
            </li>
            <li class="list-group-item d-flex pd-sm-x-20">
              <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-teal"><i class="icon ion-md-checkmark"></i></span></div>
              <div class="pd-sm-l-10">
                <p class="tx-medium mg-b-0">Payment from FixMaster for REF-094009623412 job</p>
                <small class="tx-12 tx-color-03 mg-b-0">Mar 21, 2020, 3:30pm</small>
              </div>
              <div class="mg-l-auto text-right">
                <p class="tx-medium mg-b-0"> ₦4,800</p>
                <small class="tx-12 tx-success mg-b-0">Completed</small>
              </div>
            </li>
            <li class="list-group-item d-flex pd-sm-x-20">
              <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-teal"><i class="icon ion-md-checkmark"></i></span></div>
              <div class="pd-sm-l-10">
                <p class="tx-medium mg-b-0">Payment from FixMaster for REF-237290223123</p>
                <small class="tx-12 tx-color-03 mg-b-0">Feb 25, 2020, 8:17am</small>
              </div>
              <div class="mg-l-auto text-right">
                <p class="tx-medium mg-b-0"> ₦2,500</p>
                <small class="tx-12 tx-success mg-b-0">Completed</small>
              </div>
            </li>
            <li class="list-group-item d-flex pd-sm-x-20">
              <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-teal"><i class="icon ion-md-checkmark"></i></span></div>
              <div class="pd-sm-l-10">
                <p class="tx-medium mg-b-0">Payment from FixMaster for REF-234094623496 job</p>
                <small class="tx-12 tx-color-03 mg-b-0">Jan 18, 2020, 7:30pm</small>
              </div>
              <div class="mg-l-auto text-right">
                <p class="tx-medium mg-b-0"> ₦1,950</p>
                <small class="tx-12 tx-success mg-b-0">Completed</small>
              </div>
            </li>
            <li class="list-group-item d-flex pd-sm-x-20">
              <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-teal"><i class="icon ion-md-checkmark"></i></span></div>
              <div class="pd-sm-l-10">
                <p class="tx-medium mg-b-0">Payment from FixMaster for REF-544199238409 job</p>
                <small class="tx-12 tx-color-03 mg-b-0">Jan 8, 2020, 6:18am</small>
              </div>
              <div class="mg-l-auto text-right">
                <p class="tx-medium mg-b-0"> ₦6,000</p>
                <small class="tx-12 tx-success mg-b-0">Completed</small>
              </div>
            </li>
          </ul>
          <div class="card-footer text-center tx-13">
          <a href="{{ route('technician.payments') }}" class="link-03">View All Transactions <i class="icon ion-md-arrow-down mg-l-5"></i></a>
          </div><!-- card-footer -->
        </div><!-- card -->
      </div>

    </div><!-- row -->
  </div><!-- container -->
</div>


@section('scripts')
<script src="{{ asset('assets/dashboard/assets/js/chart294.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/utils.js') }}"></script>
{{-- <script src="https://www.chartjs.org/samples/latest/utils.js"></script> --}}

<script>
  var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  var config = {
    type: 'line',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [{
        label: 'Payments Disbursed',
        borderColor: window.chartColors.red,
        backgroundColor: window.chartColors.red,
        data: [
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor()
        ],
      }, {
        label: 'Requests',
        borderColor: window.chartColors.blue,
        backgroundColor: window.chartColors.blue,
        data: [
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor()
        ],
      }, {
        label: 'Payments Recieved',
        borderColor: window.chartColors.green,
        backgroundColor: window.chartColors.green,
        data: [
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor(),
          randomScalingFactor()
        ],
      }], 
    },
    options: {
      responsive: true,
      title: {
        display: true,
        text: 'Payments/Requests Chart'
      },
      tooltips: {
        mode: 'index',
      },
      hover: {
        mode: 'index'
      },
      scales: {
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Month'
          }
        }],
        yAxes: [{
          stacked: true,
          scaleLabel: {
            display: true,
            labelString: 'Value'
          }
        }]
      }
    }
  };

  window.onload = function() {
    var ctx = document.getElementById('canvas').getContext('2d');
    window.myLine = new Chart(ctx, config);
  };

  document.getElementById('randomizeData').addEventListener('click', function() {
    config.data.datasets.forEach(function(dataset) {
      dataset.data = dataset.data.map(function() {
        return randomScalingFactor();
      });

    });

    window.myLine.update();
  });

  var colorNames = Object.keys(window.chartColors);
  document.getElementById('addDataset').addEventListener('click', function() {
    var colorName = colorNames[config.data.datasets.length % colorNames.length];
    var newColor = window.chartColors[colorName];
    var newDataset = {
      label: 'Dataset ' + config.data.datasets.length,
      borderColor: newColor,
      backgroundColor: newColor,
      data: [],
    };

    for (var index = 0; index < config.data.labels.length; ++index) {
      newDataset.data.push(randomScalingFactor());
    }

    config.data.datasets.push(newDataset);
    window.myLine.update();
  });

  document.getElementById('addData').addEventListener('click', function() {
    if (config.data.datasets.length > 0) {
      var month = MONTHS[config.data.labels.length % MONTHS.length];
      config.data.labels.push(month);

      config.data.datasets.forEach(function(dataset) {
        dataset.data.push(randomScalingFactor());
      });

      window.myLine.update();
    }
  });

  document.getElementById('removeDataset').addEventListener('click', function() {
    config.data.datasets.splice(0, 1);
    window.myLine.update();
  });

  document.getElementById('removeData').addEventListener('click', function() {
    config.data.labels.splice(-1, 1); // remove the label first

    config.data.datasets.forEach(function(dataset) {
      dataset.data.pop();
    });

    window.myLine.update();
  });
</script>
<script>
    $(document).ready(function() {

        $('#request-sorting').on('change', function (){        
                let option = $("#request-sorting").find("option:selected").val();

                if(option === 'None'){
                    $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Date'){
                    $('.specific-date').removeClass('d-none');
                    $('.sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Month'){
                    $('.sort-by-year').removeClass('d-none');
                    $('.specific-date, .date-range').addClass('d-none');
                }

                if(option === 'Date Range'){
                    $('.date-range').removeClass('d-none');
                    $('.specific-date, .sort-by-year').addClass('d-none');
                }
        });
    });
   
</script>
@endsection

@endsection