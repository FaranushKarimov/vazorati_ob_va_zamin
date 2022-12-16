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
          <h3 class="box-title">Озера</h3>
          <br>
          <div class="box-tools">
            {{ $lakes->links() }}
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
                <th>{{ $columns["basin_id"] }}</th>
                <th>{{ $columns["name_ru"] }}</th>
                <th>{{ $columns["name_tj"] }}</th>
                <th>{{ $columns["name_en"] }}</th>
                <th>{{ $columns["woc"] }}</th>
                <th>{{ $columns["jamoat"] }}</th>
                <th>{{ $columns["district"] }}</th>
                <th>{{ $columns["region"] }}</th>
                <th>{{ $columns["republic"] }}</th>
                <th>{{ $columns["area"] }}</th>
                <th>{{ $columns["volume"] }}</th>
                <th>{{ $columns["elevation"] }}</th>
              </tr>
            </thead>
            @foreach ($lakes as $lake)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $lake->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.lake.edit',$lake->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $lake->id }}</td>
              <td>{{ $lake->basin ? $lake->basin->name_ru : $lake->basin_id }}</td>
              <td>{{ $lake->name_ru }}</td>
              <td>{{ $lake->name_tj }}</td>
              <td>{{ $lake->name_en }}</td>
              <td>{{ $lake->woc }}</td>
              <td>{{ $lake->jamoat }}</td>
              <td>{{ $lake->district }}</td>
              <td>{{ $lake->region }}</td>
              <td>{{ $lake->republic }}</td>
              <td>{{ $lake->area }}</td>
              <td>{{ $lake->volume }}</td>
              <td>{{ $lake->elevation }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $lakes->links() }}
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
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.lake.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_basin_id">{{ $columns["basin_id"] }}</label>
                <input type="text" class="form-control" id="add_basin_id" name="basin_id" placeholder='{{ $columns["basin_id"] }}'>
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
                <label for="add_woc">{{ $columns["woc"] }}</label>
                <input type="text" class="form-control" id="add_woc" name="woc" placeholder='{{ $columns["woc"] }}'>
              </div>
              <div class="form-group">
                <label for="add_jamoat">{{ $columns["jamoat"] }}</label>
                <input type="text" class="form-control" id="add_jamoat" name="jamoat" placeholder='{{ $columns["jamoat"] }}'>
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
                <label for="add_area">{{ $columns["area"] }}</label>
                <input type="text" class="form-control" id="add_area" name="area" placeholder='{{ $columns["area"] }}'>
              </div>
              <div class="form-group">
                <label for="add_volume">{{ $columns["volume"] }}</label>
                <input type="text" class="form-control" id="add_volume" name="volume" placeholder='{{ $columns["volume"] }}'>
              </div>
              <div class="form-group">
                <label for="add_elevation">{{ $columns["elevation"] }}</label>
                <input type="text" class="form-control" id="add_elevation" name="elevation" placeholder='{{ $columns["elevation"] }}'>
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
         var url = '{{ route("modeli.lake.destroy", ":id") }}';
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
