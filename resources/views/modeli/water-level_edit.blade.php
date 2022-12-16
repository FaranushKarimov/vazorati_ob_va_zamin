@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Уровень воды</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.water-level.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $water_level->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_hydropost_id">hydropost_id</label>
                <input type="text" class="form-control" id="edit_hydropost_id" name="hydropost_id" value="{{ $water_level->hydropost_id }}" placeholder="hydropost_id">
              </div>
              <div class="form-group">
                <label for="edit_height_h_8">height_h_8</label>
                <input type="text" class="form-control" id="edit_height_h_8" name="height_h_8" value="{{ $water_level->height_h_8 }}" placeholder="height_h_8">
              </div>
              <div class="form-group">
                <label for="edit_height_h_12">height_h_12</label>
                <input type="text" class="form-control" id="edit_height_h_12" name="height_h_12" value="{{ $water_level->height_h_12 }}" placeholder="height_h_12">
              </div>
              <div class="form-group">
                <label for="edit_height_h_16">height_h_16</label>
                <input type="text" class="form-control" id="edit_height_h_16" name="height_h_16" value="{{ $water_level->height_h_16 }}" placeholder="height_h_16">
              </div>
              <div class="form-group">
                <label for="edit_flow_q">flow_q</label>
                <input type="text" class="form-control" id="edit_flow_q" name="flow_q" value="{{ $water_level->flow_q }}" placeholder="flow_q">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.water-level.index') }}" class="btn btn-danger">Назад</a>
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
