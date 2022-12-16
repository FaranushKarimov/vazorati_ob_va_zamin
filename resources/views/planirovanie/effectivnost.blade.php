@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1 id="printPageTitle">Эффективность канала</h1>
@stop

@section('content')
  @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div><br />
    @endif
    @if(session()->has('message'))
      <div class="alert alert-success">
          {{ session()->get('message') }}
      </div>
    @endif
    <div class="alert alert-danger" style="display:none"></div>
    <div style="display: none;" id="printLogo">
      <div class="row">
        <div class="col">
          <div class="login-logo">
              <img width="100" src="{{ asset('img/gerb.png') }}">
              <h3>Институт водных проблем, гидроэнергетики и экологии Национальной академии наук Таджикистана</h3>
              <br>
              <h2>Эффективность канала</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border" data-widget="collapse">
                  <h3 class="box-title">Планирование</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="box-body">
                  <form id="filterForm" role="form" method="GET" action="{{ route('planirovanie.effectivnost.index') }}" accept-charset="UTF-8">
                    <div class="row" id="filterRow1">
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
                        <div class="col-xs-4">
                        <div class="form-group">
                          <label for="year"><span>Год</span></label>
                          <select name="year" class="form-control"  id="filter_year">
                              <option value="">Выберите Год</option>
                              @foreach($years as $year)
                                  <option value="{{$year}}" {{ ( $year == app('request')->input('year') ) ? 'selected' : '' }}>{{$year}}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-4">
                        <div class="form-group">
                          <label for="month"><span>Месяц</span></label>
                          <select name="month" class="form-control"  id="filter_month">
                              <option value="">Выберите Месяц</option>
                              @foreach($months as $key => $month)
                                  <option value="{{$key}}" {{ ( $key == app('request')->input('month') ) ? 'selected' : '' }}>{{$month}}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-sync-alt"></i> Обновить</button>
                            <button  type="submit" class="btn btn-info btn-lg" onclick="printContent('tablePrint')"><i class="fas fa-print"></i> Печатать</button>
                            <button type="button" class="btn btn-success btn-lg" onclick="exportContent(event)"><i class="fas fa-save"></i> Экспорт</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-header">
            {{-- @if(app('request')->input('year') && !app('request')->input('month'))
              <h3 class="box-title" id="printTotal">Итого за год {{ app('request')->input('year') }} в {{ ((app('request')->input('basin_id')) ? 'Бассейн' : 'включая всё') }}: <span class="text-primary">{{ $basin_total . ' тыс. м3'}}</span></h3>
            @endif
            @if(app('request')->input('year') && app('request')->input('month'))
              <h3 class="box-title" id="printTotal">Итого за месяц {{ $months[app('request')->input('month')] }} в {{ ((app('request')->input('basin_id')) ? 'Бассейн' : 'включая всё') }}: <span class="text-primary">{{ $basin_total . ' тыс. м3'}}</span></h3>
            @endif 
            <br> --}}
          <div class="box-header">
            <div class="box-tools">
              {{-- {{ $effect_qmss->links() }} --}}
            </div>
          </div>
          <div class="box-body table-responsive" id="tablePrint">
            <table class="table table-bordered">
              <thead>
                <tr class="align-middle">
                  <th>#</th>
                  {{-- <th>{{ $columns['id'] }}</th> --}}
                  <th>{{ $columns['basin_id'] }}</th>
                  <th>{{ $columns['canal_id'] }}</th>
                  <th>{{ $columns['volume_1'] . ((app('request')->input('month')) ? " в месяц" : " в год") }}</th>
                  <th>{{ $columns['volume_2'] . ((app('request')->input('month')) ? " в месяц" : " в год") }}</th>
                  {{-- <th>{{ $columns['volume_w'] . ((app('request')->input('month')) ? " в месяц" : " в год") }}</th> --}}
                  <th>{{ $columns['effectivnost'] }}</th>
                  <th>{{ $columns['date'] }}</th>
                </tr>
              </thead>
              @foreach ($effect_qmss as $key => $effect_qms)
              <tr class="item-data-row">
                {{-- <td>{{ $effect_qmss->firstItem() + $key }}</td> --}}
                <td>{{ $key + 1 }}</td>
                {{-- <td>{{ $effect_qms->id }}</td> --}}
                <td>{{ $effect_qms->basin ? $effect_qms->basin->name_ru : $effect_qms->basin_id }}</td>
                <td>{{ $effect_qms->canal ? $effect_qms->canal->name_ru : $effect_qms->canal_id }}</td>
                <td>{{ $effect_qms->volume_1 }}</td>
                <td>{{ $effect_qms->volume_2 }}</td>
                {{-- <td>{{ $effect_qms->volume_w }}</td> --}}
                <td>{{ $effect_qms->effectivnost }}</td>
                <td>{{ ($effect_qms->month ? $effect_qms->month . '-' : '') . $effect_qms->year }}</td>
              </tr>
              @endforeach
            </table>
          </div>
          <div class="box-footer">
            <div class="text-right">
              {{-- {{ $effect_qmss->links() }} --}}
            </div>
          </div>
        </div>
      </div>
    </div>
@stop

@section('js')
  <script type="text/javascript">   
    $(document).ready(function(){
      @if(empty(app('request')->input('canal_id')))
        setTimeout(function() { 
          $('#filter_basin').trigger("change");
        }, 0);
      @endif

      @if(empty(app('request')->input('wua_id')))
        setTimeout(function() { 
          $('#filter_canal').trigger("change");
        }, 1000);
      @endif

      @if(app('request')->input('canal_id'))
        $.ajax({
          url: "{{ route('planirovanie.effectivnost_ajax_canal') }}",
          method: 'get',
          cache: false,
          data: {
             'basin_id': {{ app('request')->input('basin_id') }},
          },
          success: function(result){
            if(result.errors)
            {
              
            }
            else
            {
              $('.alert-danger').hide();
              $('#filter_canal').find('option').remove();
              $('#filter_canal').append('<option value ="">Выберите Канал</option>');
              for (var i = result.length - 1; i >= 0; i--) {
                if(result[i].id == {{ app('request')->input('canal_id') }}){
                  $('#filter_canal').append('<option value="' + result[i].id + '" selected>' + result[i].name_ru + '</option>');
                } else {
                  $('#filter_canal').append('<option value="' + result[i].id + '">' + result[i].name_ru + '</option>');
                }
              }
            }
          },
          fail: function() {
            alert("Ошибка подключения!");
          }
        });
      @endif

      @if(app('request')->input('wua_id'))
        $.ajax({
          url: "{{ route('planirovanie.effectivnost_ajax_wua') }}",
          method: 'get',
          cache: false,
          data: {
             'canal_id': {{ app('request')->input('canal_id') }},
          },
          success: function(result){
            if(result.errors)
            {
              
            }
            else
            {
              $('.alert-danger .error').hide();
              $('#filter_wua').find('option').remove();
              $('#filter_wua').append('<option value="">Выберите АВП</option>');
              for (var i = result.length - 1; i >= 0; i--) {
                if(result[i].id == {{ app('request')->input('wua_id') }}){
                  $('#filter_wua').append('<option value="' + result[i].id + '" selected>' + result[i].name_ru + '</option>');
                } else {
                  $('#filter_wua').append('<option value="' + result[i].id + '">' + result[i].name_ru + '</option>');
                }
              }
            }
          },
          fail: function() {
            alert("Ошибка подключения!");
          }
        });
      @endif

      $('#filter_basin').change(function(e){
        e.preventDefault();
        /*$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });*/
        $.ajax({
          url: "{{ route('planirovanie.effectivnost_ajax_canal') }}",
          method: 'get',
          cache: false,
          data: {
             'basin_id': $('#filter_basin').val(),
          },
          success: function(result){
            if(result.errors)
            {
              
            }
            else
            {
              $('.alert-danger').hide();
              $('#filter_canal').find('option').remove();
              $('#filter_canal').append('<option value ="">Выберите Канал</option>');
              for (var i = result.length - 1; i >= 0; i--) {
                $('#filter_canal').append('<option value="' + result[i].id + '">' + result[i].name_ru + '</option>');
              }
            }
          },
          fail: function() {
            alert("Ошибка подключения!");
          }
        });
      });

      $('#filter_canal').change(function(e){
        e.preventDefault();
        /*$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });*/
        $.ajax({
          url: "{{ route('planirovanie.effectivnost_ajax_wua') }}",
          method: 'get',
          cache: false,
          data: {
             'canal_id': $('#filter_canal').val(),
          },
          success: function(result){
            if(result.errors)
            {
              
            }
            else
            {
              $('.alert-danger .error').hide();
              $('#filter_wua').find('option').remove();
              $('#filter_wua').append('<option value="">Выберите АВП</option>');
              for (var i = result.length - 1; i >= 0; i--) {
                $('#filter_wua').append('<option value="' + result[i].id + '">' + result[i].name_ru + '</option>');
              }
            }
          },
          fail: function() {
            alert("Ошибка подключения!");
          }
        });
      });
    });
  </script>

  <script type="text/javascript">
    // print
    function printContent(id){
      var total_e=document.getElementById("printTotal");
      var total = '';
      if(total_e){
        total = total_e.innerHTML;
      }
      var t=document.getElementById("printPageTitle").innerHTML;
      var l=document.getElementById("printLogo").innerHTML;
      // var f1=document.getElementById("filterRow1").innerHTML;
      // var f2=document.getElementById("filterRow2").innerHTML;
      var str=document.getElementById(id).innerHTML;
      var newwin=window.open('','printwin','left=100,top=100,width=2480,height=3508'); // A4 size
      newwin.document.write('<HTML>\n<HEAD>\n');
      newwin.document.write('<HTML><HEAD> <link rel=\"stylesheet\" type=\"text/css\" href=\"{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}\"/>');
      newwin.document.write('<HTML><HEAD> <link rel=\"stylesheet\" type=\"text/css\" href=\"{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}\"/>');
      newwin.document.write('<TITLE></TITLE>\n');
      newwin.document.write('<script>\n');
      newwin.document.write('function chkstate(){\n');
      newwin.document.write('if(document.readyState=="complete"){\n');
      newwin.document.write('window.close()\n');
      newwin.document.write('}\n');
      newwin.document.write('else{\n');
      newwin.document.write('setTimeout("chkstate()",2000)\n');
      newwin.document.write('}\n');
      newwin.document.write('}\n');
      newwin.document.write('function print_win(){\n');
      newwin.document.write('window.print();\n');
      newwin.document.write('chkstate();\n');
      newwin.document.write('}\n');
      newwin.document.write('<\/script>\n');
      newwin.document.write('</HEAD>\n');
      newwin.document.write('<BODY onload="print_win()">\n');
      newwin.document.write(l);
      // newwin.document.write(f1);
      // newwin.document.write(f2);
      if(total_e){
        newwin.document.write('<h4>'+total+'</h4>\n');
      }
      newwin.document.write(str);
      newwin.document.write('</BODY>\n');
      newwin.document.write('</HTML>\n');
      newwin.document.close();
    }
  </script>

  <script type="text/javascript">
    function exportContent(e){
      e = e || window.event;

      e.preventDefault();
      $("#filterForm").submit(function(eventObj){
        $("<input />").attr("type", "hidden")
          .attr("name", "export")
          .attr("value", true)
          .appendTo("#filterForm");
        return true;
      });
      $("#filterForm").submit();
      // $('.btnSubmit').prop('disabled', true);
    }
  </script>
@stop
@section('css')
    <style type="text/css">
        .table > thead > tr > th {
            vertical-align: middle !important;
            text-align: center;
        }
        .table > tbody >tr > td {
            vertical-align: middle !important;
            text-align: center !important;
        }
    </style>
@stop
