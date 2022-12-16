<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CatchmentArea;

class CatchmentAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
        $columns = array(
            "" => "",
        );
        */
        $columns = array(
            "id" => "Код",
            "basin_id" => "Название бассейна",
            "name_ru" => "Название водосборных площадей на русском",
            "name_tj" => "Название водосборных площадей на таджикском",
            "name_en" => "Название водосборных площадей на английском",
            "woc" => "Код водного объекта",
            "district" => "Район",
            "region" => "Название области",
            "republic" => "Республика",
            "area" => "Площадь",
            "created_at" => "Время создание записи",
            "updated_at" => "Время обновление записи",
        );

        $catchment_areas = CatchmentArea::orderBy('id', 'desc')->paginate(20);

        return view("modeli.catchment-area", [
            "catchment_areas" => $catchment_areas,
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
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'woc'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'area'=>'nullable',
        ]);
        CatchmentArea::create($data);
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
        $catchment_area = CatchmentArea::findOrFail($id);

        return view('modeli.catchment-area_edit', compact('catchment_area', 'id'));
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
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'woc'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'area'=>'nullable',
        ]);

        $catchment_area = CatchmentArea::findOrFail($id);
        $catchment_area->fill($data)->save();

        return redirect()->route('modeli.catchment-area.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $catchment_area = CatchmentArea::findOrFail($id);
        $catchment_area->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
