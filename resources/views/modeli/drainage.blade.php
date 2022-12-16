@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Справочник</h1>
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
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Коллекторно-дренажная система</h3>
          <br>
          <div class="box-tools">
            {{ $drainages->links() }}
          </div>
          <br>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewItemModal">
              <i class="fas fa-plus"></i> Добвить 
            </button>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Изменить</th>
                <th style="width: 30px">{{ $columns["id"] }}</th>
                <th>{{ $columns["river_id"] }}</th>
                <th>{{ $columns["name_ru"] }}</th>
                <th style="width: 40px">{{ $columns["name_tj"] }}</th>
                <th>{{ $columns["name_en"] }}</th>
                <th>{{ $columns["woc"] }}</th>
                <th>{{ $columns["type"] }}</th>
                <th>{{ $columns["location_of_drain"] }}</th>
                <th>{{ $columns["year_of_commissioning"] }}</th>
                <th>{{ $columns["top_width"] }}</th>
                <th>{{ $columns["bottom_width"] }}</th>
                <th>{{ $columns["depth"] }}</th>
                <th>{{ $columns["length"] }}</th>
                <th>{{ $columns["water_protection_strips"] }}</th>
                <th>{{ $columns["technical_condition"] }}</th>
                <th>{{ $columns["created_at"] }}</th>
                <th>{{ $columns["updated_at"] }}</th>
              </tr>
            </thead>
            @foreach ($drainages as $drainage)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $drainage->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.drainage.edit',$drainage->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $drainage->id }}</td>
              <td>{{ $drainage->river ? $drainage->river->name_ru : $drainage->river_id }}</td>
              <td>{{ $drainage->name_ru }}</td>
              <td>{{ $drainage->name_tj }}</td>
              <td>{{ $drainage->name_en }}</td>
              <td>{{ $drainage->woc }}</td>
              <td>{{ $drainage->type }}</td>
              <td>{{ $drainage->location_of_drain }}</td>
              <td>{{ $drainage->year_of_commissioning }}</td>
              <td>{{ $drainage->top_width }}</td>
              <td>{{ $drainage->bottom_width }}</td>
              <td>{{ $drainage->depth }}</td>
              <td>{{ $drainage->length }}</td>
              <td>{{ $drainage->water_protection_strips }}</td>
              <td>{{ $drainage->technical_condition }}</td>
              <td>{{ $drainage->created_at }}</td>
              <td>{{ $drainage->updated_at }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $drainages->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addNewItemModal" tabindex="-1" role="dialog" aria-labelledby="addNewItemModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="addNewItemModalLabel">Добвить</h4>
        </div>
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.drainage.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_river_id"><span>{{ $columns["river_id"] }}</span></label>
                <select name="river_id" class="form-control"  id="add_river_id">
                    <option value="">Выберите {{ $columns["river_id"] }}</option>
                    @foreach($rivers as $river)
                        <option value="{{$river->id}}">{{$river->name_ru}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="add_river_id">{{ $columns["name_ru"] }}</label>
                <input type="text" class="form-control" id="add_name_ru" name="name_ru" placeholder='{{ $columns["name_ru"] }}'>
              </div>
              <div class="form-group">
                <label for="add_name_ru">{{ $columns["name_tj"] }}</label>
                <input type="text" class="form-control" id="add_name_tj" name="name_tj" placeholder='{{ $columns["name_tj"] }}'>
              </div>
              <div class="form-group">
                <label for="add_name_tj">{{ $columns["name_en"] }}</label>
                <input type="text" class="form-control" id="add_name_en" name="name_en" placeholder='{{ $columns["name_en"] }}'>
              </div>
              <div class="form-group">
                <label for="add_name_en">{{ $columns["woc"] }}</label>
                <input type="text" class="form-control" id="add_woc" name="woc" placeholder='{{ $columns["woc"] }}'>
              </div>
              <div class="form-group">
                <label for="add_district">{{ $columns["type"] }}</label>
                <input type="text" class="form-control" id="add_type" name="type" placeholder='{{ $columns["type"] }}'>
              </div>
              <div class="form-group">
                <label for="add_region">{{ $columns["location_of_drain"] }}</label>
                <input type="text" class="form-control" id="add_location_of_drain" name="location_of_drain" placeholder='{{ $columns["location_of_drain"] }}'>
              </div>
              <div class="form-group">
                <label for="add_republic">{{ $columns["year_of_commissioning"] }}</label>
                <input type="text" class="form-control" id="add_year_of_commissioning" name="year_of_commissioning" placeholder='{{ $columns["year_of_commissioning"] }}'>
              </div>
              <div class="form-group">
                <label for="add_source">{{ $columns["top_width"] }}</label>
                <input type="text" class="form-control" id="add_top_width" name="top_width" placeholder='{{ $columns["top_width"] }}'>
              </div>
              <div class="form-group">
                <label for="add_year_of_commissioning">{{ $columns["bottom_width"] }}</label>
                <input type="text" class="form-control" id="add_bottom_width" name="bottom_width" placeholder='{{ $columns["bottom_width"] }}'>
              </div>
              <div class="form-group">
                <label for="add_material">{{ $columns["depth"] }}</label>
                <input type="text" class="form-control" id="add_depth" name="depth" placeholder='{{ $columns["depth"] }}'>
              </div>
              <div class="form-group">
                <label for="add_bandwidth">{{ $columns["length"] }}</label>
                <input type="text" class="form-control" id="add_length" name="length" placeholder='{{ $columns["length"] }}'>
              </div>
              <div class="form-group">
                <label for="add_top_width">{{ $columns["water_protection_strips"] }}</label>
                <input type="text" class="form-control" id="add_water_protection_strips" name="water_protection_strips" placeholder='{{ $columns["water_protection_strips"] }}'>
              </div>
              <div class="form-group">
                <label for="add_bottom_width">{{ $columns["technical_condition"] }}</label>
                <input type="text" class="form-control" id="add_technical_condition" name="technical_condition" placeholder='{{ $columns["technical_condition"] }}'>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
            <button type="submit" class="btnSubmit btn btn-primary" onclick="submitItemForm()">Добвить</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal modal-danger fade" id="deleteItemModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Подтверждение</h4>
        </div>
        <div class="modal-body">
          <p>Вы действительно хотите удалить?</p>
        </div>
        <div class="modal-footer">
          <form id="deleteItemForm" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="button" class="btn btn-info pull-left" data-dismiss="modal">Отмена</button>
            <button type="button" class="btn btn-danger" onclick="submitDeleteItemForm()">Удалить</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@stop



@section('js')
	<script type="text/javascript">		
    function deleteItem(id)
     {
         var id = id;
         var url = '{{ route("modeli.drainage.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteItemForm").attr('action', url);
     }
     function submitDeleteItemForm() {
      $("#deleteItemForm").submit();
    }

    function submitItemForm(e) {
      e.preventDefault();
      $("#addItemForm").submit();
      $('.btnSubmit').prop('disabled', true);
    }
	</script>

@stop
@section('css')
    <style type="text/css">
        .table > thead > tr > th {
            vertical-align: middle !important;
            text-align: center;
        }
        .table > tbody >tr > td {
            vertical-align: middle !important;
            text-align: center !important;
        }
    </style>
@stop
