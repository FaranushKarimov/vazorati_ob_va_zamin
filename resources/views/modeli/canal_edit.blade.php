@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Каналы</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.canal.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">{{ $columns["id"] }}</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $canal->id }}" placeholder="{{ $columns["id"] }}">
              </div>
              <div class="form-group">
                <label for="edit_basin_id">{{ $columns["basin_id"] }}</label>
                <select name="basin_id" class="form-control"  id="edit_basin_id">
                    <option value="">Выберите Бассейн</option>
                    @foreach($basins as $basin)
                        <option value="{{$basin->id}}" {{ ( $basin->id == $canal->basin_id ) ? 'selected' : '' }}>{{$basin->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_river_id">{{ $columns["river_id"] }}</label>
                <select name="river_id" class="form-control"  id="edit_river_id">
                    <option value="">Выберите Реки</option>
                    @foreach($rivers as $river)
                        <option value="{{$river->id}}" {{ ( $river->id == $canal->river_id ) ? 'selected' : '' }}>{{$river->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_name_ru">{{ $columns["name_ru"] }}</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $canal->name_ru }}" placeholder="{{ $columns["name_ru"] }}">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">{{ $columns["name_tj"] }}</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $canal->name_tj }}" placeholder="{{ $columns["name_tj"] }}">
              </div>
              <div class="form-group">
                <label for="edit_name_en">{{ $columns["name_en"] }}</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $canal->name_en }}" placeholder="{{ $columns["name_en"] }}">
              </div>
              <div class="form-group">
                <label for="edit_district">{{ $columns["district"] }}</label>
                <input type="text" class="form-control" id="edit_district" name="district" value="{{ $canal->district }}" placeholder="{{ $columns["district"] }}">
              </div>
              <div class="form-group">
                <label for="edit_region">{{ $columns["region"] }}</label>
                <input type="text" class="form-control" id="edit_region" name="region" value="{{ $canal->region }}" placeholder="{{ $columns["region"] }}">
              </div>
              <div class="form-group">
                <label for="edit_republic">{{ $columns["republic"] }}</label>
                <input type="text" class="form-control" id="edit_republic" name="republic" value="{{ $canal->republic }}" placeholder="{{ $columns["republic"] }}">
              </div>
              <div class="form-group">
                <label for="edit_source">{{ $columns["source"] }}</label>
                <input type="text" class="form-control" id="edit_source" name="source" value="{{ $canal->source }}" placeholder="{{ $columns["source"] }}">
              </div>
              <div class="form-group">
                <label for="edit_year_of_commissioning">{{ $columns["year_of_commissioning"] }}</label>
                <input type="text" class="form-control" id="edit_year_of_commissioning" name="year_of_commissioning" value="{{ $canal->year_of_commissioning }}" placeholder="{{ $columns["year_of_commissioning"] }}">
              </div>
              <div class="form-group">
                <label for="edit_material">{{ $columns["material"] }}</label>
                <input type="text" class="form-control" id="edit_material" name="material" value="{{ $canal->material }}" placeholder="{{ $columns["material"] }}">
              </div>
              <div class="form-group">
                <label for="edit_bandwidth">{{ $columns["bandwidth"] }}</label>
                <input type="text" class="form-control" id="edit_bandwidth" name="bandwidth" value="{{ $canal->bandwidth }}" placeholder="{{ $columns["bandwidth"] }}">
              </div>
              <div class="form-group">
                <label for="edit_top_width">{{ $columns["top_width"] }}</label>
                <input type="text" class="form-control" id="edit_top_width" name="top_width" value="{{ $canal->top_width }}" placeholder="{{ $columns["top_width"] }}">
              </div>
              <div class="form-group">
                <label for="edit_bottom_width">{{ $columns["bottom_width"] }}</label>
                <input type="text" class="form-control" id="edit_bottom_width" name="bottom_width" value="{{ $canal->bottom_width }}" placeholder="{{ $columns["bottom_width"] }}">
              </div>
              <div class="form-group">
                <label for="edit_depth">{{ $columns["depth"] }}</label>
                <input type="text" class="form-control" id="edit_depth" name="depth" value="{{ $canal->depth }}" placeholder="{{ $columns["depth"] }}">
              </div>
              <div class="form-group">
                <label for="edit_length">{{ $columns["length"] }}</label>
                <input type="text" class="form-control" id="edit_length" name="length" value="{{ $canal->length }}" placeholder="{{ $columns["length"] }}">
              </div>
              <div class="form-group">
                <label for="edit_serviced_land">{{ $columns["serviced_land"] }}</label>
                <input type="text" class="form-control" id="edit_serviced_land" name="serviced_land" value="{{ $canal->serviced_land }}" placeholder="{{ $columns["serviced_land"] }}">
              </div>
              <div class="form-group">
                <label for="edit_water_protection_strips">{{ $columns["water_protection_strips"] }}</label>
                <input type="text" class="form-control" id="edit_water_protection_strips" name="water_protection_strips" value="{{ $canal->water_protection_strips }}" placeholder="{{ $columns["water_protection_strips"] }}">
              </div>
              <div class="form-group">
                <label for="edit_number_of_water_outlets">{{ $columns["number_of_water_outlets"] }}</label>
                <input type="text" class="form-control" id="edit_number_of_water_outlets" name="number_of_water_outlets" value="{{ $canal->number_of_water_outlets }}" placeholder="{{ $columns["number_of_water_outlets"] }}">
              </div>
              <div class="form-group">
                <label for="edit_technical_condition">{{ $columns["technical_condition"] }}</label>
                <input type="text" class="form-control" id="edit_technical_condition" name="technical_condition" value="{{ $canal->technical_condition }}" placeholder="{{ $columns["technical_condition"] }}">
              </div>
              <div class="form-group">
                <label for="edit_notes">{{ $columns["notes"] }}</label>
                <input type="text" class="form-control" id="edit_notes" name="notes" value="{{ $canal->notes }}" placeholder="{{ $columns["notes"] }}">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.canal.index') }}" class="btn btn-danger">Назад</a>
            <button class="btnSubmit btn btn-primary" type="submit" onclick="submitItemForm()">Сохранить</button>
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
