@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header"></div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6 text-left" style="padding-left: 3em;">
              <h2>Научно-информационная система по управлению водными ресурсами </h2>
              <br>
              {{-- <p style="font-size: 1.3em;">
                &nbsp;&nbsp;&nbsp; Данное программное приложение поддерживает распределение воды в режиме реального времени в нижних точках утечки рек. Для мониторинга поставок воды всем АВП от основных и вспомогательных каналов, включая план мониторинга потока с 49 мониторинговых объектов.
              </p> --}}
            </div>
            <div class="col-md-6 text-center">
              <img src="{{ asset('img/sarez.jpg') }}" width="50%">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-header" style="padding-left: 3em;">
            <h3>Цифровые показатели водных ресурсов республики Таджикистана</h3>
          </div>
          <div class="box-body text-center">
            <img src="{{ asset('img/map_water_tj.png') }}" width="50%">
          </div>
          <div class="box-footer">
            <div class="text-right"></div>
          </div>
        </div>
      </div>
    </div>
  {{--
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Показатели</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="col-md-4">
            <canvas id="pieChart1" style="height: 259px; width: 518px;" height="259" width="518"></canvas>
            <div class="row text-center">
              <span>Chart1</span>
            </div>
          </div>
          <div class="col-md-4">
            <canvas id="pieChart2" style="height: 259px; width: 518px;" height="259" width="518"></canvas>
            <div class="row text-center">
              <span>Chart2</span>
            </div>
          </div>
          <div class="col-md-4">
            <canvas id="pieChart3" style="height: 259px; width: 518px;" height="259" width="518"></canvas>
            <div class="row text-center">
              <span>Chart3</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  --}}
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Количественные показатели</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            {{-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> --}}
          </div>
        </div>
        <div class="box-body">
            <form id="filterForm" role="form" method="GET" action="{{ route('home.index') }}" accept-charset="UTF-8">
              <div class="row" id="filterRow1">
                  @if(false)
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label for="basin_id"><span>Бассейн</span></label>
                      <select name="basin_id" class="form-control"  id="filter_basin">
                          @unless(count($basins) == 1)
                            <option value="">Выберите Бассейн</option>
                          @endunless
                          @foreach($basins as $basin)
                              <option value="{{$basin->id}}" {{ ( $basin->id == app('request')->input('basin_id') ) ? 'selected' : '' }}>{{$basin->name_ru}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                  @endif
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label for="canal_id"><span>Магистральный Канал</span></label>
                      <select name="canal_id" class="form-control" id="filter_canal">
                              @unless(count($canals) == 1)
                                  <option value ="">Выберите Канал</option>
                              @endunless
                              @foreach($canals as $canal)
                                @if(!app('request')->input('canal_id'))
                                  <option value="{{$canal->id}}" {{ ( $canal->id == $canals->first()->id ) ? 'selected' : '' }}>{{$canal->name_ru}}</option>
                                @else
                                  <option value="{{$canal->id}}" {{ ( $canal->id == app('request')->input('canal_id') ) ? 'selected' : '' }}>{{$canal->name_ru}}</option>
                                @endif
                              @endforeach
                      </select>
                    </div>
                  </div>
                  {{-- 
                  <div class="col-xs-4">
                      <div class="form-group">
                        <label for="wua_id"><span>АВП</span></label>
                        <select name="wua_id" class="form-control" id="filter_wua">
                            <option value="">Выберите АВП</option>
                        </select>
                      </div>
                  </div>
                  --}}
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label for="year"><span>Год</span></label>
                      <select name="year" class="form-control"  id="filter_year">
                          <option value="">Выберите Год</option>
                          @foreach($years as $year)
                            @if(!app('request')->input('year'))
                              <option value="{{$year}}" {{ ( $year == 2019 ) ? 'selected' : '' }}>{{$year}}</option>
                            @else  
                              <option value="{{$year}}" {{ ( $year == app('request')->input('year') ) ? 'selected' : '' }}>{{$year}}</option>
                            @endif
                          @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group ">
                      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-sync-alt"></i> Обновить</button>
                      {{-- <button  type="submit" class="btn btn-info btn-lg" onclick="printContent('tablePrint')"><i class="fas fa-print"></i> Печатать</button> --}}
                      {{-- <button type="button" class="btn btn-success btn-lg" onclick="exportContent(event)"><i class="fas fa-save"></i> Экспорт</button> --}}
                  </div>
                </div>
              </div>
            </form>
            <div class="chart">
            <canvas id="barChart" style="height: 230px; width: 518px;" height="230" width="518"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script type="text/javascript">   
    {{-- 
    $(function () {
      /* ChartJS
       * -------
       * Here we will create a few charts using ChartJS
       */

      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas1 = $('#pieChart1').get(0).getContext('2d');
      var pieChart1       = new Chart(pieChartCanvas1);
      var PieData1        = [
        {
          value    : 7,
          color    : '#f56954',
          highlight: '#f56954',
          label    : 'Chrome'
        },
        {
          value    : 5,
          color    : '#00a65a',
          highlight: '#00a65a',
          label    : 'IE'
        },
        {
          value    : 4,
          color    : '#f39c12',
          highlight: '#f39c12',
          label    : 'FireFox'
        },
        {
          value    : 6,
          color    : '#00c0ef',
          highlight: '#00c0ef',
          label    : 'Safari'
        },
        {
          value    : 3,
          color    : '#3c8dbc',
          highlight: '#3c8dbc',
          label    : 'Opera'
        },
        {
          value    : 1,
          color    : '#d2d6de',
          highlight: '#d2d6de',
          label    : 'Navigator'
        }
      ]
      var pieOptions1     = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke    : true,
        //String - The colour of each segment stroke
        segmentStrokeColor   : '#fff',
        //Number - The width of each segment stroke
        segmentStrokeWidth   : 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps       : 100,
        //String - Animation easing effect
        animationEasing      : 'easeOutBounce',
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate        : true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale         : false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive           : true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio  : true,
        //String - A legend template
        legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      pieChart1.Doughnut(PieData1, pieOptions1);


      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d');
      var pieChart2       = new Chart(pieChartCanvas2);
      var PieData2        = [
        {
          value    : 700,
          color    : '#f56954',
          highlight: '#f56954',
          label    : 'Chrome'
        },
        {
          value    : 500,
          color    : '#00a65a',
          highlight: '#00a65a',
          label    : 'IE'
        },
        {
          value    : 400,
          color    : '#f39c12',
          highlight: '#f39c12',
          label    : 'FireFox'
        },
        {
          value    : 600,
          color    : '#00c0ef',
          highlight: '#00c0ef',
          label    : 'Safari'
        },
        {
          value    : 300,
          color    : '#3c8dbc',
          highlight: '#3c8dbc',
          label    : 'Opera'
        },
        {
          value    : 100,
          color    : '#d2d6de',
          highlight: '#d2d6de',
          label    : 'Navigator'
        }
      ]
      var pieOptions2     = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke    : true,
        //String - The colour of each segment stroke
        segmentStrokeColor   : '#fff',
        //Number - The width of each segment stroke
        segmentStrokeWidth   : 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps       : 100,
        //String - Animation easing effect
        animationEasing      : 'easeOutBounce',
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate        : true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale         : false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive           : true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio  : true,
        //String - A legend template
        legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      pieChart2.Doughnut(PieData2, pieOptions2);

      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas3 = $('#pieChart3').get(0).getContext('2d');
      var pieChart3       = new Chart(pieChartCanvas3);
      var PieData3        = [
        {
          value    : 700,
          color    : '#f56954',
          highlight: '#f56954',
          label    : 'Chrome'
        },
        {
          value    : 500,
          color    : '#00a65a',
          highlight: '#00a65a',
          label    : 'IE'
        },
        {
          value    : 400,
          color    : '#f39c12',
          highlight: '#f39c12',
          label    : 'FireFox'
        },
        {
          value    : 600,
          color    : '#00c0ef',
          highlight: '#00c0ef',
          label    : 'Safari'
        },
        {
          value    : 300,
          color    : '#3c8dbc',
          highlight: '#3c8dbc',
          label    : 'Opera'
        },
        {
          value    : 100,
          color    : '#d2d6de',
          highlight: '#d2d6de',
          label    : 'Navigator'
        }
      ]
      var pieOptions3     = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke    : true,
        //String - The colour of each segment stroke
        segmentStrokeColor   : '#fff',
        //Number - The width of each segment stroke
        segmentStrokeWidth   : 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps       : 100,
        //String - Animation easing effect
        animationEasing      : 'easeOutBounce',
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate        : true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale         : false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive           : true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio  : true,
        //String - A legend template
        legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      pieChart3.Doughnut(PieData3, pieOptions3);
    });
    --}}

    $(function () {
      //-------------
      //- BAR CHART -
      //-------------
      var areaChartData = {
        {{-- 
        labels  : ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        --}}
        labels  : [
        @foreach ($billings as $key => $billing)
          '{{ $billing->wua ? $billing->wua->name_ru : $billing->wua_name }}',
        @endforeach
        ],
        datasets: [
          {
            label               : 'Объем требуемой воды (тыс л/год)',
            // fillColor           : 'rgba(210, 214, 222, 1)',
            fillColor           : 'blue',
            // strokeColor         : 'rgba(210, 214, 222, 1)',
            strokeColor         : 'blue',
            // pointColor          : 'rgba(210, 214, 222, 1)',
            pointColor          : 'blue',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : [ 
            @foreach ($billings as $key => $billing)
              {{ number_format($billing->water_vol/1000, 2) }},
            @endforeach
            ]
          },
          {
            label               : 'Объем исполь. воды (тыс л/год)',
            fillColor           : 'rgba(60,141,188,0.9)',
            strokeColor         : 'rgba(60,141,188,0.8)',
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : [
            @foreach ($billings as $key => $billing)
              {{ number_format($billing->water_vol_fact, 2) }},
            @endforeach
            ]
          }
        ]
      }

      var barChartCanvas                   = $('#barChart').get(0).getContext('2d');
      var barChart                         = new Chart(barChartCanvas);
      var barChartData                     = areaChartData;
      barChartData.datasets[1].fillColor   = '#00a65a';
      barChartData.datasets[1].strokeColor = '#00a65a';
      barChartData.datasets[1].pointColor  = '#00a65a';
      var barChartOptions                  = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero        : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines      : true,
        //String - Colour of the grid lines
        scaleGridLineColor      : 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth      : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines  : true,
        //Boolean - If there is a stroke on each bar
        barShowStroke           : true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth          : 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing         : 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing       : 1,
        {{-- 
        //String - A legend template
        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>', 
        --}}
        //Boolean - whether to make the chart responsive
        responsive              : true,
        maintainAspectRatio     : true
      }

      barChartOptions.datasetFill = false;
      barChart.Bar(barChartData, barChartOptions);
    });
	</script>

@stop
