@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>АВП</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.wua.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">{{ $columns["id"] }}</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $wua->id }}" placeholder="{{ $columns["id"] }}">
              </div>
              <div class="form-group">
                <label for="edit_billing_id">{{ $columns["billing_id"] }}</label>
                <input type="text" class="form-control" id="edit_billing_id" name="billing_id" value="{{ $wua->billing_id }}" placeholder="{{ $columns["billing_id"] }}">
              </div>
              <div class="form-group">
                <label for="edit_basin_id">{{ $columns["basin_id"] }}</label>
                <select name="basin_id" class="form-control"  id="edit_basin_id">
                    <option value="">Выберите Бассейн</option>
                    @foreach($basins as $basin)
                        <option value="{{$basin->id}}" {{ ( $basin->id == $wua->basin_id ) ? 'selected' : '' }}>{{$basin->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_irrigation_id">{{ $columns["irrigation_id"] }}</label>
                <select name="irrigation_id" class="form-control"  id="edit_irrigation_id">
                    <option value="">Выберите Ирригационную Систему</option>
                    @foreach($irrigations as $irrigation)
                        <option value="{{$irrigation->id}}" {{ ( $irrigation->id == $wua->irrigation_id ) ? 'selected' : '' }}>{{$irrigation->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_region_id">{{ $columns["region_id"] }}</label>
                <select name="region_id" class="form-control"  id="edit_region_id">
                    <option value="">Выберите Область</option>
                    @foreach($regions as $region)
                        <option value="{{$region->id}}" {{ ( $region->id == $wua->region_id ) ? 'selected' : '' }}>{{$region->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_canal_id">{{ $columns["canal_id"] }}</label>
                <select name="canal_id" class="form-control"  id="edit_canal_id">
                    <option value="">Выберите Канал</option>
                    @foreach($canals as $canal)
                        <option value="{{$canal->id}}" {{ ( $canal->id == $wua->canal_id ) ? 'selected' : '' }}>{{$canal->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_name_ru">{{ $columns["name_ru"] }}</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $wua->name_ru }}" placeholder="{{ $columns["name_ru"] }}">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">{{ $columns["name_tj"] }}</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $wua->name_tj }}" placeholder="{{ $columns["name_tj"] }}">
              </div>
              <div class="form-group">
                <label for="edit_name_en">{{ $columns["name_en"] }}</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $wua->name_en }}" placeholder="{{ $columns["name_en"] }}">
              </div>
              <div class="form-group">
                <label for="edit_service_area">{{ $columns["service_area"] }}</label>
                <input type="text" class="form-control" id="edit_service_area" name="service_area" value="{{ $wua->service_area }}" placeholder="{{ $columns["service_area"] }}">
              </div>
              <div class="form-group">
                <label for="edit_irrigation_lands">{{ $columns["irrigation_lands"] }}</label>
                <input type="number" class="form-control" id="edit_irrigation_lands" name="irrigation_lands" value="{{ $wua->irrigation_lands }}" placeholder="{{ $columns["irrigation_lands"] }}">
              </div>
              <div class="form-group">
                <label for="edit_district">{{ $columns["district"] }}</label>
                <input type="text" class="form-control" id="edit_district" name="district" value="{{ $wua->district }}" placeholder="{{ $columns["district"] }}">
              </div>
              <div class="form-group">
                <label for="edit_region">{{ $columns["region"] }}</label>
                <input type="text" class="form-control" id="edit_region" name="region" value="{{ $wua->region }}" placeholder="{{ $columns["region"] }}">
              </div>
              <div class="form-group">
                <label for="edit_republic">{{ $columns["republic"] }}</label>
                <input type="text" class="form-control" id="edit_republic" name="republic" value="{{ $wua->republic }}" placeholder="{{ $columns["republic"] }}">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.wua.index') }}" class="btn btn-danger">Назад</a>
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
