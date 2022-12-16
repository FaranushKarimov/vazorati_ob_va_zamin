@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Справочник</h1>
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
          <h3 class="box-title">АВП</h3>
          <br>
          <div class="box-tools"></div>
        </div>
        <div class="box-body">
          <form method="GET" action="{{ route('modeli.wua.index') }}">
            <div class="row">
              <div class="col-xs-4">
                <div class="form-group">
                  <label for="basin_id"><span>Бассейн</span></label>
                  <select name="basin_id" class="form-control"  id="filter_basin">
                      <option value="">Выберите Бассейн</option>
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
            </div>
            <div class="row">
              <div class="col-xs-4">
                <div class="form-group ">
                    <button type="submit" class="btn btn-primary btn-lg" >Обновить</button>
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
            {{ $wuas->links() }}
          </div>
          <br>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewItemModal">
              <i class="fas fa-plus"></i> Добвить 
            </button>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Изменить</th>
                <th style="width: 30px">{{ $columns["id"] }}</th>
                <th>{{ $columns["billing_id"] }}</th>
                <th>{{ $columns["irrigation_id"] }}</th>
                <th>{{ $columns["basin_id"] }}</th>
                <th>{{ $columns["region_id"] }}</th>
                <th>{{ $columns["canal_id"] }}</th>
                <th>{{ $columns["name_ru"] }}</th>
                <th>{{ $columns["name_tj"] }}</th>
                <th>{{ $columns["name_en"] }}</th>
                <th>{{ $columns["service_area"] }}</th>
                <th>{{ $columns["irrigation_lands"] }}</th>
                <th>{{ $columns["district"] }}</th>
                <th>{{ $columns["republic"] }}</th>
                <th>{{ $columns["created_at"] }}</th>
                <th>{{ $columns["updated_at"] }}</th>
              </tr>
            </thead>
            @foreach ($wuas as $wua)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $wua->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.wua.edit',$wua->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $wua->id }}</td>
              <td>{{ $wua->billing_id }}</td>
              <td>{{ $wua->irrigation_id }}</td>
              <td>{{ $wua->basin ? $wua->basin->name_ru : $wua->basin_id }}</td>
              <td>{{ $wua->regionR ? $wua->regionR->name_ru : $wua->region_id }}</td>
              <td>{{ $wua->canal ? $wua->canal->name_ru : $wua->canal_id }}</td>
              <td>{{ $wua->name_ru }}</td>
              <td>{{ $wua->name_tj }}</td>
              <td>{{ $wua->name_en }}</td>
              <td>{{ $wua->service_area }}</td>
              <td>{{ $wua->irrigation_lands }}</td>
              <td>{{ $wua->district }}</td>
              <td>{{ $wua->republic }}</td>
              <td>{{ $wua->created_at }}</td>
              <td>{{ $wua->updated_at }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $wuas->links() }}
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
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.wua.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_billing_id">{{ $columns["billing_id"] }}</label>
                <input type="text" class="form-control" id="add_billing_id" name="billing_id" placeholder='{{ $columns["billing_id"] }}'>
              </div>
              <div class="form-group">
                <label for="add_irrigation_id"><span>{{ $columns["irrigation_id"] }}</span></label>
                <select name="irrigation_id" class="form-control"  id="add_irrigation_id">
                    <option value="">Выберите {{ $columns["irrigation_id"] }}</option>
                    @foreach($irrigations as $irrigation)
                        <option value="{{$irrigation->id}}">{{$irrigation->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="add_basin_id"><span>{{ $columns["basin_id"] }}</span></label>
                <select name="basin_id" class="form-control"  id="add_basin_id">
                    <option value="">Выберите {{ $columns["basin_id"] }}</option>
                    @foreach($basins as $basin)
                        <option value="{{$basin->id}}">{{$basin->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="add_region_id"><span>{{ $columns["region_id"] }}</span></label>
                <select name="region_id" class="form-control"  id="add_region_id">
                    <option value="">Выберите {{ $columns["region_id"] }}</option>
                    @foreach($regions as $region)
                        <option value="{{$region->id}}">{{$region->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="add_canal_id"><span>{{ $columns["canal_id"] }}</span></label>
                <select name="canal_id" class="form-control"  id="add_canal_id">
                    <option value="">Выберите {{ $columns["canal_id"] }}</option>
                    @foreach($canals as $canal)
                        <option value="{{$canal->id}}">{{$canal->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="add_name_ru">{{ $columns["name_ru"] }}</label>
                <input type="text" class="form-control" id="add_name_ru" name="name_ru" placeholder='{{ $columns["name_ru"] }}'>
              </div>
              <div class="form-group">
                <label for="add_name_tj">{{ $columns["name_tj"] }}</label>
                <input type="text" class="form-control" id="add_name_tj" name="name_tj" placeholder='{{ $columns["name_tj"] }}'>
              </div>
              <div class="form-group">
                <label for="add_name_en">{{ $columns["name_en"] }}</label>
                <input type="text" class="form-control" id="add_name_en" name="name_en" placeholder='{{ $columns["name_en"] }}'>
              </div>
              <div class="form-group">
                <label for="add_service_area">{{ $columns["service_area"] }}</label>
                <input type="text" class="form-control" id="add_service_area" name="service_area" placeholder='{{ $columns["service_area"] }}'>
              </div>
              <div class="form-group">
                <label for="add_irrigation_lands">{{ $columns["irrigation_lands"] }}</label>
                <input type="number" class="form-control" id="add_irrigation_lands" name="irrigation_lands" placeholder='{{ $columns["irrigation_lands"] }}'>
              </div>
              <div class="form-group">
                <label for="add_district">{{ $columns["district"] }}</label>
                <input type="text" class="form-control" id="add_district" name="district" placeholder='{{ $columns["district"] }}'>
              </div>
              <div class="form-group">
                <label for="add_republic">{{ $columns["republic"] }}</label>
                <input type="text" class="form-control" id="add_republic" name="republic" placeholder='{{ $columns["republic"] }}'>
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
    function deleteItem(id) {
         var id = id;
         var url = '{{ route("modeli.wua.destroy", ":id") }}';
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
      @if(app('request')->input('canal_id'))
        $.ajax({
          url: "{{ route('modeli.wua_ajax_canal') }}",
          method: 'get',
          cache: false,
          data: {
             'basin_id': {{ app('request')->input('basin_id') }},
          },
          success: function(result){
            if(result.errors)
            {
              // alert("Ошибка!");
              // $('.alert-danger').html('');

              // $.each(result.errors, function(key, value){
              //   $('.alert-danger').show();
              //   $('.alert-danger').append('<li>'+value+'</li>');
              // });
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

      $('#filter_basin').change(function(e){
        e.preventDefault();
        /*$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });*/
        $.ajax({
          url: "{{ route('modeli.wua_ajax_canal') }}",
          method: 'get',
          cache: false,
          data: {
             'basin_id': $('#filter_basin').val(),
          },
          success: function(result){
            if(result.errors)
            {
              // alert("Ошибка!");
              // $('.alert-danger').html('');

              // $.each(result.errors, function(key, value){
              //   $('.alert-danger').show();
              //   $('.alert-danger').append('<li>'+value+'</li>');
              // });
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
