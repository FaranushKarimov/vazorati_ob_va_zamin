@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Роль</h1>
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
        <form role="form" id="editItemForm" action="{{ route('administrator.roli.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $role->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_title">title</label>
                <input type="text" class="form-control" id="edit_title" name="title" value="{{ $role->title }}" placeholder="title">
              </div>
              <div class="form-group">
                <label for="edit_name_ru">name_ru</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $role->name_ru }}" placeholder="name_ru">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">name_tj</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $role->name_tj }}" placeholder="name_tj">
              </div>
              <div class="form-group">
                <label for="edit_name_en">name_en</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $role->name_en }}" placeholder="name_en">
              </div>
              <div class="form-group">
                <label for="edit_description">description</label>
                <input type="text" class="form-control" id="edit_description" name="description" value="{{ $role->description }}" placeholder="description">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('administrator.roli.index') }}" class="btn btn-danger">Назад</a>
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
