<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Qms;

use App\Qcordinate;
use App\WaterLevel;
use App\Canal;
use App\Hydropost;
use App\WaterBasinZone;

use Auth;

class QmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = array(
            "id" => "Код",
            "irrigation_id" => "Название ирригационного объекта",
            "hydropost_id" => "Название гидропоста",
            "qms_avg" => "Средный расход (л/с)",
            "volume_w" => "Объём воды (м3)",
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

        if($request->get('update_qms')=='yes') {
            // calculate qms from water_levels
            // calc qms and daily volume and store to qms
            // from qms calc decada volume and save in decadas
            
            // $hydroposts = Hydropost::get(['id','counter_hydropost_id'])->toArray();
            // $hydropost_ids = array_map(function($el){
            //     return $el['id'];
            // },$hydroposts);

            // $counter_hydropost_ids = array_map(function($el){
            //     return $el['counter_hydropost_id'];
            // },$hydroposts);

            // dd($counter_hydropost_ids);

            // $last_volume = Qms::orderBy('date', 'desc')->where('dynamic',true)->whereIn('hydropost_id',$hydropost_ids)->limit(5)->get()->toArray();
            $last_volume = Qms::orderBy('date', 'desc')->first();

            // dd($last_volume->date);
            // $counters = GsmCounter::on('mysql2')->orderBy('date', 'desc')->where('date','<=',substr($last_volume->date,0,7) . '%')->limit(5);

            // $dateBetween = array((new \DateTime($last_volume->date))->modify('+1 day')->format('Y-m-d'),\Carbon\Carbon::now()->subDays(1)->format('Y-m-d'));
            if($last_volume){
                $d_start = (new \Carbon\Carbon($last_volume->date))->addDays(1);
            } else {
                $d_start = (new \Carbon\Carbon('2015-01-01'))->addDays(1);
            }
            
            $d_end = \Carbon\Carbon::now()->subDays(1);

            $dateBetween = array($d_start->format('Y-m-d'),$d_end->format('Y-m-d'));
            
            $w_levels = WaterLevel::orderBy('date', 'desc')->whereBetween('date', $dateBetween)->get();
            // $w_levels = GsmCounter::on('mysql2')->orderBy('date', 'desc')->whereBetween('date', $dateBetween)->get();
            
            // dd($w_levels->toArray());
            // dd($dateBetween);

            $newVolumes = array();

            foreach ($w_levels as $w_level) {
                array_push($newVolumes, 
                    array(
                        // 'id' => ,
                        'irrigation_id' => 0,
                        'hydropost_id' => $w_level->hydropost_id,
                        'qms_avg' => $w_level->flow_q,
                        'volume_w' => Qcordinate::wValue($w_level->flow_q),
                        'date' => $w_level->date,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    )
                );
            }

            // dd($newVolumes);

            Qms::insert($newVolumes);

            return redirect()->route('modeli.qms.index');
        }

        $user = Auth::user();

        $basin_canal_ids = Canal::where('basin_id','=',$user->basin_id)->pluck('id')->toArray();
        $basin_hyd_ids = Hydropost::whereIn('canal_id',$basin_canal_ids)->pluck('id')->toArray();
        $hyd_ids = array();

        $req_basin_id = $request->input('basin_id');
        $req_canal_id = $request->input('canal_id');
        $req_hyd_id = $request->input('hydropost_id');
        $req_year = $request->input('year');
        $req_month = $request->input('month');

        if(!empty($req_hyd_id)) {
            $hyd_ids = array($req_hyd_id);
        } else if(!empty($req_canal_id)) {
            $hyd_ids = Hydropost::where('canal_id','=',$req_canal_id)->pluck('id')->toArray();
        } else if(!empty($req_basin_id)) {
            $canal_ids = Canal::where('basin_id','=',$req_basin_id)->pluck('id')->toArray();
            $hyd_ids = Hydropost::whereIn('canal_id', $canal_ids)->pluck('id')->toArray();
        } 
        
        $qmss = Qms::orderBy('date', 'desc');
        $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);
        $hydroposts = Hydropost::orderBy('id','asc');

        if($user->role && $user->role->title =='super-admin') {
            if(!empty($req_basin_id)) {
                $qmss = $qmss->whereIn('hydropost_id', $hyd_ids);
            }
        } else {
            $qmss = $qmss->whereIn('hydropost_id', array_intersect($basin_hyd_ids,$hyd_ids));
            $hydroposts = $hydroposts->whereIn('id', $basin_hyd_ids);
            $basins = $basins->where('id','=',$user->basin_id);
        }

        if(!empty($req_year)) {
            $qmss = $qmss->whereYear('date','=',$req_year);
        }

        if(!empty($req_month)) {
            $qmss = $qmss->whereMonth('date','=',$req_month);
        }

        $hydroposts = $hydroposts->get();
        $qmss = $qmss->paginate(20);

        $qmss->appends($request->all());

        return view("modeli.qms", [
            'qmss' => $qmss,
            'basins' => $basins,
            'hydroposts' => $hydroposts,
            'months' => $months,
            'years' => $years,
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
            'irrigation_id'=>'nullable',
            'hydropost_id'=>'nullable',
            'qms_avg'=>'nullable',
            'volume_w'=>'nullable',
            'date'=>'required',
        ]);

        $volume_w = Qcordinate::wValue($data['qms_avg']);
        
        if(!$volume_w){
            $data['volume_w'] = NULL;
        } else {
            $data['volume_w'] = $volume_w;
        }

        Qms::create($data);
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
        $qms = Qms::findOrFail($id);

        return view('modeli.qms_edit', compact('qms', 'id'));
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
            'irrigation_id'=>'nullable',
            'hydropost_id'=>'nullable',
            'qms_avg'=>'nullable',
            'volume_w'=>'nullable',
            'date'=>'nullable',
        ]);

        $qms = Qms::findOrFail($id);
        $qms->fill($data)->save();

        return redirect()->route('modeli.qms.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qms = Qms::findOrFail($id);
        $qms->delete();

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
