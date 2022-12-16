@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Область</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.oblast.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $oblast->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_basin_id">basin_id</label>
                <input type="text" class="form-control" id="edit_basin_id" name="basin_id" value="{{ $oblast->basin_id }}" placeholder="basin_id">
              </div>
              <div class="form-group">
                <label for="edit_drainage_id">drainage_id</label>
                <input type="text" class="form-control" id="edit_drainage_id" name="drainage_id" value="{{ $oblast->drainage_id }}" placeholder="drainage_id">
              </div>
              <div class="form-group">
                <label for="edit_name_ru">name_ru</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $oblast->name_ru }}" placeholder="name_ru">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">name_tj</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $oblast->name_tj }}" placeholder="name_tj">
              </div>
              <div class="form-group">
                <label for="edit_name_en">name_en</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $oblast->name_en }}" placeholder="name_en">
              </div>
              <div class="form-group">
                <label for="edit_district">district</label>
                <input type="text" class="form-control" id="edit_district" name="district" value="{{ $oblast->district }}" placeholder="district">
              </div>
              <div class="form-group">
                <label for="edit_republic">republic</label>
                <input type="text" class="form-control" id="edit_republic" name="republic" value="{{ $oblast->republic }}" placeholder="republic">
              </div>
              <div class="form-group">
                <label for="edit_source">source</label>
                <input type="text" class="form-control" id="edit_source" name="source" value="{{ $oblast->source }}" placeholder="source">
              </div>
              <div class="form-group">
                <label for="edit_area">area</label>
                <input type="text" class="form-control" id="edit_area" name="area" value="{{ $oblast->area }}" placeholder="area">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.oblast.index') }}" class="btn btn-danger">Назад</a>
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
