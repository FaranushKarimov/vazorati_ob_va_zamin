<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WaterBasinZone;

class WaterBasinZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = array(
            "id" => "Код водного бассейна",
            "name_ru" => "Название бассейна на русском",
            "name_tj" => "Название бассейна на таджикском",
            "name_en" => "Название бассейна на английском",
            "woc" => "Код водного объекта",
            "area" => "Площадь (га)",
            "created_at" => "Время создание записи",
            "updated_at" => "Время обновления записи",
        );

        $water_basin_zones = WaterBasinZone::orderBy('id', 'desc')->paginate(20);
        
        return view("modeli.water-basin-zone", [
            "water_basin_zones" => $water_basin_zones,
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
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'woc'=>'nullable',
            'area'=>'nullable',
        ]);
        WaterBasinZone::create($data);
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
        $water_basin_zone = WaterBasinZone::findOrFail($id);

        return view('modeli.water-basin-zone_edit', compact('water_basin_zone', 'id'));
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
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'woc'=>'nullable',
            'area'=>'nullable',
        ]);

        $water_basin_zone = WaterBasinZone::findOrFail($id);
        $water_basin_zone->fill($data)->save();

        return redirect()->route('modeli.water-basin-zone.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $water_basin_zone = WaterBasinZone::findOrFail($id);
        $water_basin_zone->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
