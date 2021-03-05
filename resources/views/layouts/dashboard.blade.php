<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" /> --}}
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@homefix.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">

    <!-- vendor css -->
    <link href="{{ asset('assets/dashboard/lib/fontawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.dashboard.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4-custom.css') }}" />
    <link href="{{ asset('assets/dashboard/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/client/css/jquery.datetimepicker.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">


  </head>

  <body class="app-mail">
    <style>
      div.dt-buttons {
        margin-top: 1em;
        margin-left: 1.5em;
      }
    </style>

    @include('layouts.partials._dashboard_sidebar')

    <div class="content ht-100v pd-0">
      @include('layouts.partials._dashboard_header')
      @yield('content')
    {{-- </div> --}}
    </div>

    <script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/frontend/js/jquery-3.5.1.min.js') }}"></script> --}}
    <script src="{{ asset('assets/dashboard/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.settings.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.aside.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.sampledata.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/cleave.js/cleave.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('assets/dashboard/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery.flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/chart.js/Chart.bundle.min.js') }}"></script>

    <!-- append theme customizer -->
    <script src="{{ asset('assets/dashboard/lib/js-cookie/js.cookie.js') }}"></script>

    <script src="{{ asset('assets/dashboard/assets/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery-steps/build/jquery.steps.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/dashboard/assets/js/custom.js') }}"></script> --}}
    <script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
    <input type="hidden" class="d-none" id="path_backEnd" value="{{ url('/') }}">

    <script src="{{ asset('assets/client/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/moment.js') }}"></script>

    <script src="{{ asset('assets/dashboard/assets/js/jquery.tinymce.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="{{asset('assets/frontend/js/custom.js')}}"></script>



    <script src="{{ asset('assets/dashboard/assets/js/48a9782e-3e2b-4055-a9bb-8a926a937e2c.js') }}"></script>

    <script>
      $(function(){
        'use strict'

        var ctx1 = document.getElementById('chartBar1').getContext('2d');
        new Chart(ctx1, {
          type: 'bar',
          data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
              data: [150,110,90,115,125,160,160,140,100,110,120,120],
              backgroundColor: '#66a4fb'
            },{
              data: [180,140,120,135,155,170,180,150,140,150,130,130],
              backgroundColor: '#65e0e0'
            }]
          },
          options: {
            maintainAspectRatio: false,
            legend: {
              display: false,
                labels: {
                  display: false
                }
            },
            scales: {
              xAxes: [{
                display: false,
                barPercentage: 0.5
              }],
              yAxes: [{
                gridLines: {
                  color: '#ebeef3'
                },
                ticks: {
                  fontColor: '#8392a5',
                  fontSize: 10,
                  min: 80,
                  max: 200
                }
              }]
            }
          }
        });


        /** PIE CHART **/
        var datapie = {
          labels: ['Organic Search', 'Email', 'Referral', 'Social Media'],
          datasets: [{
            data: [20,20,30,25],
            backgroundColor: ['#f77eb9', '#7ebcff','#7ee5e5','#fdbd88']
          }]
        };

        var optionpie = {
          maintainAspectRatio: false,
          responsive: true,
          legend: {
            display: false,
          },
          animation: {
            animateScale: true,
            animateRotate: true
          }
        };

        // For a pie chart
        var ctx2 = document.getElementById('chartDonut');
        var myDonutChart = new Chart(ctx2, {
          type: 'doughnut',
          data: datapie,
          options: optionpie
        });


        $.plot('#flotChart1', [{
            data: df1,
            color: '#c0ccda',
            lines: {
              fill: true,
              fillColor: '#f5f6fa'
            }
          },{
              data: df3,
              color: '#E97D1F',
              lines: {
                fill: true,
                fillColor: '#d1e6fa'
              }
            }], {
    			series: {
    				shadowSize: 0,
            lines: {
              show: true,
              lineWidth: 1.5
            }
    			},
          grid: {
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            max: 65
          },
    			xaxis: {
            show: false,
            min: 40,
            max: 100
          }
    		});


        $.plot('#flotChart2', [{
          data: df2,
          color: '#66a4fb',
          lines: {
            show: true,
            lineWidth: 1.5,
            fill: .03
          }
        },{
          data: df1,
          color: '#00cccc',
          lines: {
            show: true,
            lineWidth: 1.5,
            fill: true,
            fillColor: '#fff'
          }
        },{
          data: df3,
          color: '#e3e7ed',
          bars: {
            show: true,
            lineWidth: 0,
            barWidth: .5,
            fill: 1
          }
        }], {
          series: {
            shadowSize: 0
          },
          grid: {
            aboveData: true,
            color: '#e5e9f2',
            borderWidth: {
              top: 0,
              right: 1,
              bottom: 1,
              left: 1
            },
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 100
          },
    			xaxis: {
            show: true,
            min: 40,
            max: 80,
            ticks: 6,
            tickColor: 'rgba(0,0,0,0.04)'
          }
    		});

        var df3data1 = [[0,12],[1,10],[2,7],[3,11],[4,15],[5,20],[6,22],[7,19],[8,18],[9,20],[10,17],[11,19],[12,18],[13,14],[14,9]];
        var df3data2 = [[0,0],[1,0],[2,0],[3,2],[4,5],[5,2],[6,12],[7,15],[8,10],[9,8],[10,10],[11,7],[12,2],[13,4],[14,0]];
        var df3data3 = [[0,2],[1,1],[2,2],[3,4],[4,2],[5,1],[6,0],[7,0],[8,5],[9,2],[10,8],[11,6],[12,9],[13,2],[14,0]];
        var df3data4 = [[0,0],[1,5],[2,2],[3,0],[4,2],[5,7],[6,10],[7,12],[8,8],[9,6],[10,4],[11,2],[12,0],[13,0],[14,0]];

        var flotChartOption1 = {
          series: {
            shadowSize: 0,
            bars: {
              show: true,
              lineWidth: 0,
              barWidth: .5,
              fill: 1
            }
          },
          grid: {
            aboveData: true,
            color: '#e5e9f2',
            borderWidth: 0,
            labelMargin: 0
          },
    			yaxis: {
            show: false,
            min: 0,
            max: 25
          },
    			xaxis: {
            show: false
          }
    		};

        $.plot('#flotChart3', [{
          data: df3data1,
          color: '#e5e9f2'
        },{
          data: df3data2,
          color: '#66a4fb'
        }], flotChartOption1);


        $.plot('#flotChart4', [{
          data: df3data1,
          color: '#e5e9f2'
        },{
          data: df3data3,
          color: '#7ee5e5'
        }], flotChartOption1);

        $.plot('#flotChart5', [{
          data: df3data1,
          color: '#e5e9f2'
        },{
          data: df3data4,
          color: '#f77eb9'
        }], flotChartOption1);

      })
    </script>
    @yield('scripts')
    @stack('scripts')

  </body>
</html>
