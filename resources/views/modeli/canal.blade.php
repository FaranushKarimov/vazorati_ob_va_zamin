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
          <h3 class="box-title">Каналы</h3>
          <br>
          <div class="box-tools">
            {{ $canals->links() }}
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
                <th>{{ $columns["basin_id"] }}</th>
                <th>{{ $columns["river_id"] }}</th>
                <th>{{ $columns["name_ru"] }}</th>
                <th>{{ $columns["name_tj"] }}</th>
                <th>{{ $columns["name_en"] }}</th>
                <th>{{ $columns["district"] }}</th>
                <th>{{ $columns["region"] }}</th>
                <th>{{ $columns["republic"] }}</th>
                <th>{{ $columns["source"] }}</th>
                <th>{{ $columns["year_of_commissioning"] }}</th>
                <th>{{ $columns["material"] }}</th>
                <th>{{ $columns["bandwidth"] }}</th>
                <th>{{ $columns["top_width"] }}</th>
                <th>{{ $columns["bottom_width"] }}</th>
                <th>{{ $columns["depth"] }}</th>
                <th>{{ $columns["length"] }}</th>
                <th>{{ $columns["serviced_land"] }}</th>
                <th>{{ $columns["water_protection_strips"] }}</th>
                <th>{{ $columns["number_of_water_outlets"] }}</th>
                <th>{{ $columns["technical_condition"] }}</th>
                <th>{{ $columns["notes"] }}</th>
                <th>{{ $columns["created_at"] }}</th>
                <th>{{ $columns["updated_at"] }}</th>
              </tr>
            </thead>
            @foreach ($canals as $canal)
            <tr class="item-data-row">
              <td>
                <div class="btn-group-vertical">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal" onclick="deleteItem({{ $canal->id }})"><i class="fas fa-trash"></i></button>
                  <a href="{{ route('modeli.canal.edit',$canal->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                </div>
              </td>
              <td class="h4">{{ $canal->id }}</td>
              <td>{{ $canal->basin ? $canal->basin->name_ru : $canal->basin_id }}</td>
              <td>{{ $canal->river ? $canal->river->name_ru : $canal->river_id }}</td>
              <td>{{ $canal->name_ru }}</td>
              <td>{{ $canal->name_tj }}</td>
              <td>{{ $canal->name_en }}</td>
              <td>{{ $canal->district }}</td>
              <td>{{ $canal->region }}</td>
              <td>{{ $canal->republic }}</td>
              <td>{{ $canal->source }}</td>
              <td>{{ $canal->year_of_commissioning }}</td>
              <td>{{ $canal->material }}</td>
              <td>{{ $canal->bandwidth }}</td>
              <td>{{ $canal->top_width }}</td>
              <td>{{ $canal->bottom_width }}</td>
              <td>{{ $canal->depth }}</td>
              <td>{{ $canal->length }}</td>
              <td>{{ $canal->serviced_land }}</td>
              <td>{{ $canal->water_protection_strips }}</td>
              <td>{{ $canal->number_of_water_outlets }}</td>
              <td>{{ $canal->technical_condition }}</td>
              <td>{{ $canal->notes }}</td>
              <td>{{ $canal->created_at }}</td>
              <td>{{ $canal->updated_at }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <div class="box-footer">
          <div class="text-right">
            {{ $canals->links() }}
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
        <form id="addItemForm" role="form" method="POST" action="{{ route('modeli.canal.store') }}" accept-charset="UTF-8">
          @csrf
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label for="add_basin_id"><span>{{ $columns["basin_id"] }}</span></label>
                <select name="basin_id" class="form-control"  id="add_basin_id">
                    <option value="">Выберите {{ $columns["basin_id"] }}</option>
                    @foreach($basins as $basin)
                        <option value="{{$basin->id}}">{{$basin->name_ru}}</option>
                    @endforeach
                </select>
              </div>
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
                <label for="add_name_ru">{{ $columns["name_ru"] }}</label>
                <input type="text" class="form-control" id="add_name_ru" name="name_ru" placeholder='{{ $columns["name_ru"] }}'>
              </div>
              <div class="form-group">
                <label for="add_name_tj">{{ $columns["name_tj"] }}</label>
                <input type="text" class="form-control" id="add_name_tj" name="name_tj" placeholder='{{ $columns["name_tj"] }}'>
              </div>
              <div class="form-group">
                <label for="add_name_en">{{ $columns["name_en"] }}</label>
                <input type="text" class="form-control" id="add_name_en" name="name_en" placeholder='{{ $columns["name_en"] }}'>
              </div>
              <div class="form-group">
                <label for="add_district">{{ $columns["district"] }}</label>
                <input type="text" class="form-control" id="add_district" name="district" placeholder='{{ $columns["district"] }}'>
              </div>
              <div class="form-group">
                <label for="add_region">{{ $columns["region"] }}</label>
                <input type="text" class="form-control" id="add_region" name="region" placeholder='{{ $columns["region"] }}'>
              </div>
              <div class="form-group">
                <label for="add_republic">{{ $columns["republic"] }}</label>
                <input type="text" class="form-control" id="add_republic" name="republic" placeholder='{{ $columns["republic"] }}'>
              </div>
              <div class="form-group">
                <label for="add_source">{{ $columns["source"] }}</label>
                <input type="text" class="form-control" id="add_source" name="source" placeholder='{{ $columns["source"] }}'>
              </div>
              <div class="form-group">
                <label for="add_year_of_commissioning">{{ $columns["year_of_commissioning"] }}</label>
                <input type="text" class="form-control" id="add_year_of_commissioning" name="year_of_commissioning" placeholder='{{ $columns["year_of_commissioning"] }}'>
              </div>
              <div class="form-group">
                <label for="add_material">{{ $columns["material"] }}</label>
                <input type="text" class="form-control" id="add_material" name="material" placeholder='{{ $columns["material"] }}'>
              </div>
              <div class="form-group">
                <label for="add_bandwidth">{{ $columns["bandwidth"] }}</label>
                <input type="text" class="form-control" id="add_bandwidth" name="bandwidth" placeholder='{{ $columns["bandwidth"] }}'>
              </div>
              <div class="form-group">
                <label for="add_top_width">{{ $columns["top_width"] }}</label>
                <input type="text" class="form-control" id="add_top_width" name="top_width" placeholder='{{ $columns["top_width"] }}'>
              </div>
              <div class="form-group">
                <label for="add_bottom_width">{{ $columns["bottom_width"] }}</label>
                <input type="text" class="form-control" id="add_bottom_width" name="bottom_width" placeholder='{{ $columns["bottom_width"] }}'>
              </div>
              <div class="form-group">
                <label for="add_depth">{{ $columns["depth"] }}</label>
                <input type="text" class="form-control" id="add_depth" name="depth" placeholder='{{ $columns["depth"] }}'>
              </div>
              <div class="form-group">
                <label for="add_length">{{ $columns["length"] }}</label>
                <input type="text" class="form-control" id="add_length" name="length" placeholder='{{ $columns["length"] }}'>
              </div>
              <div class="form-group">
                <label for="add_serviced_land">{{ $columns["serviced_land"] }}</label>
                <input type="text" class="form-control" id="add_serviced_land" name="serviced_land" placeholder='{{ $columns["serviced_land"] }}'>
              </div>
              <div class="form-group">
                <label for="add_water_protection_strips">{{ $columns["water_protection_strips"] }}</label>
                <input type="text" class="form-control" id="add_water_protection_strips" name="water_protection_strips" placeholder='{{ $columns["water_protection_strips"] }}'>
              </div>
              <div class="form-group">
                <label for="add_number_of_water_outlets">{{ $columns["number_of_water_outlets"] }}</label>
                <input type="text" class="form-control" id="add_number_of_water_outlets" name="number_of_water_outlets" placeholder='{{ $columns["number_of_water_outlets"] }}'>
              </div>
              <div class="form-group">
                <label for="add_technical_condition">{{ $columns["technical_condition"] }}</label>
                <input type="text" class="form-control" id="add_technical_condition" name="technical_condition" placeholder='{{ $columns["technical_condition"] }}'>
              </div>
              <div class="form-group">
                <label for="add_notes">{{ $columns["notes"] }}</label>
                <input type="text" class="form-control" id="add_notes" name="notes" placeholder='{{ $columns["notes"] }}'>
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
    function deleteItem(id) {
      var id = id;
      var url = '{{ route("modeli.canal.destroy", ":id") }}';
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