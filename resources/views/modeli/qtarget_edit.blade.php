@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>План водопользования</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.qtarget.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $qtarget->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_wua_id">wua_id</label>
                <input type="text" class="form-control" id="edit_wua_id" name="wua_id" value="{{ $qtarget->wua_id }}" placeholder="wua_id">
              </div>
              <div class="form-group">
                <label for="edit_region_id">region_id</label>
                <input type="text" class="form-control" id="edit_region_id" name="region_id" value="{{ $qtarget->region_id }}" placeholder="region_id">
              </div>
              <div class="form-group">
                <label for="edit_qms_plan_per_day">qms_plan_per_day</label>
                <input type="text" class="form-control" id="edit_qms_plan_per_day" name="qms_plan_per_day" value="{{ $qtarget->qms_plan_per_day }}" placeholder="qms_plan_per_day">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.qtarget.index') }}" class="btn btn-danger">Назад</a>
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
