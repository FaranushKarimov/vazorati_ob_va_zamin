@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Главные реки</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.main-river.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $main_river->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_basin_id">basin_id</label>
                <input type="text" class="form-control" id="edit_basin_id" name="basin_id" value="{{ $main_river->basin_id }}" placeholder="basin_id">
              </div>
              <div class="form-group">
                <label for="edit_catchment_id">catchment_id</label>
                <input type="text" class="form-control" id="edit_catchment_id" name="catchment_id" value="{{ $main_river->catchment_id }}" placeholder="catchment_id">
              </div>
              <div class="form-group">
                <label for="edit_name_ru">name_ru</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $main_river->name_ru }}" placeholder="name_ru">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">name_tj</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $main_river->name_tj }}" placeholder="name_tj">
              </div>
              <div class="form-group">
                <label for="edit_name_en">name_en</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $main_river->name_en }}" placeholder="name_en">
              </div>
              <div class="form-group">
                <label for="edit_woc">woc</label>
                <input type="text" class="form-control" id="edit_woc" name="woc" value="{{ $main_river->woc }}" placeholder="woc">
              </div>
              <div class="form-group">
                <label for="edit_region">region</label>
                <input type="text" class="form-control" id="edit_region" name="region" value="{{ $main_river->region }}" placeholder="region">
              </div>
              <div class="form-group">
                <label for="edit_republic">republic</label>
                <input type="text" class="form-control" id="edit_republic" name="republic" value="{{ $main_river->republic }}" placeholder="republic">
              </div>
              <div class="form-group">
                <label for="edit_length">length</label>
                <input type="text" class="form-control" id="edit_length" name="length" value="{{ $main_river->length }}" placeholder="length">
              </div>
              <div class="form-group">
                <label for="edit_annual_drain">annual_drain</label>
                <input type="text" class="form-control" id="edit_annual_drain" name="annual_drain" value="{{ $main_river->annual_drain }}" placeholder="annual_drain">
              </div>
              <div class="form-group">
                <label for="edit_watershed_area">watershed_area</label>
                <input type="text" class="form-control" id="edit_watershed_area" name="watershed_area" value="{{ $main_river->watershed_area }}" placeholder="watershed_area">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.main-river.index') }}" class="btn btn-danger">Назад</a>
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
