<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hydropost;

use App\Wua;
use App\Canal;
use App\WaterBasinZone;

class HydropostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = array(
            "id" => "Код гидропоста",
            "counter_hydropost_id" => "Код гидропоста (ориг.)",
            "wua_id" => "Название АВП",
            "canal_id" => "Название Канала",
            "name_ru" => "Название гидропоста на русском",
            "name_tj" => "Название гидропоста на таджикском",
            "name_en" => "Название гидропоста на английском",
            "year_of_commissioning" => "Год ввода в эксплуатацию",
            "woc" => "Код водного объекта",
            "type" => "Тип объекта",
            "district" => "Район",
            "region" => "Область",
            "republic" => "Республика",
            "source" => "Название реки на которой расположен",
            "technical_condition" => "Техническое состояние",
            "created_at" => "Время создание записи",
            "updated_at" => "Время обновления записи",
        );

        $req_basin_id = $request->input('basin_id');
        $req_canal_id = $request->input('canal_id');
        $req_wua_id = $request->input('wua_id');

        $basins = WaterBasinZone::all();
        $canals = Canal::all();
        $wuas = Wua::all();

        $hydroposts = Hydropost::orderBy('id', 'desc');

        if(!empty($req_wua_id)) {
            $hydroposts = $hydroposts->where('wua_id','=',$req_wua_id);
        } if(!empty($req_canal_id)) {
            $hydroposts = $hydroposts->where('canal_id','=',$req_canal_id);
        } else if(!empty($req_basin_id)) {
            $canal_ids = Canal::where('basin_id','=',$req_basin_id)->pluck('id')->toArray();
            $hydroposts = $hydroposts->whereIn('canal_id', $canal_ids);
        } else {
            // $hydroposts = $hydroposts;
        }

        $hydroposts = $hydroposts->paginate(20);
        $hydroposts->appends($request->all());

        return view("modeli.hydropost", [
            "hydroposts" => $hydroposts,
            "wuas" => $wuas,
            "canals" => $canals,
            "basins" => $basins,
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
            'counter_hydropost_id'=>'nullable',
            'wua_id'=>'nullable',
            'canal_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'year_of_commissioning'=>'nullable',
            'woc'=>'nullable',
            'type'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'source'=>'nullable',
            'technical_condition'=>'nullable',
        ]);
        Hydropost::create($data);
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
        $hydropost = Hydropost::findOrFail($id);

        return view('modeli.hydropost_edit', compact('hydropost', 'id'));
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
            'counter_hydropost_id'=>'nullable',
            'wua_id'=>'nullable',
            'canal_id'=>'nullable',
            'name_ru'=>'nullable',
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'year_of_commissioning'=>'nullable',
            'woc'=>'nullable',
            'type'=>'nullable',
            'district'=>'nullable',
            'region'=>'nullable',
            'republic'=>'nullable',
            'source'=>'nullable',
            'technical_condition'=>'nullable',
        ]);

        $hydropost = Hydropost::findOrFail($id);
        $hydropost->fill($data)->save();

        return redirect()->route('modeli.hydropost.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hydropost = Hydropost::findOrFail($id);
        $hydropost->delete();

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

    /**
     * Return ajax wua names
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxWua(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'canal_id' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $wuas = Wua::orderBy('id')->where('canal_id','=',$request->get('canal_id'))->get(['id','canal_id','name_tj','name_ru','name_en']);
        return response()->json($wuas);
    }
}
