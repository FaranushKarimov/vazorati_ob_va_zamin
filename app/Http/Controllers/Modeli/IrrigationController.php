<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Irrigation;

class IrrigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = array(
            "id" => "Код ирригации",
            "basin_id" => "Название бассейна",
            "name_ru" => "Название зоны обслуживания ирригацией рус.",
            "name_tj" => "Название зоны обслуживания ирригацией тадж.",
            "name_en" => "Название зоны обслуживания ирригацией анг.",
            "district" => "Название района",
            "region" => "Название области",
            "republic" => "Название республики",
            "source" => "Источник",
            "created_at" => "Дата создания",
            "updated_at" => "Дата изминения",
        );

        $irrigations = Irrigation::orderBy('id', 'desc')->paginate(20);
        return view("modeli.irrigation", [
            "irrigations" => $irrigations,
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
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'source'=>'nullable',
        ]);
        Irrigation::create($data);
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
        $irrigation = Irrigation::findOrFail($id);

        return view('modeli.irrigation_edit', compact('irrigation', 'id'));
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
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'source'=>'nullable',
        ]);

        $irrigation = Irrigation::findOrFail($id);
        $irrigation->fill($data)->save();

        return redirect()->route('modeli.irrigation.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $irrigation = Irrigation::findOrFail($id);
        $irrigation->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
