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
          <h3 class="box-title">Водохранилища</h3>
          <br>
          <div class="box-tools">
            {{ $reservoirs->links() }}
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
                <th>{{ $columns["district"] }}</th>
                <th>{{ $columns["region"] }}</th>
                <th>{{ $columns["republic"] }}</th>
                <th>{{ $columns["administration"] }}</th>
                <th>{{ $columns["type"] }}</th>
                <th>{{ $columns["purpose"] }}</th>
                <th>{{ $columns["dam_type"] }}</th>
                <th>{{ $columns["watercourse"] }}</th>
                <th>{{ $columns["dam_height"] }}</th>
                <th>{{ $columns["total_vol_ml_cub_m"] }}</th>
                <th>{{ $columns["net_vol_ml_cub_m"] }}</th>
                <th>{{ $columns["area"] }}</th>
                <th>{{ $columns["created_at"] }}</th>
                <th>{{ $columns["updated_at"] }}</th>
              </tr>
            </thead>
            @foreach ($reservoirs as $reservoir)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $reservoir->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.reservoir.edit',$reservoir->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $reservoir->id }}</td>
              <td>{{ $reservoir->basin ? $reservoir->basin->name_ru : $reservoir->basin_id }}</td>
              <td>{{ $reservoir->name_ru }}</td>
              <td>{{ $reservoir->name_tj }}</td>
              <td>{{ $reservoir->name_en }}</td>
              <td>{{ $reservoir->woc }}</td>
              <td>{{ $reservoir->district }}</td>
              <td>{{ $reservoir->region }}</td>
              <td>{{ $reservoir->republic }}</td>
              <td>{{ $reservoir->administration }}</td>
              <td>{{ $reservoir->type }}</td>
              <td>{{ $reservoir->purpose }}</td>
              <td>{{ $reservoir->dam_type }}</td>
              <td>{{ $reservoir->watercourse }}</td>
              <td>{{ $reservoir->dam_height }}</td>
              <td>{{ $reservoir->total_vol_ml_cub_m }}</td>
              <td>{{ $reservoir->net_vol_ml_cub_m }}</td>
              <td>{{ $reservoir->area }}</td>
              <td>{{ $reservoir->created_at }}</td>
              <td>{{ $reservoir->updated_at }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $reservoirs->links() }}
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
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.reservoir.store') }}" accept-charset="UTF-8">
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
                <label for="add_administration">{{ $columns["administration"] }}</label>
                <input type="text" class="form-control" id="add_administration" name="administration" placeholder='{{ $columns["administration"] }}'>
              </div>
              <div class="form-group">
                <label for="add_type">{{ $columns["type"] }}</label>
                <input type="text" class="form-control" id="add_type" name="type" placeholder='{{ $columns["type"] }}'>
              </div>
              <div class="form-group">
                <label for="add_purpose">{{ $columns["purpose"] }}</label>
                <input type="text" class="form-control" id="add_purpose" name="purpose" placeholder='{{ $columns["purpose"] }}'>
              </div>
              <div class="form-group">
                <label for="add_dam_type">{{ $columns["dam_type"] }}</label>
                <input type="text" class="form-control" id="add_dam_type" name="dam_type" placeholder='{{ $columns["dam_type"] }}'>
              </div>
              <div class="form-group">
                <label for="add_watercourse">{{ $columns["watercourse"] }}</label>
                <input type="text" class="form-control" id="add_watercourse" name="watercourse" placeholder='{{ $columns["watercourse"] }}'>
              </div>
              <div class="form-group">
                <label for="add_dam_height">{{ $columns["dam_height"] }}</label>
                <input type="text" class="form-control" id="add_dam_height" name="dam_height" placeholder='{{ $columns["dam_height"] }}'>
              </div>
              <div class="form-group">
                <label for="add_total_vol_ml_cub_m">{{ $columns["total_vol_ml_cub_m"] }}</label>
                <input type="text" class="form-control" id="add_total_vol_ml_cub_m" name="total_vol_ml_cub_m" placeholder='{{ $columns["total_vol_ml_cub_m"] }}'>
              </div>
              <div class="form-group">
                <label for="add_net_vol_ml_cub_m">{{ $columns["net_vol_ml_cub_m"] }}</label>
                <input type="text" class="form-control" id="add_net_vol_ml_cub_m" name="net_vol_ml_cub_m" placeholder='{{ $columns["net_vol_ml_cub_m"] }}'>
              </div>
              <div class="form-group">
                <label for="add_area">{{ $columns["area"] }}</label>
                <input type="text" class="form-control" id="add_area" name="area" placeholder='{{ $columns["area"] }}'>
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
         var url = '{{ route("modeli.reservoir.destroy", ":id") }}';
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