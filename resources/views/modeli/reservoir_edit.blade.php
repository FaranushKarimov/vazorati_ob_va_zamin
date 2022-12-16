@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Водохранилища</h1>
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
        <form role="form" id="editItemForm" action="{{ route('modeli.reservoir.update',$id) }}" method="POST" accept-charset="UTF-8">
          <div class="box-header">
            <h4 class="box-title">Изменить</h4>
          </div>
          <div class="box-body">
            @csrf
            {{ method_field('PATCH') }}
            <div class="box-body">
              <div class="form-group">
                <label for="edit_id">id</label>
                <input readonly="true" type="text" class="form-control" id="edit_id" name="id" value="{{ $reservoir->id }}" placeholder="id">
              </div>
              <div class="form-group">
                <label for="edit_basin_id">basin_id</label>
                <input type="text" class="form-control" id="edit_basin_id" name="basin_id" value="{{ $reservoir->basin_id }}" placeholder="basin_id">
              </div>
              <div class="form-group">
                <label for="edit_name_ru">name_ru</label>
                <input type="text" class="form-control" id="edit_name_ru" name="name_ru" value="{{ $reservoir->name_ru }}" placeholder="name_ru">
              </div>
              <div class="form-group">
                <label for="edit_name_tj">name_tj</label>
                <input type="text" class="form-control" id="edit_name_tj" name="name_tj" value="{{ $reservoir->name_tj }}" placeholder="name_tj">
              </div>
              <div class="form-group">
                <label for="edit_name_en">name_en</label>
                <input type="text" class="form-control" id="edit_name_en" name="name_en" value="{{ $reservoir->name_en }}" placeholder="name_en">
              </div>
              <div class="form-group">
                <label for="edit_woc">woc</label>
                <input type="text" class="form-control" id="edit_woc" name="woc" value="{{ $reservoir->woc }}" placeholder="woc">
              </div>
              <div class="form-group">
                <label for="edit_district">district</label>
                <input type="text" class="form-control" id="edit_district" name="district" value="{{ $reservoir->district }}" placeholder="district">
              </div>
              <div class="form-group">
                <label for="edit_region">region</label>
                <input type="text" class="form-control" id="edit_region" name="region" value="{{ $reservoir->region }}" placeholder="region">
              </div>
              <div class="form-group">
                <label for="edit_republic">republic</label>
                <input type="text" class="form-control" id="edit_republic" name="republic" value="{{ $reservoir->republic }}" placeholder="republic">
              </div>
              <div class="form-group">
                <label for="edit_administration">administration</label>
                <input type="text" class="form-control" id="edit_administration" name="administration" value="{{ $reservoir->administration }}" placeholder="administration">
              </div>
              <div class="form-group">
                <label for="edit_type">type</label>
                <input type="text" class="form-control" id="edit_type" name="type" value="{{ $reservoir->type }}" placeholder="type">
              </div>
              <div class="form-group">
                <label for="edit_purpose">purpose</label>
                <input type="text" class="form-control" id="edit_purpose" name="purpose" value="{{ $reservoir->purpose }}" placeholder="purpose">
              </div>
              <div class="form-group">
                <label for="edit_dam_type">dam_type</label>
                <input type="text" class="form-control" id="edit_dam_type" name="dam_type" value="{{ $reservoir->dam_type }}" placeholder="dam_type">
              </div>
              <div class="form-group">
                <label for="edit_watercourse">watercourse</label>
                <input type="text" class="form-control" id="edit_watercourse" name="watercourse" value="{{ $reservoir->watercourse }}" placeholder="watercourse">
              </div>
              <div class="form-group">
                <label for="edit_dam_height">dam_height</label>
                <input type="text" class="form-control" id="edit_dam_height" name="dam_height" value="{{ $reservoir->dam_height }}" placeholder="dam_height">
              </div>
              <div class="form-group">
                <label for="edit_total_vol_ml_cub_m">total_vol_ml_cub_m</label>
                <input type="text" class="form-control" id="edit_total_vol_ml_cub_m" name="total_vol_ml_cub_m" value="{{ $reservoir->total_vol_ml_cub_m }}" placeholder="total_vol_ml_cub_m">
              </div>
              <div class="form-group">
                <label for="edit_net_vol_ml_cub_m">net_vol_ml_cub_m</label>
                <input type="text" class="form-control" id="edit_net_vol_ml_cub_m" name="net_vol_ml_cub_m" value="{{ $reservoir->net_vol_ml_cub_m }}" placeholder="net_vol_ml_cub_m">
              </div>
              <div class="form-group">
                <label for="edit_area">area</label>
                <input type="text" class="form-control" id="edit_area" name="area" value="{{ $reservoir->area }}" placeholder="area">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="{{ route('modeli.reservoir.index') }}" class="btn btn-danger">Назад</a>
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
