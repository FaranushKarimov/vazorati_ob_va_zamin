<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reservoir;

class ReservoirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = array(
            "id" => "Код водохранилища",
            "basin_id" => "Название бассейна",
            "name_ru" => "Название водохранилища на русском",
            "name_tj" => "Название водохранилища на таджикском",
            "name_en" => "Название водохранилища на английском",
            "woc" => "Код водного объекта",
            "district" => "Район",
            "region" => "Область",
            "republic" => "Республика",
            "administration" => "Управляющая организация",
            "type" => "Тип",
            "purpose" => "Назначение",
            "dam_type" => "Тип плотины",
            "watercourse" => "Водоток",
            "dam_height" => "Высота плотины",
            "total_vol_ml_cub_m" => "Полный объём млн. м в куб",
            "net_vol_ml_cub_m" => "Полезный объём млн. м в куб",
            "area" => "Площадь акватории",
            "created_at" => "Время создание записи",
            "updated_at" => "Время обновления записи",
        );

        $reservoirs = Reservoir::orderBy('id', 'desc')->paginate(20);
        return view("modeli.reservoir", [
            "reservoirs" => $reservoirs,
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
            'administration'=>'nullable',
            'type'=>'nullable',
            'purpose'=>'nullable',
            'dam_type'=>'nullable',
            'watercourse'=>'nullable',
            'dam_height'=>'nullable',
            'total_vol_ml_cub_m'=>'nullable',
            'net_vol_ml_cub_m'=>'nullable',
            'area'=>'nullable',
        ]);
        Reservoir::create($data);
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
        $reservoir = Reservoir::findOrFail($id);

        return view('modeli.reservoir_edit', compact('reservoir', 'id'));
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
            'administration'=>'nullable',
            'type'=>'nullable',
            'purpose'=>'nullable',
            'dam_type'=>'nullable',
            'watercourse'=>'nullable',
            'dam_height'=>'nullable',
            'total_vol_ml_cub_m'=>'nullable',
            'net_vol_ml_cub_m'=>'nullable',
            'area'=>'nullable',
        ]);

        $reservoir = Reservoir::findOrFail($id);
        $reservoir->fill($data)->save();

        return redirect()->route('modeli.reservoir.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservoir = Reservoir::findOrFail($id);
        $reservoir->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
