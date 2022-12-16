<?php

use Illuminate\Http\Request;

use App\Hydropost;
use App\Wua;
use App\Canal;
use App\WaterLevel;


Route::middleware('api.custom_auth')->get('/hydropost/waterlevel', function (Request $request) {
    if(!$request->input('hyd_id')){
		return "invalid id";
	}

    $req_hyd_id = $request->input('hyd_id');
    $offset = $request->input('offset') ?? 0;
    $offset = is_numeric($offset) ? $offset : 0;

    $water_levels = WaterLevel::select(['id','height_h_6','height_h_12','height_h_18','height_h_24','flow_q','date','created_at','updated_at'])->where('hydropost_id','=', $req_hyd_id)->orderBy('date','desc')->offset($offset)->limit(20)->get();
   
	$columns = array(
        "id" => "Код координата",
        // "hydropost_id" => "Название гидропоста",
        "height_h_6" => "Уровень воды (м) 6:00",
        "height_h_12" => "Уровень воды (м) 12:00",
        "height_h_18" => "Уровень воды (м) 18:00",
        "height_h_24" => "Уровень воды (м) 24:00",
        "flow_q" => "Средный расход воды (л/с)",
        // "dynamic" => "Динамич.",
        "date" => "Дата",
        "created_at" => "Время создания записи",
        "updated_at" => "Время обновления записи",
    );

    return response()->json(array($water_levels,$columns));
});

Route::middleware('api.custom_auth')->get('/hydropost', function (Request $request) {
	if(!$request->input('woc_id')){
		return "invalid id";
	}

    $req_woc_id = $request->input('woc_id');
    $hydropost = Hydropost::where('woc','=',$req_woc_id)->first();

    if($hydropost) {
    	$wua = Wua::find($hydropost->wua_id);
    	$canal = Canal::find($hydropost->canal_id);

    	$hydropost->wua_id = $wua ? $wua->name_ru : $hydropost->wua_id;
    	$hydropost->canal_id = $canal ? $canal->name_ru : $hydropost->canal_id;
    }

    $columns = array(
        "id" => "Код гидропоста",
        "counter_hydropost_id" => "Код гидропоста (ориг.)",
        "wua_id" => "Название АВП",
        "canal_id" => "Название Канала",
        "name_ru" => "Название гидропоста на русском",
        "name_tj" => "Название гидропоста на таджикском",
        "name_en" => "Название гидропоста на английском",
        "year_of_commissioning" => "Год ввода в эксплуатацию",
        "woc" => "Код водного объекта",
        "type" => "Тип объекта",
        "district" => "Район",
        "region" => "Область",
        "republic" => "Республика",
        "source" => "Название реки на которой расположен",
        "technical_condition" => "Техническое состояние",
        "created_at" => "Время создание записи",
        "updated_at" => "Время обновления записи",
    );

    return response()->json(array($hydropost,$columns));
});
