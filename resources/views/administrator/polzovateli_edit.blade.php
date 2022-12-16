@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Пользователь</h1>
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
      <div class="box">
        <form role="form" id="editItemForm" action="{{ route('administrator.polzovateli.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $polzovatel->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_name">name</label>
                <input type="text" class="form-control" id="edit_name" name="name" value="{{ $polzovatel->name }}" placeholder="name">
              </div>
              <div class="form-group">
                <label for="edit_email">email</label>
                <input readonly="true" type="email" class="form-control" id="edit_email" name="email" value="{{ $polzovatel->email }}" placeholder="email">
              </div>
              <div class="form-group">
                <label for="edit_basin_id">Бассейн</label>
                <select name="basin_id" class="form-control"  id="edit_basin_id">
                    <option value="">Выберите Бассейн</option>
                    @foreach($basins as $basin)
                        <option value="{{$basin->id}}" {{ ($polzovatel->basin_id == $basin->id) ? 'selected' : '' }}>{{$basin->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_role_id">Роль</label>
                <select name="role_id" class="form-control" id="edit_role_id">
                    <option value="">Выберите Роль</option>
                  @foreach($roles as $role)
                    <option value="{{$role->id}}" {{ ($polzovatel->role_id == $role->id) ? 'selected' : '' }}>{{$role->name_ru}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_password">password</label>
                <input type="password" class="form-control" id="edit_password" name="password" value="" placeholder="password">
              </div>
              <div class="form-group">
                <label for="edit_password_confirmation">password_confirmation</label>
                <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" value="" placeholder="password_confirmation">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('administrator.polzovateli.index') }}" class="btn btn-danger">Назад</a>
            <button class="btn btn-primary" type="submit" onclick="submitItemForm()">Сохранить</button>
          </div>
        </form>
      </div>
@stop



@section('js')
	<script type="text/javascript">		
    function submitItemForm(e) {
      e.preventDefault();
      $("#editItemForm").submit();
      $('.btnSubmit').prop('disabled', true);
    }
	</script>

@stop
