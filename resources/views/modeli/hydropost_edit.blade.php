@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Гидропосты</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.hydropost.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $hydropost->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_counter_hydropost_id">counter_hydropost_id</label>
                <input type="text" class="form-control" id="edit_counter_hydropost_id" name="counter_hydropost_id" value="{{ $hydropost->counter_hydropost_id }}" placeholder="counter_hydropost_id">
              </div>
              <div class="form-group">
                <label for="edit_wua_id">wua_id</label>
                <input type="text" class="form-control" id="edit_wua_id" name="wua_id" value="{{ $hydropost->wua_id }}" placeholder="wua_id">
              </div>
              <div class="form-group">
                <label for="edit_canal_id">canal_id</label>
                <input type="text" class="form-control" id="edit_canal_id" name="canal_id" value="{{ $hydropost->canal_id }}" placeholder="canal_id">
              </div>
              <div class="form-group">
                <label for="edit_name_ru">name_ru</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $hydropost->name_ru }}" placeholder="name_ru">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">name_tj</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $hydropost->name_tj }}" placeholder="name_tj">
              </div>
              <div class="form-group">
                <label for="edit_name_en">name_en</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $hydropost->name_en }}" placeholder="name_en">
              </div>
              <div class="form-group">
                <label for="edit_year_of_commissioning">year_of_commissioning</label>
                <input type="text" class="form-control" id="edit_year_of_commissioning" name="year_of_commissioning" value="{{ $hydropost->year_of_commissioning }}" placeholder="year_of_commissioning">
              </div>
              <div class="form-group">
                <label for="edit_woc">woc</label>
                <input type="text" class="form-control" id="edit_woc" name="woc" value="{{ $hydropost->woc }}" placeholder="woc">
              </div>
              <div class="form-group">
                <label for="edit_type">type</label>
                <input type="text" class="form-control" id="edit_type" name="type" value="{{ $hydropost->type }}" placeholder="type">
              </div>
              <div class="form-group">
                <label for="edit_district">district</label>
                <input type="text" class="form-control" id="edit_district" name="district" value="{{ $hydropost->district }}" placeholder="district">
              </div>
              <div class="form-group">
                <label for="edit_region">region</label>
                <input type="text" class="form-control" id="edit_region" name="region" value="{{ $hydropost->region }}" placeholder="region">
              </div>
              <div class="form-group">
                <label for="edit_republic">republic</label>
                <input type="text" class="form-control" id="edit_republic" name="republic" value="{{ $hydropost->republic }}" placeholder="republic">
              </div>
              <div class="form-group">
                <label for="edit_source">source</label>
                <input type="text" class="form-control" id="edit_source" name="source" value="{{ $hydropost->source }}" placeholder="source">
              </div>
              <div class="form-group">
                <label for="edit_technical_condition">technical_condition</label>
                <input type="text" class="form-control" id="edit_technical_condition" name="technical_condition" value="{{ $hydropost->technical_condition }}" placeholder="technical_condition">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.hydropost.index') }}" class="btn btn-danger">Назад</a>
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
