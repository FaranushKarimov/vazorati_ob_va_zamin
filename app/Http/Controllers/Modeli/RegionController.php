<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Region;

use App\WaterBasinZone;
use App\Oblast;

class RegionController extends Controller
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
            "oblast_id" => "Название области",
            "name_ru" => "Название района на русском",
            "name_tj" => "Название района на таджикском",
            "name_en" => "Название района на английском",
            "area" => "Площадь",
            "republic" => "Республика",
            "district" => "Район",
            "created_at" => "Время создание записи",
            "updated_at" => "Время обновление записи",
        );

        $basins = WaterBasinZone::all();
        $oblasts = Oblast::all();
        $regions = Region::orderBy('id', 'desc')->paginate(20);

        return view("modeli.region", [
            "basins" => $basins,
            "oblasts" => $oblasts,
            "regions" => $regions,
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
            'oblast_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'area'=>'nullable',
            'republic'=>'nullable',
            'district'=>'nullable',
        ]);
        Region::create($data);
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
        $region = Region::findOrFail($id);

        return view('modeli.region_edit', compact('region', 'id'));
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
            'oblast_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'area'=>'nullable',
            'republic'=>'nullable',
            'district'=>'nullable',
        ]);

        $region = Region::findOrFail($id);
        $region->fill($data)->save();

        return redirect()->route('modeli.region.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
