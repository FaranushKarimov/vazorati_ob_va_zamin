@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Пользователи</h1>
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
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border" data-widget="collapse">
                  <h3 class="box-title">Фильтр</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="box-body">
                  <form role="form" method="GET" action="{{ route('administrator.polzovateli.index') }}" accept-charset="UTF-8">
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
                            <label for="role_id"><span>Роль</span></label>
                            <select name="role_id" class="form-control" id="filter_role">
                                <option value="">Выберите Роль</option>
                              @foreach($roles as $role)
                                <option value="{{$role->id}}" {{ ( $role->id == app('request')->input('role_id') ) ? 'selected' : '' }}>{{$role->name_ru}}</option>
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
              {{ $polzovatels->links() }}
            </div>
            <br>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewItemModal">
              <i class="fas fa-plus"></i> Добвить 
            </button>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr class="align-middle">
                  <th>Изменить</th>
                  <th>{{ $columns['id'] }}</th>
                  <th>{{ $columns['name'] }}</th>
                  <th>{{ $columns['email'] }}</th>
                  <th>{{ $columns['basin_id'] }}</th>
                  <th>{{ $columns['role_id'] }}</th>
                  <th>{{ $columns['created_at'] }}</th>
                  <th>{{ $columns['updated_at'] }}</th>
                </tr>
              </thead>
              @foreach ($polzovatels as $key => $polzovatel)
              <tr class="item-data-row">
                <td>
                  <div class="btn-group-vertical">
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $polzovatel->id }})"><i class="fas fa-trash"></i></button>
                    <a href="{{ route('administrator.polzovateli.edit',$polzovatel->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                  </div>
                </td>
                <td>{{ $polzovatel->id }}</td>
                <td>{{ $polzovatel->name }}</td>
                <td>{{ $polzovatel->email }}</td>
                <td>{{ $polzovatel->basin ? $polzovatel->basin->name_ru : $polzovatel->basin_id }}</td>
                <td>{{ $polzovatel->role ? $polzovatel->role->name_ru : $polzovatel->role_id }}</td>
                <td>{{ $polzovatel->created_at }}</td>
                <td>{{ $polzovatel->updated_at }}</td>
              </tr>
              @endforeach
            </table>
          </div>
          <div class="box-footer">
            <div class="text-right">
              {{ $polzovatels->links() }}
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
        <form id="addItemForm" role="form" method="POST" action="{{ route('administrator.polzovateli.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_name">{{ $columns["name"] }}</label>
                <input type="text" class="form-control" id="add_name" name="name" value="{{ old('name') }}" placeholder='{{ $columns["name"] }}'>
              </div>
              <div class="form-group">
                <label for="add_email">{{ $columns["email"] }}</label>
                <input type="email" class="form-control" id="add_email" name="email" value="{{ old('email') }}" placeholder='{{ $columns["email"] }}'>
              </div>
              {{-- <div class="form-group">
                <label for="add_login">{{ $columns["login"] }}</label>
                <input type="text" class="form-control" id="add_login" name="login" placeholder='{{ $columns["login"] }}'>
              </div> --}}
              <div class="form-group">
                <label for="add_basin_id">{{ $columns["basin_id"] }}</label>
                <select name="basin_id" class="form-control"  id="add_basin_id">
                    <option value="">Выберите Бассейн</option>
                    @foreach($basins as $basin)
                        <option value="{{$basin->id}}" {{ (old('basin_id') == $basin->id) ? 'selected' : '' }}>{{$basin->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="add_role_id">{{ $columns["role_id"] }}</label>
                <select name="role_id" class="form-control" id="add_role_id">
                    <option value="">Выберите Роль</option>
                  @foreach($roles as $role)
                    <option value="{{$role->id}}" {{ (old('role_id') == $role->id) ? 'selected' : '' }}>{{$role->name_ru}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="add_password">{{ $columns["password"] }}</label>
                <input type="password" class="form-control" id="add_password" name="password" placeholder='{{ $columns["password"] }}'>
              </div>
              <div class="form-group">
                <label for="add_password_confirmation">{{ $columns["password_confirmation"] }}</label>
                <input type="password" class="form-control" id="add_password_confirmation" name="password_confirmation" placeholder='{{ $columns["password_confirmation"] }}'>
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
         var url = '{{ route("administrator.polzovateli.destroy", ":id") }}';
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

