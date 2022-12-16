<?php

namespace App\Http\Controllers\Planirovanie;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use \DB;

use App\WaterLevel;
use App\Hydropost;
use App\Wua;
use App\Canal;
use App\WaterBasinZone;

use App\Qms;
use App\Decada;

use App\Exports\ExcelExport;
use Excel;
use Auth;

class EffectivnostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = array(
            "id" => "id",
            "basin_id" => "Название Бассейна",
            "canal_id" => "Название Канала",
            "volume_1" => "Водозабор (VV) (тыс. м3)",
            "volume_2" => "Водопадача по АВП (VV) (тыс. м3)",
            // "volume_w" => "Объем воды (W) (тыс. м3)",
            "effectivnost" => "Эффективность (Ek) (%)",
            "date" => "Дата",
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

        // $user = Auth::user();

        $req_basin_id = $request->input('basin_id');
        $req_year = $request->input('year');
        $req_month = $request->input('month');


        // $req_export = $request->input('export');

        $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);
        $canals = Canal::where('basin_id','=',$req_basin_id)->get(['id','name_tj','name_ru','name_en']);
        $effect_qmss = new Collection([]);
        $basin_total = 0;

        foreach ($canals as $canal) {
            $hydropost_ids_1 = Hydropost::where('canal_id','=',$canal->id)->where('type','=',1)->pluck('id')->toArray();
            $hydropost_ids_2 = Hydropost::where('canal_id','=',$canal->id)->where('type','=',2)->pluck('id')->toArray();
            
            if(!$hydropost_ids_1) {
                continue;
            }

            $qms_1 = Qms::orderBy('date', 'desc')->where('hydropost_id','=',$hydropost_ids_1[0]);
            $qms_2 = Qms::orderBy('date', 'desc')->whereIn('hydropost_id',$hydropost_ids_2);

            // $qms_1 = Decada::orderBy('date', 'desc')->where('type','=',1)->where('hydropost_id','=',$hydropost_ids_1[0]);
            // $qms_2 = Decada::orderBy('date', 'desc')->where('type','=',1)->whereIn('hydropost_id',$hydropost_ids_2);

            // $qms_1 = Decada::from( 'decadas as decadas_1')->selectRaw('month(decadas_1.date) month_1, max(decadas_1.volume_1) as volume_1_1, max(decadas_1.volume_2) as volume_1_2, max(decadas_1.volume_3) as volume_1_3')->groupBy('month_1')->orderBy('month_1','desc')->where('type','=',1)->where('hydropost_id','=',$hydropost_ids_1[0]);
            // $qms_2 = Decada::from( 'decadas as decadas_2')->selectRaw('month(decadas_2.date) month_2, sum(decadas_2.volume_1) as volume_2_1, sum(decadas_2.volume_2) as volume_2_2, sum(decadas_2.volume_3) as volume_2_3')->groupBy('month_2')->orderBy('month_2','desc')->where('type','=',1)->whereIn('hydropost_id',$hydropost_ids_2);
            if(empty($req_year)) {
                $req_year = '2020';
            }

            if(!empty($req_year)) {
                $qms_1 = $qms_1->whereYear('date','=',$req_year);
                $qms_2 = $qms_2->whereYear('date','=',$req_year);
            }

            if(!empty($req_month)) {
                $qms_1 = $qms_1->whereMonth('date','=',$req_month);
                $qms_2 = $qms_2->whereMonth('date','=',$req_month);
            }

            // $join = $qms_1->joinSub($qms_2,'d_2',\DB::raw("month('decadas_1.date') = 'd_2.month_2' /*"),\DB::raw('*/'), \DB::raw(''));
            // $join = $qms_1->joinSub($qms_2,'d_2',function($j){
            //             $j->on(\DB::raw("month('decadas_1.date') = 'd_2.month_2' /*"),\DB::raw('*/'), \DB::raw(' '));
            //             // $j->on('decadas_1.date','=','d_2.month_2');
            //         });
            // dd($join->get(),$qms_2->get());
            
            // dd($qms_1->get(),$qms_2->get());
            // $qms_effect_d1 = $qms_1->volume_1 - $qms_2_sum->volume_1;
            $qms_1_sum = $qms_1->sum('volume_w');
            $qms_2_sum = $qms_2->sum('volume_w');
            
            $effect_w = $qms_1_sum - $qms_2_sum;
            $basin_total = $basin_total + $effect_w;
            
            $effectivnost = 0;
            if($qms_1_sum) {
                $effectivnost = $qms_2_sum * 100 / $qms_1_sum;
                $effectivnost = round($effectivnost, 1);
            }

            $effect_qms = (object) [
                'id' => 0, 
                'basin_id' => $req_basin_id, 
                'basin' => WaterBasinZone::find($req_basin_id), 
                'canal_id' => $canal->id, 
                'canal' => $canal, 
                'volume_1' => $qms_1_sum, 
                'volume_2' => $qms_2_sum, 
                // 'volume_w' => $effect_w, 
                'effectivnost' => $effectivnost, 
                'year' => $req_year, 
                'month' => $req_month, 
            ];

            $effect_qmss->push($effect_qms);
        }

        // dd($effect_qmss);

    /*  
        if($user->role && $user->role->title =='super-admin') {
            if(!empty($req_basin_id)) {
                $decadas = $decadas->whereIn('wua_id', $wua_ids);
                if(!empty($req_year)) {
                    $dec_year = Decada::on('mysql')->select(['volume_1','volume_2','volume_3'])->whereYear('date','=',$req_year)->whereIn('wua_id', $wua_ids)->where('type','=',$req_type)->sum(DB::raw('volume_1 + volume_2 + volume_3'));
                }
            }

            if(!empty($req_year)) {
                $dec_year = Decada::on('mysql')->select(['volume_1','volume_2','volume_3'])->whereYear('date','=',$req_year)->whereIn('wua_id', $wua_ids)->where('type','=',$req_type)->sum(DB::raw('volume_1 + volume_2 + volume_3'));
            }
        } else {
            if(!empty($req_year)) {
                $dec_year = Decada::on('mysql')->select(['volume_1','volume_2','volume_3'])->whereYear('date','=',$req_year)->whereIn('wua_id', array_intersect($basin_wua_ids,$wua_ids))->where('type','=',$req_type)->sum(DB::raw('volume_1 + volume_2 + volume_3'));
            }
            $decadas = $decadas->whereIn('wua_id', array_intersect($basin_wua_ids,$wua_ids));
            $basins = $basins->where('id','=',$user->basin_id);
        }

        if($req_export){
            $decadas = $decadas->get();
            $arr_all = [
                [
                    '#',
                    $columns['id'],
                    $columns['wua_id'],
                ]
            ];

            if ($req_type == '1'){
                array_push($arr_all[0], 
                    $columns['hydropost_id']
                );
            };

            array_push($arr_all[0], 
                $columns['volume_1'],
                $columns['volume_2'],
                $columns['volume_3'],
                $columns['month'],
                $columns['date'],
                $columns['description']
            );

            $arr = [];

            foreach ($decadas as $key => $decada) {
                array_push($arr,$key+1);
                array_push($arr,$decada->id);
                array_push($arr,$decada->wua ? $decada->wua->name_ru : $decada->wua_id);
                if ($req_type == '1') {
                    array_push($arr, $decada->hydropost ? $decada->hydropost->name_ru : $decada->hydropost_id);
                }
                array_push($arr,$decada->volume_1);
                array_push($arr,$decada->volume_2);
                array_push($arr,$decada->volume_3);
                array_push($arr,$decada->volume_1 + $decada->volume_2 + $decada->volume_3);
                array_push($arr,$decada->date);
                array_push($arr,$decada->description);

                array_push($arr_all,$arr);

                $arr = [];
            }

            $export = new ExcelExport($arr_all);
            return Excel::download($export, 'EffectivnostExport.xlsx');
        }
    */

        // $effect_qmss = $effect_qmss->paginate(20);

        // $effect_qmss->appends($request->all());

        return view('planirovanie/effectivnost',[
            'columns' => $columns,
            'effect_qmss' => $effect_qmss,
            // 'type' => $req_type,
            'basins' => $basins,
            'years' => $years,
            'months' => $months,
            'basin_total' => $basin_total,
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
