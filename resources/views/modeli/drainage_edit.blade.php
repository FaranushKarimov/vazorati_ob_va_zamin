@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Коллекторно-дренажная система</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.drainage.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">{{ $columns["id"] }}</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $drainage->id }}" placeholder="{{ $columns["id"] }}">
              </div>
              <div class="form-group">
                <label for="edit_river_id">{{ $columns["river_id"] }}</label>
                <select name="river_id" class="form-control"  id="edit_river_id">
                    <option value="">Выберите Канал</option>
                    @foreach($rivers as $river)
                        <option value="{{$river->id}}" {{ ( $river->id == $drainage->river_id ) ? 'selected' : '' }}>{{$river->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_name_ru">{{ $columns["name_ru"] }}</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $drainage->name_ru }}" placeholder="{{ $columns["name_ru"] }}">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">{{ $columns["name_tj"] }}</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $drainage->name_tj }}" placeholder="{{ $columns["name_tj"] }}">
              </div>
              <div class="form-group">
                <label for="edit_name_en">{{ $columns["name_en"] }}</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $drainage->name_en }}" placeholder="{{ $columns["name_en"] }}">
              </div>
              <div class="form-group">
                <label for="edit_woc">{{ $columns["woc"] }}</label>
                <input type="text" class="form-control" id="edit_woc" name="woc" value="{{ $drainage->woc }}" placeholder="{{ $columns["woc"] }}">
              </div>
              <div class="form-group">
                <label for="edit_type">{{ $columns["type"] }}</label>
                <input type="text" class="form-control" id="edit_type" name="type" value="{{ $drainage->type }}" placeholder="{{ $columns["type"] }}">
              </div>
              <div class="form-group">
                <label for="edit_location_of_drain">{{ $columns["location_of_drain"] }}</label>
                <input type="text" class="form-control" id="edit_location_of_drain" name="location_of_drain" value="{{ $drainage->location_of_drain }}" placeholder="{{ $columns["location_of_drain"] }}">
              </div>
              <div class="form-group">
                <label for="edit_year_of_commissioning">{{ $columns["year_of_commissioning"] }}</label>
                <input type="text" class="form-control" id="edit_year_of_commissioning" name="year_of_commissioning" value="{{ $drainage->year_of_commissioning }}" placeholder="{{ $columns["year_of_commissioning"] }}">
              </div>
              <div class="form-group">
                <label for="edit_top_width">{{ $columns["top_width"] }}</label>
                <input type="text" class="form-control" id="edit_top_width" name="top_width" value="{{ $drainage->top_width }}" placeholder="{{ $columns["top_width"] }}">
              </div>
              <div class="form-group">
                <label for="edit_bottom_width">{{ $columns["bottom_width"] }}</label>
                <input type="text" class="form-control" id="edit_bottom_width" name="bottom_width" value="{{ $drainage->bottom_width }}" placeholder="{{ $columns["bottom_width"] }}">
              </div>
              <div class="form-group">
                <label for="edit_depth">{{ $columns["depth"] }}</label>
                <input type="text" class="form-control" id="edit_depth" name="depth" value="{{ $drainage->depth }}" placeholder="{{ $columns["depth"] }}">
              </div>
              <div class="form-group">
                <label for="edit_length">{{ $columns["length"] }}</label>
                <input type="text" class="form-control" id="edit_length" name="length" value="{{ $drainage->length }}" placeholder="{{ $columns["length"] }}">
              </div>
              <div class="form-group">
                <label for="edit_water_protection_strips">{{ $columns["water_protection_strips"] }}</label>
                <input type="text" class="form-control" id="edit_water_protection_strips" name="water_protection_strips" value="{{ $drainage->water_protection_strips }}" placeholder="{{ $columns["water_protection_strips"] }}">
              </div>
              <div class="form-group">
                <label for="edit_technical_condition">{{ $columns["technical_condition"] }}</label>
                <input type="text" class="form-control" id="edit_technical_condition" name="technical_condition" value="{{ $drainage->technical_condition }}" placeholder="{{ $columns["technical_condition"] }}">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.drainage.index') }}" class="btn btn-danger">Назад</a>
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
