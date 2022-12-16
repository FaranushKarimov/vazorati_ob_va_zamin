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
          <h3 class="box-title">Гидропосты</h3>
          <br>
          <div class="box-tools"></div>
        </div>
        <div class="box-body">
          <form method="GET" action="{{ route('modeli.hydropost.index') }}">
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
            {{ $hydroposts->links() }}
          </div>
          <br>

          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewItemModal">
            <i class="fas fa-plus"></i> Добвить 
          </button>
          <br>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Изменить</th>
                <th style="width: 30px">{{ $columns["id"] }}</th>
                <th>{{ $columns["counter_hydropost_id"] }}</th>
                <th>{{ $columns["canal_id"] }}</th>
                <th>{{ $columns["wua_id"] }}</th>
                <th>{{ $columns["name_ru"] }}</th>
                <th>{{ $columns["name_tj"] }}</th>
                <th>{{ $columns["name_en"] }}</th>
                <th>{{ $columns["year_of_commissioning"] }}</th>
                <th>{{ $columns["woc"] }}</th>
                <th>{{ $columns["type"] }}</th>
                <th>{{ $columns["district"] }}</th>
                <th>{{ $columns["region"] }}</th>
                <th>{{ $columns["republic"] }}</th>
                <th>{{ $columns["source"] }}</th>
                <th>{{ $columns["technical_condition"] }}</th>
                <th>{{ $columns["created_at"] }}</th>
                <th>{{ $columns["updated_at"] }}</th>
              </tr>
            </thead>
            @foreach ($hydroposts as $hydropost)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $hydropost->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.hydropost.edit',$hydropost->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $hydropost->id }}</td>
              <td>{{ $hydropost->counter_hydropost_id }}</td>
              <td>{{ $hydropost->canal ? $hydropost->canal->name_ru : $hydropost->canal_id }}</td>
              <td>{{ $hydropost->wua ? $hydropost->wua->name_ru : $hydropost->wua_id }}</td>
              <td>{{ $hydropost->name_ru }}</td>
              <td>{{ $hydropost->name_tj }}</td>
              <td>{{ $hydropost->name_en }}</td>
              <td>{{ $hydropost->year_of_commissioning }}</td>
              <td>{{ $hydropost->woc }}</td>
              <td>{{ ($hydropost->type==2) ? 'водозаборный в АВП' : (($hydropost->type==3) ? 'водоcбросный с АВП' : $hydropost->type) }}</td>
              <td>{{ $hydropost->district }}</td>
              <td>{{ $hydropost->region }}</td>
              <td>{{ $hydropost->republic }}</td>
              <td>{{ $hydropost->source }}</td>
              <td>{{ $hydropost->technical_condition }}</td>
              <td>{{ $hydropost->created_at }}</td>
              <td>{{ $hydropost->updated_at }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $hydroposts->links() }}
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
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.hydropost.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_counter_hydropost_id">{{ $columns["counter_hydropost_id"] }}</label>
                <input type="text" class="form-control" id="add_counter_hydropost_id" name="counter_hydropost_id" placeholder='{{ $columns["counter_hydropost_id"] }}'>
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
                <label for="add_wua_id"><span>{{ $columns["wua_id"] }}</span></label>
                <select name="wua_id" class="form-control"  id="add_wua_id">
                    <option value="">Выберите {{ $columns["wua_id"] }}</option>
                    @foreach($wuas as $wua)
                        <option value="{{$wua->id}}">{{$wua->name_ru}}</option>
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
                <label for="add_year_of_commissioning">{{ $columns["year_of_commissioning"] }}</label>
                <input type="text" class="form-control" id="add_year_of_commissioning" name="year_of_commissioning" placeholder='{{ $columns["year_of_commissioning"] }}'>
              </div>
              <div class="form-group">
                <label for="add_woc">{{ $columns["woc"] }}</label>
                <input type="text" class="form-control" id="add_woc" name="woc" placeholder='{{ $columns["woc"] }}'>
              </div>
              <div class="form-group">
                <label for="add_type">{{ $columns["type"] }}</label>
                <input type="text" class="form-control" id="add_type" name="type" placeholder='{{ $columns["type"] }}'>
              </div>
              <div class="form-group">
                <label for="add_district">{{ $columns["district"] }}</label>
                <input type="text" class="form-control" id="add_district" name="district" placeholder='{{ $columns["district"] }}'>
              </div>
              <div class="form-group">
                <label for="add_region">{{ $columns["region"] }}</label>
                <input type="text" class="form-control" id="add_region" name="region" placeholder='{{ $columns["region"] }}'>
              </div>
              <div class="form-group">
                <label for="add_republic">{{ $columns["republic"] }}</label>
                <input type="text" class="form-control" id="add_republic" name="republic" placeholder='{{ $columns["republic"] }}'>
              </div>
              <div class="form-group">
                <label for="add_source">{{ $columns["source"] }}</label>
                <input type="text" class="form-control" id="add_source" name="source" placeholder='{{ $columns["source"] }}'>
              </div>
              <div class="form-group">
                <label for="add_technical_condition">{{ $columns["technical_condition"] }}</label>
                <input type="text" class="form-control" id="add_technical_condition" name="technical_condition" placeholder='{{ $columns["technical_condition"] }}'>
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
         var url = '{{ route("modeli.hydropost.destroy", ":id") }}';
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
          url: "{{ route('modeli.hydropost_ajax_canal') }}",
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
          url: "{{ route('modeli.hydropost_ajax_wua') }}",
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
          url: "{{ route('modeli.hydropost_ajax_canal') }}",
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
          url: "{{ route('modeli.hydropost_ajax_wua') }}",
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
