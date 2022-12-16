<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\WaterLevel;
use App\Qcordinate;
use App\WaterBasinZone;
use App\Canal;
use App\Hydropost;

use App\GsmCounter;

use Auth;


class WaterLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = array(
            "id" => "Код координата",
            "hydropost_id" => "Название гидропоста",
            "height_h_6" => "Уровень воды (м) 6:00",
            "height_h_12" => "Уровень воды (м) 12:00",
            "height_h_18" => "Уровень воды (м) 18:00",
            "height_h_24" => "Уровень воды (м) 24:00",
            "flow_q" => "Средный расход воды (л/с)",
            "date" => "Дата",
            "created_at" => "Время создания записи",
            "updated_at" => "Время обновления записи",
        );

        $years = array(
            '2015',
            '2016',
            '2017',
            '2018',
            '2019',
            '2020',
            '2021',
            '2022',
            '2023',
            '2024',
            '2025',
            '2026',
            '2027',
            '2028',
            '2029',
            '2030',
        );

        $months = array(
            '01' => 'Январь',
            '02' => 'Февраль',
            '03' => 'Март',
            '04' => 'Апрель',
            '05' => 'Май',
            '06' => 'Июнь',
            '07' => 'Июль',
            '08' => 'Август',
            '09' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь',
        );

        if($request->get('update_levels')=='yes'){
            // $hydroposts = Hydropost::pluck('id');
            // $hydroposts = Hydropost::get(['id','counter_hydropost_id'])->toArray();
            // $hydropost_ids = array_map(function($el){
            //     return $el['id'];
            // },$hydroposts);

            // $counter_hydropost_ids = array_map(function($el){
            //     return $el['counter_hydropost_id'];
            // },$hydroposts);

            // dd($counter_hydropost_ids);

            // $last_water_level = WaterLevel::orderBy('date', 'desc')->where('dynamic',true)->whereIn('hydropost_id',$hydropost_ids)->limit(5)->get()->toArray();
            $last_water_level = WaterLevel::orderBy('date', 'desc')->where('dynamic',true)->first();

            // dd($last_water_level->date);
            // $counters = GsmCounter::on('mysql2')->orderBy('date', 'desc')->where('date','<=',substr($last_water_level->date,0,7) . '%')->limit(5);

            // $dateBetween = array((new \DateTime($last_water_level->date))->modify('+1 day')->format('Y-m-d'),\Carbon\Carbon::now()->subDays(1)->format('Y-m-d'));
            $d_start = (new \Carbon\Carbon($last_water_level->date))->addDays(1);
            $d_end = \Carbon\Carbon::now()->subDays(1);

            $dateBetween = array($d_start->format('Y-m-d'),$d_end->format('Y-m-d'));

            $hydropost_all_ids = Hydropost::pluck('id')->toArray();
            foreach ($hydropost_all_ids as $hydropost_all_id) {
                                         
                $counters = GsmCounter::on('mysql2')->selectRaw('hydropost_id, date, MAX(level_h_6) as level_h_6, MAX(level_h_12) as level_h_12, MAX(level_h_18) as level_h_18, MAX(level_h_24) as level_h_24')->orderBy('date', 'desc')->where('hydropost_id','=',$hydropost_all_id)->whereBetween('date', $dateBetween)->groupBy('date')->get();
                
                if($counters->isNotEmpty()){

                    // dd($counters);

                    $newWaterLevels = array();

                    foreach ($counters as $counter) {
                        $new_hydropost = Hydropost::select('id')->where('counter_hydropost_id','=',$counter->hydropost_id)->first();
                        if($new_hydropost){
                            $new_hydropost_id = $new_hydropost->id;
                        } else {
                            $new_hydropost_id = NULL;
                        }

                        $avg_q = Qcordinate::avgQ($counter->level_h_6,$counter->level_h_12,$counter->level_h_18,$counter->level_h_24,$new_hydropost_id);

                        array_push($newWaterLevels, 
                            array(
                                // 'id' => ,
                                'hydropost_id' => $new_hydropost_id,
                                'height_h_6' => $counter->level_h_6,
                                'height_h_12' => $counter->level_h_12,
                                'height_h_18' => $counter->level_h_18,
                                'height_h_24' => $counter->level_h_24,
                                'flow_q' => $avg_q,
                                'dynamic' => true,
                                'date' => $counter->date,
                                'created_at' => \Carbon\Carbon::now(),
                                'updated_at' => \Carbon\Carbon::now(),
                            )
                        );
                    }
                    WaterLevel::insert($newWaterLevels);
                }
            }
            // dd($all);
            // store new water_levels with q from cordinate table
            return redirect()->route('modeli.water-level.index');
        }

        $user = Auth::user();

        $basin_canal_ids = Canal::where('basin_id','=',$user->basin_id)->pluck('id')->toArray();
        $basin_hyd_ids = Hydropost::whereIn('canal_id',$basin_canal_ids)->pluck('id')->toArray();
        $hyd_ids = array();

        $req_basin_id = $request->input('basin_id');
        $req_canal_id = $request->input('canal_id');
        $req_hyd_id = $request->input('hydropost_id');
        $req_type = $request->get('type');
        $req_year = $request->input('year');
        $req_month = $request->input('month');
        
        if(!empty($req_hyd_id)) {
            $hyd_ids = array($req_hyd_id);
        } else if($req_canal_id){
            $hyd_ids = Hydropost::where('canal_id','=',$req_canal_id)->pluck('id')->toArray();
        } else if($req_basin_id){
            $canal_ids = Canal::where('basin_id','=',$req_basin_id)->pluck('id')->toArray();
            $hyd_ids = Hydropost::whereIn('canal_id', $canal_ids)->pluck('id')->toArray();
        } 
        
        $water_levels = WaterLevel::orderBy('date', 'desc');
        $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);
        $hydroposts = Hydropost::orderBy('id','asc');

        if($user->role && $user->role->title =='super-admin'){
            if($req_basin_id){
                $water_levels = $water_levels->whereIn('hydropost_id', $hyd_ids);
            }
        } else {
            $water_levels = $water_levels->whereIn('hydropost_id', array_intersect($basin_hyd_ids,$hyd_ids));
            $hydroposts = $hydroposts->whereIn('id', $basin_hyd_ids);
            $basins = $basins->where('id','=',$user->basin_id);
        }

        if(!empty($req_year)) {
            $water_levels = $water_levels->whereYear('date','=',$req_year);
        }

        if(!empty($req_month)) {
            $water_levels = $water_levels->whereMonth('date','=',$req_month);
        }

        if(!empty($req_type)) {
            $water_levels = $water_levels->where('dynamic','=',$req_type);
        }

        $hydroposts = $hydroposts->get();
        $water_levels = $water_levels->paginate(20);

        $water_levels->appends($request->all());

        // $water_levels = WaterLevel::orderBy('date', 'desc')->paginate(20);

        return view("modeli.water-level", [
            'water_levels' => $water_levels,
            'basins' => $basins,
            'hydroposts' => $hydroposts,
            'type' => $req_type,
            'years' => $years,
            'months' => $months,
            'columns' => $columns,
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
            'hydropost_id'=>'required',
            'height_h_6'=>'required',
            'height_h_12'=>'required',
            'height_h_18'=>'required',
            'height_h_24'=>'required',
            'flow_q'=>'nullable',
            'date'=>'required',
        ]);

        $flow = Qcordinate::avgQ($data['height_h_6'],$data['height_h_12'],$data['height_h_18'],$data['height_h_24'],$data['hydropost_id']);
        
        if(!$flow){
            $data['flow_q'] = NULL;
        } else {
            $data['flow_q'] = $flow;
        }

        WaterLevel::create($data);
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
        $water_level = WaterLevel::findOrFail($id);

        return view('modeli.water-level_edit', compact('water_level', 'id'));
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
            'hydropost_id'=>'required',
            'height_h_6'=>'required',
            'height_h_12'=>'required',
            'height_h_18'=>'required',
            'height_h_24'=>'required',
            'flow_q'=>'nullable',
            'date'=>'required',
        ]);

        $water_level = WaterLevel::findOrFail($id);
        $water_level->fill($data)->save();

        return redirect()->route('modeli.water-level.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $water_level = WaterLevel::findOrFail($id);
        $water_level->delete();

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
     * Return ajax hydropost names
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxHydropost(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'canal_id' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $hyds = Hydropost::orderBy('id')->where('canal_id','=',$request->get('canal_id'))->get(['id','canal_id','name_tj','name_ru','name_en']);
        return response()->json($hyds);
    }
}
