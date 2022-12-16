@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Озера</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.lake.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $lake->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_basin_id">basin_id</label>
                <input type="text" class="form-control" id="edit_basin_id" name="basin_id" value="{{ $lake->basin_id }}" placeholder="basin_id">
              </div>
              <div class="form-group">
                <label for="edit_name_ru">name_ru</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $lake->name_ru }}" placeholder="name_ru">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">name_tj</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $lake->name_tj }}" placeholder="name_tj">
              </div>
              <div class="form-group">
                <label for="edit_name_en">name_en</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $lake->name_en }}" placeholder="name_en">
              </div>
              <div class="form-group">
                <label for="edit_woc">woc</label>
                <input type="text" class="form-control" id="edit_woc" name="woc" value="{{ $lake->woc }}" placeholder="woc">
              </div>
              <div class="form-group">
                <label for="edit_jamoat">jamoat</label>
                <input type="text" class="form-control" id="edit_jamoat" name="jamoat" value="{{ $lake->jamoat }}" placeholder="jamoat">
              </div>
              <div class="form-group">
                <label for="edit_district">district</label>
                <input type="text" class="form-control" id="edit_district" name="district" value="{{ $lake->district }}" placeholder="district">
              </div>
              <div class="form-group">
                <label for="edit_region">region</label>
                <input type="text" class="form-control" id="edit_region" name="region" value="{{ $lake->region }}" placeholder="region">
              </div>
              <div class="form-group">
                <label for="edit_republic">republic</label>
                <input type="text" class="form-control" id="edit_republic" name="republic" value="{{ $lake->republic }}" placeholder="republic">
              </div>
              <div class="form-group">
                <label for="edit_area">area</label>
                <input type="text" class="form-control" id="edit_area" name="area" value="{{ $lake->area }}" placeholder="area">
              </div>
              <div class="form-group">
                <label for="edit_volume">volume</label>
                <input type="text" class="form-control" id="edit_volume" name="volume" value="{{ $lake->volume }}" placeholder="volume">
              </div>
              <div class="form-group">
                <label for="edit_elevation">elevation</label>
                <input type="text" class="form-control" id="edit_elevation" name="elevation" value="{{ $lake->elevation }}" placeholder="elevation">
              </div>
              <div class="form-group">
                <label for="edit_bandwidth">bandwidth</label>
                <input type="text" class="form-control" id="edit_bandwidth" name="bandwidth" value="{{ $lake->bandwidth }}" placeholder="bandwidth">
              </div>
              <div class="form-group">
                <label for="edit_top_width">top_width</label>
                <input type="text" class="form-control" id="edit_top_width" name="top_width" value="{{ $lake->top_width }}" placeholder="top_width">
              </div>
              <div class="form-group">
                <label for="edit_bottom_width">bottom_width</label>
                <input type="text" class="form-control" id="edit_bottom_width" name="bottom_width" value="{{ $lake->bottom_width }}" placeholder="bottom_width">
              </div>
              <div class="form-group">
                <label for="edit_depth">depth</label>
                <input type="text" class="form-control" id="edit_depth" name="depth" value="{{ $lake->depth }}" placeholder="depth">
              </div>
              <div class="form-group">
                <label for="edit_length">length</label>
                <input type="text" class="form-control" id="edit_length" name="length" value="{{ $lake->length }}" placeholder="length">
              </div>
              <div class="form-group">
                <label for="edit_serviced_land">serviced_land</label>
                <input type="text" class="form-control" id="edit_serviced_land" name="serviced_land" value="{{ $lake->serviced_land }}" placeholder="serviced_land">
              </div>
              <div class="form-group">
                <label for="edit_water_protection_strips">water_protection_strips</label>
                <input type="text" class="form-control" id="edit_water_protection_strips" name="water_protection_strips" value="{{ $lake->water_protection_strips }}" placeholder="water_protection_strips">
              </div>
              <div class="form-group">
                <label for="edit_number_of_water_outlets">number_of_water_outlets</label>
                <input type="text" class="form-control" id="edit_number_of_water_outlets" name="number_of_water_outlets" value="{{ $lake->number_of_water_outlets }}" placeholder="number_of_water_outlets">
              </div>
              <div class="form-group">
                <label for="edit_technical_condition">technical_condition</label>
                <input type="text" class="form-control" id="edit_technical_condition" name="technical_condition" value="{{ $lake->technical_condition }}" placeholder="technical_condition">
              </div>
              <div class="form-group">
                <label for="edit_notes">notes</label>
                <input type="text" class="form-control" id="edit_notes" name="notes" value="{{ $lake->notes }}" placeholder="notes">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.lake.index') }}" class="btn btn-danger">Назад</a>
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
