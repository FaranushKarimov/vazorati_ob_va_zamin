<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lake;

class LakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = array(
            "id" => "Код озера",
            "basin_id" => "Название бассейна",
            "name_ru" => "Название озера на русском",
            "name_tj" => "Название озера на таджикском",
            "name_en" => "Название озера на английском",
            "woc" => "Код водного объекта",
            "jamoat" => "Джамоат",
            "district" => "Район",
            "region" => "Область",
            "republic" => "Республика",
            "area" => "Площадь озера",
            "volume" => "Объём",
            "elevation" => "Высота над уровнем моря",
        );

        $lakes = Lake::orderBy('id', 'desc')->paginate(20);
        return view("modeli.lake", [
            "lakes" => $lakes,
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
            'jamoat'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'area'=>'nullable',
            'volume'=>'nullable',
            'elevation'=>'nullable',
        ]);
        Lake::create($data);
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
        $lake = Lake::findOrFail($id);

        return view('modeli.lake_edit', compact('lake', 'id'));
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
            'jamoat'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'area'=>'nullable',
            'volume'=>'nullable',
            'elevation'=>'nullable',
        ]);

        $lake = Lake::findOrFail($id);
        $lake->fill($data)->save();

        return redirect()->route('modeli.lake.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lake = Lake::findOrFail($id);
        $lake->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
