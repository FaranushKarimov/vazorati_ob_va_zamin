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
          <h3 class="box-title">План водопользования</h3>
          <br>
          <div class="box-tools">
            {{ $qtargets->links() }}
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
                <th>{{ $columns["wua_id"] }}</th>
                <th>{{ $columns["region_id"] }}</th>
                <th>{{ $columns["qms_plan_per_day"] }}</th>
                <th>{{ $columns["created_at"] }}</th>
                <th>{{ $columns["updated_at"] }}</th>
              </tr>
            </thead>
            @foreach ($qtargets as $qtarget)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $qtarget->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.qtarget.edit',$qtarget->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $qtarget->id }}</td>
              <td>{{ $qtarget->wua_id }}</td>
              <td>{{ $qtarget->region_id }}</td>
              <td>{{ $qtarget->qms_plan_per_day }}</td>
              <td>{{ $qtarget->created_at }}</td>
              <td>{{ $qtarget->updated_at }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $qtargets->links() }}
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
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.qtarget.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_wua_id">{{ $columns["wua_id"] }}</label>
                <input type="text" class="form-control" id="add_wua_id" name="wua_id" placeholder='{{ $columns["wua_id"] }}'>
              </div>
              <div class="form-group">
                <label for="add_region_id">{{ $columns["region_id"] }}</label>
                <input type="text" class="form-control" id="add_region_id" name="region_id" placeholder='{{ $columns["region_id"] }}'>
              </div>
              <div class="form-group">
                <label for="add_qms_plan_per_day">{{ $columns["qms_plan_per_day"] }}</label>
                <input type="text" class="form-control" id="add_qms_plan_per_day" name="qms_plan_per_day" placeholder='{{ $columns["qms_plan_per_day"] }}'>
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
         var url = '{{ route("modeli.qtarget.destroy", ":id") }}';
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