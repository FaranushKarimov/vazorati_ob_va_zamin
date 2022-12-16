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
          <h3 class="box-title">Главные реки</h3>
          <br>
          <div class="box-tools">
            {{ $main_rivers->links() }}
          </div>
          <br>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewItemModal">
              <i class="fas fa-plus"></i> Добавить 
            </button>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Изменить</th>
                <th style="width: 30px">{{ $columns["id"] }}</th>
                <th>{{ $columns["basin_id"] }}</th>
                <th>{{ $columns["catchment_id"] }}</th>
                <th>{{ $columns["name_ru"] }}</th>
                <th>{{ $columns["name_tj"] }}</th>
                <th>{{ $columns["name_en"] }}</th>
                <th>{{ $columns["woc"] }}</th>
                <th>{{ $columns["region"] }}</th>
                <th>{{ $columns["republic"] }}</th>
                <th>{{ $columns["length"] }}</th>
                <th>{{ $columns["annual_drain"] }}</th>
                <th>{{ $columns["watershed_area"] }}</th>
                <th>{{ $columns["created_at"] }}</th>
                <th>{{ $columns["updated_at"] }}</th>
              </tr>
            </thead>
            @foreach ($main_rivers as $main_river)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $main_river->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.main-river.edit',$main_river->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $main_river->id }}</td>
              {{-- <td>{{ $main_river->basin_id }}</td> --}}
              <td>{{ $main_river->basin ? $main_river->basin->name_ru : $main_river->basin_id }}</td>
              <td>{{ $main_river->catchment_id }}</td>
              <td>{{ $main_river->name_ru }}</td>
              <td>{{ $main_river->name_tj }}</td>
              <td>{{ $main_river->name_en }}</td>
              <td>{{ $main_river->woc }}</td>
              <td>{{ $main_river->region }}</td>
              <td>{{ $main_river->republic }}</td>
              <td>{{ $main_river->length }}</td>
              <td>{{ $main_river->annual_drain }}</td>
              <td>{{ $main_river->watershed_area }}</td>
              <td>{{ $main_river->created_at }}</td>
              <td>{{ $main_river->updated_at }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $main_rivers->links() }}
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
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.main-river.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_basin_id">{{ $columns["basin_id"] }}</label>
                <input type="text" class="form-control" id="add_basin_id" name="basin_id" placeholder='{{ $columns["basin_id"] }}'>
              </div>
              <div class="form-group">
                <label for="add_catchment_id">{{ $columns["catchment_id"] }}</label>
                <input type="text" class="form-control" id="add_catchment_id" name="catchment_id" placeholder='{{ $columns["catchment_id"] }}'>
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
                <label for="add_region">{{ $columns["region"] }}</label>
                <input type="text" class="form-control" id="add_region" name="region" placeholder='{{ $columns["region"] }}'>
              </div>
              <div class="form-group">
                <label for="add_republic">{{ $columns["republic"] }}</label>
                <input type="text" class="form-control" id="add_republic" name="republic" placeholder='{{ $columns["republic"] }}'>
              </div>
              <div class="form-group">
                <label for="add_length">{{ $columns["length"] }}</label>
                <input type="text" class="form-control" id="add_length" name="length" placeholder='{{ $columns["length"] }}'>
              </div>
              <div class="form-group">
                <label for="add_annual_drain">{{ $columns["annual_drain"] }}</label>
                <input type="text" class="form-control" id="add_annual_drain" name="annual_drain" placeholder='{{ $columns["annual_drain"] }}'>
              </div>
              <div class="form-group">
                <label for="add_watershed_area">{{ $columns["watershed_area"] }}</label>
                <input type="text" class="form-control" id="add_watershed_area" name="watershed_area" placeholder='{{ $columns["watershed_area"] }}'>
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
         var url = '{{ route("modeli.main-river.destroy", ":id") }}';
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