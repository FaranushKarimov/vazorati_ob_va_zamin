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
                <label for="edit_name_ru">{{ $columns["name_ru"] }}</label>
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
                <label for="edit_power_generation">Выработка электроэнергии(мегаВт/год)</label>
                <input type="number" class="form-control" id="edit_power_generation" name="power_generation" value="{{ $hydroelectric->power_generation }}" placeholder="power_generation">
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
