<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Wua;

use App\WaterBasinZone;
use App\Irrigation;
use App\Region;
use App\Canal;

class WuaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = array(
            "id" => "Код АВП",
            "billing_id" => "Код АВП (ориг.)",
            "irrigation_id" => "Название ирригационной системы",
            "basin_id" => "Название бассейна",
            "region_id" => "Название области",
            "canal_id" => "Название канала",
            "name_ru" => "Название АВП на русском",
            "name_tj" => "Название АВП на таджикском",
            "name_en" => "Название АВП на английском",
            "service_area" => "Место обслуживание",
            "irrigation_lands" => "Орошаемые земли",
            "district" => "Район",
            "republic" => "Республика",
            "created_at" => "Время создания записи",
            "updated_at" => "Время обновление записи",
        );

        $basins = WaterBasinZone::all();
        $irrigations = Irrigation::all();
        $regions = Region::all();
        $canals = Canal::all();


        if(!empty($request->get('canal_id'))) {
            $wuas = Wua::orderBy('id', 'desc')->where('canal_id','=',$request->get('canal_id'))->paginate(20);
        } else if(!empty($request->get('basin_id'))) {
            $wuas = Wua::orderBy('id', 'desc')->where('basin_id','=',$request->get('basin_id'))->paginate(20);
        } else {
            $wuas = Wua::orderBy('basin_id', 'asc')->paginate(20);
        }

        $wuas->appends($request->all());

        return view("modeli.wua", [
            "wuas" => $wuas,
            "basins" => $basins,
            "irrigations" => $irrigations,
            "regions" => $regions,
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
            'billing_id'=>'nullable',
            'basin_id'=>'nullable',
            'irrigation_id'=>'nullable',
            'region_id'=>'nullable',
            'canal_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'service_area'=>'nullable',
            'irrigation_lands'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
        ]);
        Wua::create($data);
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
        $wua = Wua::findOrFail($id);

        $basins = WaterBasinZone::all();
        $irrigations = Irrigation::all();
        $regions = Region::all();
        $canals = Canal::all();

        $columns = array(
            "id" => "Код АВП",
            "billing_id" => "Код АВП (ориг.)",
            "irrigation_id" => "Название ирригационной системы",
            "basin_id" => "Название бассейна",
            "region_id" => "Название области",
            "canal_id" => "Название канала",
            "name_ru" => "Название АВП на русском",
            "name_tj" => "Название АВП на таджикском",
            "name_en" => "Название АВП на английском",
            "service_area" => "Место обслуживание",
            "irrigation_lands" => "Орошаемые земли",
            "district" => "Район",
            "republic" => "Республика",
            "created_at" => "Время создания записи",
            "updated_at" => "Время обновление записи",
        );

        return view('modeli.wua_edit', [
            "wua" => $wua,
            "id" => $id,
            "basins" => $basins,
            "irrigations" => $irrigations,
            "regions" => $regions,
            "canals" => $canals,
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
            'billing_id'=>'nullable',
            'basin_id'=>'nullable',
            'irrigation_id'=>'nullable',
            'region_id'=>'nullable',
            'canal_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'service_area'=>'nullable',
            'irrigation_lands'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
        ]);

        $wua = Wua::findOrFail($id);
        $wua->fill($data)->save();

        return redirect()->route('modeli.wua.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wua = Wua::findOrFail($id);
        $wua->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }

    /**
     * Return ajax canal names
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxCanal(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'basin_id' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $canals = Canal::orderBy('id')->where('basin_id','=',$request->get('basin_id'))->get(['id','basin_id','name_tj','name_ru','name_en']);
   
        return response()->json($canals);
    }
}
