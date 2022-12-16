@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Расход и объем воды в АВП</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.qwua.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $qwua->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_wua_id">wua_id</label>
                <input type="text" class="form-control" id="edit_wua_id" name="wua_id" value="{{ $qwua->wua_id }}" placeholder="wua_id">
              </div>
              <div class="form-group">
                <label for="edit_region_id">region_id</label>
                <input type="text" class="form-control" id="edit_region_id" name="region_id" value="{{ $qwua->region_id }}" placeholder="region_id">
              </div>
              <div class="form-group">
                <label for="edit_qwua_avg">qwua_avg</label>
                <input type="text" class="form-control" id="edit_qwua_avg" name="qwua_avg" value="{{ $qwua->qwua_avg }}" placeholder="qwua_avg">
              </div>
              <div class="form-group">
                <label for="edit_volume_w">volume_w</label>
                <input type="text" class="form-control" id="edit_volume_w" name="volume_w" value="{{ $qwua->volume_w }}" placeholder="volume_w">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.qwua.index') }}" class="btn btn-danger">Назад</a>
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
