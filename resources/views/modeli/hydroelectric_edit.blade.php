@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>ГЭС</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.hydroelectric.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">{{ $columns['id'] }}</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $hydroelectric->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_name_ru">Название ГЭС на русском языке</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $hydroelectric->name_ru }}"  placeholder="name_ru">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">Название ГЭС на таджикском языке</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $hydroelectric->name_tj }}"  placeholder="name_tj">
              </div>
              <div class="form-group">
                <label for="edit_name_en">Название ГЭС на английском языке</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $hydroelectric->name_en }}" placeholder="name_en">
              </div>
              <div class="form-group">
                <label for="edit_state">Название области</label>
                <input type="text" class="form-control" id="edit_state" name="state" value="{{ $hydroelectric->state }}" placeholder="state">
              </div>
              <div class="form-group">
                <label for="edit_town">Название района</label>
                <input type="text" class="form-control" id="edit_town" name="town" value="{{ $hydroelectric->town }}" placeholder="town">
              </div>
              <div class="form-group">
                <label for="edit_hydroelectric_code">Код ГЭС</label>
                <input type="number" class="form-control" id="edit_hydroelectric_code" name="hydroelectric_code" value="{{ $hydroelectric->hydroelectric_code }}" placeholder="hydroelectric_code">
              </div>
              <div class="form-group">
                <label for="edit_date">Дата эксплуатации</label>
                <input type="date" class="form-control" id="edit_date" name="date" value="{{ $hydroelectric->date }}" placeholder="date">
              </div>
              <div class="form-group">
                <label for="edit_river">Река (источник воды)</label>
                <input type="text" class="form-control" id="edit_river" name="river" value="{{ $hydroelectric->river }}" placeholder="river">
              </div>
              <div class="form-group">
                <label for="edit_height">Высота плотины (метр)</label>
                <input type="number" class="form-control" id="edit_height" name="height" value="{{ $hydroelectric->height }}" placeholder="height">
              </div>
              <div class="form-group">
                <label for="edit_consumption">Расход воды через турбины(кубический метр в час)</label>
                <input type="number" class="form-control" id="edit_consumption" name="consumption"  value="{{ $hydroelectric->consumption }}" placeholder="consumption">
              </div>
              <div class="form-group">
                <label for="edit_idle_reset">Холостой сброс(кубический метр в час)</label>
                <input type="number" class="form-control" id="edit_idle_reset" name="idle_reset" value="{{ $hydroelectric->idle_reset }}" placeholder="idle_reset">
              </div>
              <div class="form-group">
            <label for="edit_maximum_level">Максимальный уровень верхнего бьефа (метр)</label>
                <input type="number" class="form-control" id="edit_maximum_level" name="maximum_level" value="{{ $hydroelectric->maximum_level }}" placeholder="maximum_level">
              </div>
              <div class="form-group">
                <label for="edit_minimum_level">Минимальный уровень верхнего бьефа(метр)</label>
                <input type="number" step="0.01" class="form-control" id="edit_minimum_level" name="minimum_level" value="{{ $hydroelectric->minimum_level }}" placeholder="minimum_level">
              </div>
              <div class="form-group">
                <label for="edit_power_generation">Выработка электроэнергии(мегаВт/год)</label>
                <input type="number" class="form-control" id="edit_power_generation" name="power_generation" value="{{ $hydroelectric->power_generation }}" placeholder="power_generation">
              </div>
              <div class="form-group">
                <label for="edit_volume">Объем воды водохранилища (в кубическом метре)</label>
                <input type="number" class="form-control" id="edit_volume" name="volume" value="{{ $hydroelectric->volume }}" placeholder="volume">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.hydroelectric.index') }}" class="btn btn-danger">Назад</a>
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
