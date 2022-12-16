@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Зоны обслуживания ирригацией</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.irrigation.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $irrigation->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_basin_id">basin_id</label>
                <input type="text" class="form-control" id="edit_basin_id" name="basin_id" value="{{ $irrigation->basin_id }}" placeholder="basin_id">
              </div>
              <div class="form-group">
                <label for="edit_name_ru">name_ru</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $irrigation->name_ru }}" placeholder="name_ru">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">name_tj</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $irrigation->name_tj }}" placeholder="name_tj">
              </div>
              <div class="form-group">
                <label for="edit_name_en">name_en</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $irrigation->name_en }}" placeholder="name_en">
              </div>
              <div class="form-group">
                <label for="edit_district">district</label>
                <input type="text" class="form-control" id="edit_district" name="district" value="{{ $irrigation->district }}" placeholder="district">
              </div>
              <div class="form-group">
                <label for="edit_region">region</label>
                <input type="text" class="form-control" id="edit_region" name="region" value="{{ $irrigation->region }}" placeholder="region">
              </div>
              <div class="form-group">
                <label for="edit_republic">republic</label>
                <input type="text" class="form-control" id="edit_republic" name="republic" value="{{ $irrigation->republic }}" placeholder="republic">
              </div>
              <div class="form-group">
                <label for="edit_source">source</label>
                <input type="text" class="form-control" id="edit_source" name="source" value="{{ $irrigation->source }}" placeholder="source">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.irrigation.index') }}" class="btn btn-danger">Назад</a>
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
