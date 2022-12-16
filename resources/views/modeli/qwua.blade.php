@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Водоподача</h1>
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
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Расход и объем воды в АВП</h3>
          <br>
          <div class="box-tools"></div>
        </div>
        <div class="box-body">
          <form method="GET" action="{{ route('modeli.qwua.index') }}">
            <div class="row">
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
                  <label for="canal_id"><span>Магистральный Канал</span></label>
                  <select name="canal_id" class="form-control" id="filter_canal">
                      <option value ="">Выберите Канал</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-4">
                  <div class="form-group">
                    <label for="wua_id"><span>АВП</span></label>
                    <select name="wua_id" class="form-control" id="filter_wua">
                        <option value="">Выберите АВП</option>
                    </select>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <div class="form-group">
                  <label for="filter_year"><span>Год</span></label>
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
                  <label for="filter_month"><span>Месяц</span></label>
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
              <div class="col-xs-4">
                <div class="form-group ">
                    <button type="submit" class="btn btn-primary btn-lg" >Обновить</button>
                    {{-- <button  type="submit" class="btn btn-primary btn-lg" >Печатать</button> --}}
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
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"></h3>
          <br>
          <div class="box-tools">
            {{ $qwuas->links() }}
          </div>
          <br>
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewItemModal">
            <i class="fas fa-plus"></i> Добвить 
          </button>
          <br>
          <br>
          <form method="GET" action="{{ route('modeli.qwua.index') }}">
            <input type="hidden" name="update_qwua" value="yes">
            <button type="submit" class="btn btn-danger btn-sm" id="btn_update_qwua">
              <i class="fas fa-sync"></i> Расчитать 
            </button>
          </form>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Изменить</th>
                <th style="width: 30px">{{ $columns["id"] }}</th>
                <th>{{ $columns["wua_id"] }}</th>
                <th>{{ $columns["region_id"] }}</th>
                <th>{{ $columns["qwua_avg"] }}</th>
                <th>{{ $columns["volume_w"] }}</th>
                <th>{{ $columns["date"] }}</th>
                <th>{{ $columns["created_at"] }}</th>
                <th>{{ $columns["updated_at"] }}</th>
              </tr>
            </thead>
            @foreach ($qwuas as $qwua)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $qwua->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.qwua.edit',$qwua->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $qwua->id }}</td>
              <td>{{ $qwua->wua ? $qwua->wua->name_ru : $qwua->wua_id }}</td>
              <td>{{ $qwua->region ? $qwua->region->name_ru : $qwua->region_id }}</td>
              <td>{{ $qwua->qwua_avg }}</td>
              <td>{{ $qwua->volume_w }}</td>
              <td>{{ $qwua->date }}</td>
              <td>{{ $qwua->created_at }}</td>
              <td>{{ $qwua->updated_at }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $qwuas->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addNewItemModal" tabindex="-1" role="dialog" aria-labelledby="addNewItemModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="addNewItemModalLabel">Добвить</h4>
        </div>
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.qwua.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_wua_id"><span>АВП</span></label>
                <select name="wua_id" class="form-control"  id="add_wua_id">
                    <option value="">Выберите АВП</option>
                    @foreach($wuas as $wua)
                        <option value="{{$wua->id}}">{{$wua->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="add_region_id"><span>Район</span></label>
                <select name="region_id" class="form-control"  id="add_region_id">
                    <option value="">Выберите Район</option>
                    @foreach($regions_add as $region)
                        <option value="{{$region->id}}">{{$region->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="add_qwua_avg">{{ $columns["qwua_avg"] }}</label>
                <input type="text" class="form-control" id="add_qwua_avg" name="qwua_avg" placeholder='{{ $columns["qwua_avg"] }}'>
              </div>
              <div class="form-group">
                <label for="add_volume_w">{{ $columns["volume_w"] }}</label>
                <input type="text" class="form-control" id="add_volume_w" name="volume_w" placeholder='{{ $columns["volume_w"] }}'>
              </div>
              <div class="form-group">
                <label for="add_date">{{ $columns["date"] }}</label>
                <input type="date" class="form-control" id="add_date" name="date" placeholder='{{ $columns["date"] }}'>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
            <button type="submit" class="btnSubmit btn btn-primary" onclick="submitItemForm()">Добвить</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal modal-danger fade" id="deleteItemModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Подтверждение</h4>
        </div>
        <div class="modal-body">
          <p>Вы действительно хотите удалить?</p>
        </div>
        <div class="modal-footer">
          <form id="deleteItemForm" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="button" class="btn btn-info pull-left" data-dismiss="modal">Отмена</button>
            <button type="button" class="btn btn-danger" onclick="submitDeleteItemForm()">Удалить</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@stop



@section('js')
	<script type="text/javascript">		
    function deleteItem(id)
     {
         var id = id;
         var url = '{{ route("modeli.qwua.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteItemForm").attr('action', url);
     }
     function submitDeleteItemForm() {
      $("#deleteItemForm").submit();
    }

    function submitItemForm(e) {
      e.preventDefault();
      $("#addItemForm").submit();
      $('.btnSubmit').prop('disabled', true);
    }

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
          url: "{{ route('modeli.qwua_ajax_canal') }}",
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
          url: "{{ route('modeli.qwua_ajax_wua') }}",
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
          url: "{{ route('modeli.qwua_ajax_canal') }}",
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
          url: "{{ route('modeli.qwua_ajax_wua') }}",
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