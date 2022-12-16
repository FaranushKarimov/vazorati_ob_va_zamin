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
          <h3 class="box-title">ГЭС</h3>
          <br>
          <div class="box-tools">
            {{ $hydroelectrics->links() }}
          </div>
          <br>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewItemModal">
              <i class="fas fa-plus"></i> Добавить 
            </button>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addNewItemModal">
              <i class="fas fa-save"></i> Экспорт 
            </button>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Изменить</th>
                <th style="width: 30px">{{ $columns["id"] }}</th> 
                <th>{{ $columns["name_ru"] }}</th>
                <th>{{ $columns["name_tj"] }}</th>
                <th>{{ $columns["name_en"] }}</th>
                <th>{{ $columns["state"] }}</th>
                <th>{{ $columns["town"] }}</th>
                <th>{{ $columns["hydroelectric_code"] }}</th>
                <th>{{ $columns["date"] }}</th>
                <th>{{ $columns["river"] }}</th>
                <th>{{ $columns["height"] }}</th>
                <th>{{ $columns["consumption"] }}</th>
                <th>{{ $columns["idle_reset"] }}</th>
                <th>{{ $columns["maximum_level"] }}</th>
                <th>{{ $columns["minimum_level"] }}</th>
                <th>{{ $columns["power_generation"] }}</th>
                <th>{{ $columns["volume"] }}</th>
                <th>{{ $columns["created_at"] }}</th>
                <th>{{ $columns["updated_at"] }}</th>
              </tr>
            </thead>
            @foreach ($hydroelectrics as $hydroelectric)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $hydroelectric->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.hydroelectric.edit',$hydroelectric->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $hydroelectric->id }}</td> 
              <td>{{ $hydroelectric->name_ru }}</td> 
              <td>{{ $hydroelectric->name_tj }}</td>
              <td>{{ $hydroelectric->name_en }}</td>
              <td>{{ $hydroelectric->state }}</td>
              <td>{{ $hydroelectric->town }}</td>
              <td>{{ $hydroelectric->hydroelectric_code }}</td>
              <td>{{ $hydroelectric->date }}</td>
              <td>{{ $hydroelectric->river }}</td>
              <td>{{ $hydroelectric->height }}</td>
              <td>{{ $hydroelectric->consumption }}</td>
              <td>{{ $hydroelectric->idle_reset }}</td>
              <td>{{ $hydroelectric->maximum_level }}</td>
              <td>{{ $hydroelectric->minimum_level }}</td>
              <td>{{ $hydroelectric->power_generation }}</td>
              <td>{{ $hydroelectric->volume }}</td>
              <td>{{ $hydroelectric->created_at }}</td>
              <td>{{ $hydroelectric->updated_at }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $hydroelectrics->links() }}
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
          <h4 class="modal-title" id="addNewItemModalLabel">Добавить</h4>
        </div>
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.hydroelectric.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
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
                <label for="add_state">{{ $columns["state"] }}</label>
                <input type="text" class="form-control" id="add_state" name="state" placeholder='{{ $columns["state"] }}'>
              </div>
              <div class="form-group">
                <label for="add_town">{{ $columns["town"] }}</label>
                <input type="text" class="form-control" id="add_town" name="town" placeholder='{{ $columns["town"] }}'>
              </div>
              <div class="form-group">
                <label for="add_hydroelectric_code">{{ $columns["hydroelectric_code"] }}</label>
                <input type="number" class="form-control" id="add_hydroelectric_code" name="hydroelectric_code" placeholder='{{ $columns["hydroelectric_code"] }}'>
              </div>
              <div class="form-group">
                <label for="add_date">{{ $columns["date"] }}</label>
                <input type="date" class="form-control" id="add_date" name="date" placeholder='{{ $columns["date"] }}'>
              </div>
              <div class="form-group">
                <label for="add_river">{{ $columns["river"] }}</label>
                <input type="text" class="form-control" id="add_river" name="river" placeholder='{{ $columns["river"] }}'>
              </div>
              <div class="form-group">
                <label for="add_height">{{ $columns["height"] }}</label>
                <input type="number" class="form-control" id="add_height" name="height" placeholder='{{ $columns["height"] }}'>
              </div>
              <div class="form-group">
                <label for="add_consumption">{{ $columns["consumption"] }}</label>
                <input type="number" class="form-control" id="add_consumption" name="consumption" placeholder='{{ $columns["consumption"] }}'>
              </div>
              <div class="form-group">
                <label for="add_idle_reset">{{ $columns["idle_reset"] }}</label>
                <input type="number" class="form-control" id="add_idle_reset" name="idle_reset" placeholder='{{ $columns["idle_reset"] }}'>
              </div>
              <div class="form-group">
                <label for="add_maximum_level">{{ $columns["maximum_level"] }}</label>
                <input type="number" class="form-control" id="add_maximum_level" name="maximum_level" placeholder='{{ $columns["maximum_level"] }}'>
              </div>
              <div class="form-group">
                <label for="add_idle_reset">{{ $columns["minimum_level"] }}</label>
                <input type="number" class="form-control" id="add_minimum_level" name="minimum_level" placeholder='{{ $columns["minimum_level"] }}'>
              </div>
              <div class="form-group">
                <label for="add_power_generation">{{ $columns["power_generation"] }}</label>
                <input type="number" class="form-control" id="add_power_generation" name="power_generation" placeholder='{{ $columns["power_generation"] }}'>
              </div>
              <div class="form-group">
                <label for="add_volume">{{ $columns["volume"] }}</label>
                <input type="number" class="form-control" id="add_volume" name="volume" placeholder='{{ $columns["volume"] }}'>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
            <button type="submit" class="btnSubmit btn btn-primary" onclick="submitItemForm()">Добавить</button>
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
        var url = '{{ route("modeli.hydroelectric.destroy", ":id") }}';
        url = url.replace(':id', id);
        console.log(url);
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