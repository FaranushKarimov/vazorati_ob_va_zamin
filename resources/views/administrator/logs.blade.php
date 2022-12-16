@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>История (Logs)</h1>
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
          <div class="box-tools"></div>
        </div>
        <div class="box-body">
          <form method="GET" action="{{ route('administrator.logs.index') }}">
            <div class="row">
              <div class="col-xs-4">
                <div class="form-group">
                  <label for="user_id"><span>Пользователь</span></label>
                  <select name="user_id" class="form-control"  id="filter_user">
                      <option value="">Выберите Пользователя</option>
                      @foreach($users as $user)
                          <option value="{{$user->id}}" {{ ( $user->id == app('request')->input('user_id') ) ? 'selected' : '' }}>{{$user->name}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="form-group">
                  <label for="filter_type"><span>Тип операции</span></label>
                  <select name="type" class="form-control"  id="filter_type">
                      <option value="">Выберите Тип</option>
                      @foreach($type_filters as $type_filter)
                          <option value="{{$type_filter['name']}}" {{ ( $type_filter['name'] == app('request')->input('type') ) ? 'selected' : '' }}>{{$type_filter['name']}}</option>
                      @endforeach
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
        <div class="box box-solid">
          <div class="box-header">
            <h3 class="box-title"></h3>
            <br>
            <div class="box-tools">
              {{ $operation_logs->links() }}
            </div>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr class="align-middle">
                  <th>{{ $columns['id'] }}</th>
                  <th>{{ $columns['user_id'] }}</th>
                  <th>{{ $columns['type'] }}</th>
                  <th>{{ $columns['operation'] }}</th>
                  <th>{{ $columns['created_at'] }}</th>
                  <th>{{ $columns['notes'] }}</th>
                  <th>{{ $columns['updated_at'] }}</th>
                  <th></th>
                </tr>
              </thead>
              @foreach ($operation_logs as $key => $operation_log)
              <tr class="item-data-row">
                <td>{{ $operation_log->id }}</td>
                <td>{{ $operation_log->user ? $operation_log->user->name : $operation_log->user_id }}</td>
                <td>{{ $operation_log->type }}</td>
                <td>{{ $operation_log->operation }}</td>
                <td>{{ $operation_log->created_at }}</td>
                <td>{{ $operation_log->notes }}</td>
                <td>{{ $operation_log->updated_at }}</td>
                <td>
                  <div class="btn-group-vertical">
                    {{-- <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $operation_log->id }})"><i class="fas fa-trash"></i></button> --}}
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewItemModal" onclick="editItem({{ $operation_log->id }},'{{ $operation_log->notes }}')"><i class="fas fa-edit"></i></button>
                  </div>
                </td>
              </tr>
              @endforeach
            </table>
          </div>
          <div class="box-footer">
            <div class="text-right">
              {{ $operation_logs->links() }}
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
          <h4 class="modal-title" id="addNewItemModalLabel">{{ $columns["notes"] }}</h4>
        </div>
        <form id="addItemForm" role="form" method="POST" accept-charset="UTF-8">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_notes">{{ $columns["notes"] }}</label>
                <input type="text" class="form-control" id="add_notes" name="notes" value="{{ old('notes') }}" placeholder='{{ $columns["notes"] }}'>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
            <button type="submit" class="btnSubmit btn btn-primary" onclick="submitItemForm(event)">Добвить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script type="text/javascript">
    function editItem(id,notes) {
      var url = '{{ route("administrator.logs.update", ":id") }}';
      url = url.replace(':id', id);
      $("#addItemForm").attr('action', url);
      $("#add_notes").attr('value', notes);
      // $("#log_id").attr('value', id);
    }

    function submitItemForm(e) {
      e = e || window.event;
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

