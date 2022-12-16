<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Oblast;

use App\WaterBasinZone;

class OblastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = array(
            "id" => "Код области",
            "basin_id" => "Название бассейна",
            "name_ru" => "Название области на русском",
            "name_tj" => "Название области на таджикском",
            "name_en" => "Название области на английском",
            "district" => "Название района",
            "republic" => "Название республики",
            "source" => "Название рек в области",
            "area" => "Площадь области",
            "created_at" => "Время создания записи",
            "updated_at" => "Время обновления записи",
        );

        $basins = WaterBasinZone::all();
        $oblasts = Oblast::orderBy('id', 'desc')->paginate(20);

        return view("modeli.oblast", [
            "basins" => $basins,
            "oblasts" => $oblasts,
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
            'drainage_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'district'=>'nullable',
            'republic'=>'nullable',
            'source'=>'nullable',
            'area'=>'nullable',
        ]);
        Oblast::create($data);
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
        $oblast = Oblast::findOrFail($id);

        return view('modeli.oblast_edit', compact('oblast', 'id'));
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
            'drainage_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'district'=>'nullable',
            'republic'=>'nullable',
            'source'=>'nullable',
            'area'=>'nullable',
        ]);

        $oblast = Oblast::findOrFail($id);
        $oblast->fill($data)->save();

        return redirect()->route('modeli.oblast.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oblast = Oblast::findOrFail($id);
        $oblast->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
