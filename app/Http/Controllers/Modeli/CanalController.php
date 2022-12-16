<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Canal;

use App\WaterBasinZone;
use App\MainRiver as River;

class CanalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $columns = array(
            "id" => "Код",
            "basin_id" => "Название бассейна",
            "river_id" => "Название реки",
            "name_ru" => "Название канал на рус.",
            "name_tj" => "Название канал на тадж.",
            "name_en" => "Название канал на англ.",
            "district" => "Название района",
            "region" => "Название области",
            "republic" => "Название республики",
            "source" => "Источник",
            "year_of_commissioning" => "Год ввода в эксплуатацию",
            "material" => "Материал",
            "bandwidth" => "Пропускная способность",
            "top_width" => "Ширина верха_м",
            "bottom_width" => "Ширина дна_м",
            "depth" => "Глубина (м)",
            "length" => "Протяженность (км)",
            "serviced_land" => "Обслуживаемые земли",
            "water_protection_strips" => "Водоохранные полосы (м)",
            "number_of_water_outlets" => "Количество водовыпусков",
            "technical_condition" => "Техническое состояние",
            "notes" => "Примечание",
            "created_at" => "Дата создания",
            "updated_at" => "Дата изминения",
        );

        $basins = WaterBasinZone::all();
        $rivers = River::all();

        $canals = Canal::orderBy('id', 'desc')->paginate(20);

        return view("modeli.canal", [
            "basins" => $basins,
            "rivers" => $rivers,
            "canals" => $canals,
            "columns" => $columns,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'basin_id'=>'nullable',
            'wua_id'=>'nullable',
            'river_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'source'=>'nullable',
            'year_of_commissioning'=>'nullable',
            'material'=>'nullable',
            'bandwidth'=>'nullable',
            'top_width'=>'nullable',
            'bottom_width'=>'nullable',
            'depth'=>'nullable',
            'length'=>'nullable',
            'serviced_land'=>'nullable',
            'water_protection_strips'=>'nullable',
            'number_of_water_outlets'=>'nullable',
            'technical_condition'=>'nullable',
            'notes'=>'nullable',
        ]);
        Canal::create($data);
        return redirect()->back()->with('message', 'Добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $canal = Canal::findOrFail($id);
        $basins = WaterBasinZone::all();
        $rivers = River::all();

        $columns = array(
            "id" => "Код",
            "basin_id" => "Название бассейна",
            "river_id" => "Название реки",
            "wua_id" => "Название АВП",
            "name_ru" => "Название канал на рус.",
            "name_tj" => "Название канал на тадж.",
            "name_en" => "Название канал на англ.",
            "district" => "Название района",
            "region" => "Название области",
            "republic" => "Название республики",
            "source" => "Источник",
            "year_of_commissioning" => "Год ввода в эксплуатацию",
            "material" => "Материал",
            "bandwidth" => "Пропускная способность",
            "top_width" => "Ширина верха_м",
            "bottom_width" => "Ширина дна_м",
            "depth" => "Глубина (м)",
            "length" => "Протяженность (км)",
            "serviced_land" => "Обслуживаемые земли",
            "water_protection_strips" => "Водоохранные полосы (м)",
            "number_of_water_outlets" => "Количество водовыпусков",
            "technical_condition" => "Техническое состояние",
            "notes" => "Примечание",
            "created_at" => "Дата создания",
            "updated_at" => "Дата изминения",
        );

        return view('modeli.canal_edit', [
            "canal" => $canal,
            "id" => $id,
            "basins" => $basins,
            "rivers" => $rivers,
            "columns" => $columns,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'basin_id'=>'nullable',
            'wua_id'=>'nullable',
            'river_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'source'=>'nullable',
            'year_of_commissioning'=>'nullable',
            'material'=>'nullable',
            'bandwidth'=>'nullable',
            'top_width'=>'nullable',
            'bottom_width'=>'nullable',
            'depth'=>'nullable',
            'length'=>'nullable',
            'serviced_land'=>'nullable',
            'water_protection_strips'=>'nullable',
            'number_of_water_outlets'=>'nullable',
            'technical_condition'=>'nullable',
            'notes'=>'nullable',
        ]);

        $canal = Canal::findOrFail($id);
        $canal->fill($data)->save();

        return redirect()->route('modeli.canal.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $canal = Canal::findOrFail($id);
        $canal->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
