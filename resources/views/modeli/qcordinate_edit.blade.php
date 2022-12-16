@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Таблица координат (Q)</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.qcordinate.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $qcordinate->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_hydropost_id">hydropost_id</label>
                <input type="text" class="form-control" id="edit_hydropost_id" name="hydropost_id" value="{{ $qcordinate->hydropost_id }}" placeholder="hydropost_id">
              </div>
              <div class="form-group">
                <label for="edit_height">height</label>
                <input type="text" class="form-control" id="edit_height" name="height" value="{{ $qcordinate->height }}" placeholder="height">
              </div>
              <div class="form-group">
                <label for="edit_flow">flow</label>
                <input type="text" class="form-control" id="edit_flow" name="flow" value="{{ $qcordinate->flow }}" placeholder="flow">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.qcordinate.index') }}" class="btn btn-danger">Назад</a>
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
