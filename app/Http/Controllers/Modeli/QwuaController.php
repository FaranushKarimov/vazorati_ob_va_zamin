<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Qwua;

use App\Qcordinate;
use App\Qms;
use App\Wua;
use App\Region;
use App\Canal;
use App\WaterBasinZone;

use Auth;

class QwuaController extends Controller
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
            "wua_id" => "Название АВП",
            "region_id" => "Название области",
            "qwua_avg" => "Средный расход (л/с)",
            "volume_w" => "Объём воды (л)",
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

        if($request->get('update_qwua')=='yes') {

            // dd($wuas);

            $last_volume = Qwua::orderBy('date', 'desc')->first();

            // dd($last_volume->date);
            // $counters = GsmCounter::on('mysql2')->orderBy('date', 'desc')->where('date','<=',substr($last_volume->date,0,7) . '%')->limit(5);
            if($last_volume){
                $d_start = (new \Carbon\Carbon($last_volume->date))->addDays(1);
            } else {
                $d_start = (new \Carbon\Carbon('2015-01-01'))->addDays(1);
            }

            $d_end = \Carbon\Carbon::now()->subDays(1);

            $dateBetween = array($d_start->format('Y-m-d'),$d_end->format('Y-m-d'));

            $wuas = Wua::all();

            // foreach ($wuas as $wua) {
            //     if($wua->hydropostEnds()->count() > 1){
            //         dd($wua->hydropostEnds()->pluck('id'));
            //     }
            // }

            // dd($dateBetween);
            // dd($d_start->diffInDays($d_end));
            
            // $dates = Qms::select('date')->orderBy('date')->whereBetween('date',['1900-01-01','2020-01-01'])->groupBy('date')->pluck('date')->toArray();
            $dates = Qms::select('date')->orderBy('date')->whereBetween('date',$dateBetween)->groupBy('date')->pluck('date')->toArray();
            // $qs = Qms::orderBy('date')->whereBetween('date',['2015-01-01','2020-01-01'])->get()->toArray();
            // dd($dates);
            // dd($qs);
            $newVolumes = array();
            // array of dates

            foreach ($dates as $dt) {
                $dt_c = new \Carbon\Carbon($dt);
                foreach ($wuas as $wua) {
                    $h_ids = $wua->hydropostEnds()->pluck('id');
                    // $qms_h = Qms::where('date','=',$dt)->whereIn('hydropost_id',$h_ids)->get();
                    $qms_h = Qms::where('date','=',$dt_c->format('Y-m-d'))->whereIn('hydropost_id',$h_ids)->limit(2)->get();
                    if($qms_h->count() == 2){
                        $qms_h_arr = $qms_h->toArray();
                        // dd(abs($qms_h_arr[0]['qms_avg'] - $qms_h_arr[1]['qms_avg']));
                        // dd(abs($qms_h_arr[0]['qms_avg']));
                        $q_diff = abs($qms_h_arr[0]['qms_avg'] - $qms_h_arr[1]['qms_avg']);
                        $w_diff = abs($qms_h_arr[0]['volume_w'] - $qms_h_arr[1]['volume_w']);
                        array_push($newVolumes, 
                            array(
                                // 'id' => ,
                                'wua_id' => $wua->id,
                                'region_id' => NULL,
                                'qwua_avg' => $q_diff,
                                'volume_w' => $w_diff,
                                'date' => $dt_c->format('Y-m-d'),
                                'created_at' => \Carbon\Carbon::now(),
                                'updated_at' => \Carbon\Carbon::now(),
                            )
                        );
                    }
                }
            }
            // dd($newVolumes);
            Qwua::insert($newVolumes);
            
            return redirect()->route('modeli.qwua.index');
        }

        /*if(!empty($request->get('wua_id'))) {
            $qwuas = Qwua::orderBy('id', 'desc')->where('wua_id','=',$request->get('wua_id'))->paginate(20);
        } else {
            $qwuas = Qwua::orderBy('date', 'desc')->paginate(20);
        }*/

        $user = Auth::user();

        $req_basin_id = $request->input('basin_id');
        $req_canal_id = $request->input('canal_id');
        $req_wua_id = $request->input('wua_id');
        $req_year = $request->input('year');
        $req_month = $request->input('month');

        $basin_wua_ids = Wua::where('basin_id','=',$user->basin_id)->pluck('billing_id')->toArray();
        $wua_ids = array();

        $qwuas = Qwua::orderBy('wua_id', 'asc');

        if(!empty($req_wua_id)) {
            $wua_ids = array($req_wua_id); // each wua
        } else if(!empty($req_canal_id)) {
            $wua_ids = Wua::where('canal_id','=',$req_canal_id)->pluck('id')->toArray(); // each canal
            // $wua_ids = Wua::where('canal_id','=',$req_canal_id)->pluck('billing_id')->toArray(); // each canal
        } else if(!empty($req_basin_id)) {
            $wua_ids = Wua::where('basin_id','=',$req_basin_id)->pluck('id')->toArray(); // each basin
        }

        $wuas = Wua::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);
        $regions_add = Region::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);
        $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);

        if($user->role && $user->role->title =='super-admin') {
            // if(!empty($req_basin_id)) {
            // } 
            $qwuas = $qwuas->whereIn('wua_id', $wua_ids);
        } else {
            $qwuas = $qwuas->whereIn('wua_id', array_intersect($basin_wua_ids,$wua_ids));
            
            $wuas = $wuas->where('basin_id','=',$user->basin_id);
            $regions_add = $regions_add->where('basin_id','=',$user->basin_id);
            $basins = $basins->where('id','=',$user->basin_id);
        }

        if(!empty($req_year)) {
            $qwuas = $qwuas->whereYear('date','=',$req_year);
        }

        if(!empty($req_month)) {
            $qwuas = $qwuas->whereMonth('date','=',$req_month);
        }

        $qwuas = $qwuas->paginate(20);
        $qwuas->appends($request->all());

        return view("modeli.qwua", [
            'qwuas' => $qwuas,
            'wuas' => $wuas,
            'regions_add' => $regions_add,
            'basins' => $basins,
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
            'wua_id'=>'nullable',
            'region_id'=>'nullable',
            'qwua_avg'=>'nullable',
            'volume_w'=>'nullable',
        ]);

        $volume_w = Qcordinate::wValue($data['qwua_avg']);
        
        if(!$volume_w){
            $data['volume_w'] = NULL;
        } else {
            $data['volume_w'] = $volume_w;
        }

        Qwua::create($data);
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
        $qwua = Qwua::findOrFail($id);

        return view('modeli.qwua_edit', compact('qwua', 'id'));
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
            'wua_id'=>'nullable',
            'region_id'=>'nullable',
            'qwua_avg'=>'nullable',
            'volume_w'=>'nullable',
        ]);

        $qwua = Qwua::findOrFail($id);
        $qwua->fill($data)->save();

        return redirect()->route('modeli.qwua.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qwua = Qwua::findOrFail($id);
        $qwua->delete();

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
