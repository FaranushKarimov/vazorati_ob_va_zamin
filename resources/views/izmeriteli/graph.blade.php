@extends('adminlte::page')

{{-- @section('title', '') --}}

@section('content_header')
    <h1>Карта Гидропостов</h1>
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
    <div class="alert alert-danger" style="display:none"></div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border" data-widget="collapse">
                  <h3 class="box-title">Карта Гидропостов</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="box-body">
                  <form id="filterForm" role="form" method="GET" action="{{ route('izmeriteli.graph.index') }}" accept-charset="UTF-8">
                    <div class="row" id="filterRow1">
                      <div class="col-xs-4">
                        <div class="form-group">
                          <label for="basin_id"><span>Бассейн</span></label>
                          <select name="basin_id" class="form-control"  id="filter_basin">
                              @unless(count($basins) == 1)
                                <option value="">Выберите Бассейн</option>
                              @endunless
                              @foreach($basins as $basin)
                                  <option value="{{$basin->id}}" {{ ( $basin->id == app('request')->input('basin_id') ) ? 'selected' : '' }}>{{$basin->name_ru}}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-sync-alt"></i> Обновить</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-body text-center">
            <hr>
            @if($iframe != 'none')
              <div id="ya_map"></div>
            @else
              <div>
                <h1 class="text-danger text-center">Нет данных</h1>
              </div>
            @endif
            <hr>
          </div>
          <div class="box-footer">
            <div class="text-right"></div>
          </div>
        </div>
      </div>
    </div>
@stop

@section('js')
	<script type="text/javascript">		
	</script>
  
  <script type="text/javascript" charset="utf-8" async src="{{$link}}"></script>
@stop
