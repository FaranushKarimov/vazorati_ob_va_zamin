<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MainRiver;

class MainRiverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = array(
            "id" => "Код главной реки",
            "basin_id" => "Название бассейна",
            "catchment_id" => "Код водосборной площади",
            "name_ru" => "Название главной реки на русском",
            "name_tj" => "Название главной реки на таджикском",
            "name_en" => "Название главной реки на английском",
            "woc" => "Код водного объекта",
            "region" => "Области",
            "republic" => "Республика",
            "length" => "Протяженность в километрах",
            "annual_drain" => "Годовой сток",
            "watershed_area" => "Площадь водосбора (га)",
            "created_at" => "Время создание записи",
            "updated_at" => "Время обновления записи",
        );

        $main_rivers = MainRiver::orderBy('id', 'desc')->paginate(20);
        return view("modeli.main-river", [
            "main_rivers" => $main_rivers,
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
            'catchment_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'woc'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'length'=>'nullable',
            'annual_drain'=>'nullable',
            'watershed_area'=>'nullable',
        ]);
        MainRiver::create($data);
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
        $main_river = MainRiver::findOrFail($id);

        return view('modeli.main-river_edit', compact('main_river', 'id'));
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
            'catchment_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'woc'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'length'=>'nullable',
            'annual_drain'=>'nullable',
            'watershed_area'=>'nullable',
        ]);

        $main_river = MainRiver::findOrFail($id);
        $main_river->fill($data)->save();

        return redirect()->route('modeli.main-river.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $main_river = MainRiver::findOrFail($id);
        $main_river->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
