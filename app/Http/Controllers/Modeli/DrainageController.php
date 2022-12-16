<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Drainage;

use App\MainRiver as River;

class DrainageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = array(
            "id" => "Код дренажной системы",
            "river_id" => "Название реки",
            "name_ru" => "Название дренажной системы на русском",
            "name_tj" => "Название дренажной системы на таджикском",
            "name_en" => "Название дренажной системы на английском",
            "woc" => "Код водного объекта",
            "type" => "Тип объекта",
            "location_of_drain" => "Местонахождение точки водосброса",
            "year_of_commissioning" => "Год ввыода в эксплуатацию",
            "top_width" => "Ширина верха в метрах",
            "bottom_width" => "Ширина дна в метрах",
            "depth" => "Глубина в метрах",
            "length" => "Протяженность в километрах",
            "water_protection_strips" => "Водоохранные полосы",
            "technical_condition" => "Техническое состояние",
            "created_at" => "Время создание записи",
            "updated_at" => "Время обновления записи",
        );

        $rivers = River::all();

        $drainages = Drainage::orderBy('id', 'desc')->paginate(20);

        return view("modeli.drainage", [
            "drainages" => $drainages,
            "rivers" => $rivers,
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
            'river_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'woc'=>'nullable',
            'type'=>'nullable',
            'location_of_drain'=>'nullable',
            'year_of_commissioning'=>'nullable',
            'top_width'=>'nullable',
            'bottom_width'=>'nullable',
            'depth'=>'nullable',
            'length'=>'nullable',
            'water_protection_strips'=>'nullable',
            'technical_condition'=>'nullable',
        ]);
        Drainage::create($data);
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
        $drainage = Drainage::findOrFail($id);
        $rivers = River::all();

        $columns = array(
            "id" => "Код дренажной системы",
            "river_id" => "Название реки",
            "name_ru" => "Название дренажной системы на русском",
            "name_tj" => "Название дренажной системы на таджикском",
            "name_en" => "Название дренажной системы на английском",
            "woc" => "Код водного объекта",
            "type" => "Тип объекта",
            "location_of_drain" => "Местонахождение точки водосброса",
            "year_of_commissioning" => "Год ввыода в эксплуатацию",
            "top_width" => "Ширина верха в метрах",
            "bottom_width" => "Ширина дна в метрах",
            "depth" => "Глубина в метрах",
            "length" => "Протяженность в километрах",
            "water_protection_strips" => "Водоохранные полосы",
            "technical_condition" => "Техническое состояние",
            "created_at" => "Время создание записи",
            "updated_at" => "Время обновления записи",
        );

        return view('modeli.drainage_edit', [
            "drainage" => $drainage,
            "id" => $id,
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
            'river_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'woc'=>'nullable',
            'type'=>'nullable',
            'location_of_drain'=>'nullable',
            'year_of_commissioning'=>'nullable',
            'top_width'=>'nullable',
            'bottom_width'=>'nullable',
            'depth'=>'nullable',
            'length'=>'nullable',
            'water_protection_strips'=>'nullable',
            'technical_condition'=>'nullable',
        ]);

        $drainage = Drainage::findOrFail($id);
        $drainage->fill($data)->save();

        return redirect()->route('modeli.drainage.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drainage = Drainage::findOrFail($id);
        $drainage->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
