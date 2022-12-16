<?php

namespace App\Http\Controllers\Planirovanie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \DB;

use App\Wua;
use App\Hydropost;
use App\WaterLevel;
use App\WaterBasinZone;

use App\Qms;
use App\Qwua;
use App\Decada;

use App\Exports\ExcelExport;
use Excel;
use Auth;

class VodopadachiController extends Controller
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
            "wua_id" => "Название АВП",
            "hydropost_id" => "Название Гидропоста",
            "gsm_hydropost_id" => "Код Гидропоста",
            "description" => "Примечание",
            "type" => "Тип",
            "volume_1" => "Объем воды(W), 1-я декада (тыс. м3)",
            "volume_2" => "Объем воды(W),2-я декада (тыс. м3)",
            "volume_3" => "Объем воды(W),3-я декада (тыс. м3)",
            "month" => "Итого за месяц (тыс. м3)",
            "year" => "Итого за год (тыс. м3)",
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

        $req_type = 1; // default to each hydropost decada
        if($request->get('type')){
            $req_type = $request->get('type');
            // $req_type = 2;
        }

        if($request->get('update_decadas')=='yes'){
            if($req_type == 1) {
                $last_decada = Decada::orderBy('date', 'desc')->where('type','=',$req_type)->first();
                // dd($last_decada);
                if($last_decada){
                    $d_start = (new \Carbon\Carbon($last_decada->date))->addMonths(1);     
                } else {
                    $d_start = (new \Carbon\Carbon('2015-01-01'))->addMonths(1);
                }

                $d_end = \Carbon\Carbon::now()->subMonths(0);

                $dateBetween = array($d_start->format('Y-m-d'),$d_end->format('Y-m-d')); // recalc last month everytime

                // $dates = Qms::select('date')->orderBy('date')->whereBetween('date',$dateBetween)->groupBy('date')->pluck('date')->toArray();

                // dd($dateBetween);
                // dd($dates);
                // $d_start->endOfMonth();
                // dd($d_start);
                // $dates_months = array_map(function($el){
                //     return substr($el,5,2);
                // },$dates);

                // dd($dates_months);
                // dd($d_start->startOfMonth()->copy()->addDays(9)->format('Y-m-d'));

                $hydroposts = Hydropost::all();
                $h_ids = $hydroposts->pluck('id')->toArray();
                // dd($h_ids);
                $newDecadas = array();
                
                foreach ($hydroposts as $hyd) {
                    // while ($d_start->format('Y') <= $d_end->format('Y')) {
                        // while ($d_start->format('m') <= $d_end->format('m')) {
                        $d_start_clone = clone($d_start);
                            // dd('0');
                        while ($d_start_clone->copy()->subMonths(2)->diffInMonths($d_end)) {
                            $dec_d1 = [$d_start_clone->copy()->startOfMonth()->format('Y-m-d'),$d_start_clone->copy()->startOfMonth()->addDays(9)->format('Y-m-d')];
                            $dec_d2 = [$d_start_clone->copy()->startOfMonth()->addDays(10)->format('Y-m-d'),$d_start_clone->copy()->startOfMonth()->addDays(19)->format('Y-m-d')];
                            $dec_d3 = [$d_start_clone->copy()->startOfMonth()->addDays(20)->format('Y-m-d'),$d_start_clone->copy()->endOfMonth()->format('Y-m-d')];
                            // dd($dec_d3);
                            // dd('0');
                            $q1 = Qms::where('hydropost_id','=',$hyd->id)->whereBetween('date',$dec_d1)->sum('volume_w');
                            $q2 = Qms::where('hydropost_id','=',$hyd->id)->whereBetween('date',$dec_d2)->sum('volume_w');
                            $q3 = Qms::where('hydropost_id','=',$hyd->id)->whereBetween('date',$dec_d3)->sum('volume_w');
                            
                            if($d_start_clone->copy()->subMonths(1)->diffInMonths($d_end) == 0){
                                // dd($d_start_clone->format('Y-m-d'));
                                $ex = Decada::where('type','=',$req_type)->whereYear('date','=',$d_start_clone->format('Y'))->whereMonth('date','=',$d_start_clone->format('m'))->first();
                                if($ex){
                                    $ex->update(array(
                                        'volume_1' => $q1,
                                        'volume_2' => $q2,
                                        'volume_3' => $q3,
                                        'updated_at' => \Carbon\Carbon::now(),
                                    ));
                                    // dd('1');
                                } else {
                                    array_push($newDecadas, 
                                        array(
                                            // 'id' => NULL,
                                            'wua_id' => $hyd->wua_id,
                                            'hydropost_id' => $hyd->id,
                                            'description' => NULL,
                                            'type' => $req_type, // 1 for qms, 2 for qwua
                                            'volume_1' => $q1,
                                            'volume_2' => $q2,
                                            'volume_3' => $q3,
                                            'date' => $d_start_clone->copy()->endOfMonth()->format('Y-m-d'),
                                            'created_at' => \Carbon\Carbon::now(),
                                            'updated_at' => \Carbon\Carbon::now(),
                                        )
                                    );
                                }
                            } else {
                             // if($q1 || $q2 || $q3){
                            if(true){
                                array_push($newDecadas, 
                                    array(
                                        // 'id' => NULL,
                                        'wua_id' => $hyd->wua_id,
                                        'hydropost_id' => $hyd->id,
                                        'description' => NULL,
                                        'type' => $req_type, // 1 for qms, 2 for qwua
                                        'volume_1' => $q1,
                                        'volume_2' => $q2,
                                        'volume_3' => $q3,
                                        'date' => $d_start_clone->copy()->endOfMonth()->format('Y-m-d'),
                                        'created_at' => \Carbon\Carbon::now(),
                                        'updated_at' => \Carbon\Carbon::now(),
                                    )
                                );
                             }
                            }

                            $d_start_clone->addMonths(1);
                        }
                        // $d_start->addYears(1);
                    // }
                }
                // dd($newDecadas);

                Decada::insert($newDecadas);
                
                return redirect()->route('planirovanie.vodopadachi.index');
            } else if($req_type == 2) {
                $last_decada = Decada::orderBy('date', 'desc')->where('type','=',$req_type)->first();
                // dd($last_decada);
                if($last_decada){
                    $d_start = (new \Carbon\Carbon($last_decada->date))->addMonths(1);     
                } else {
                    $d_start = (new \Carbon\Carbon('2015-01-01'))->addMonths(1);
                }

                $d_end = \Carbon\Carbon::now()->subMonths(0);

                $dateBetween = array($d_start->format('Y-m-d'),$d_end->format('Y-m-d')); // recalc last month everytime

                // $dates = Qms::select('date')->orderBy('date')->whereBetween('date',$dateBetween)->groupBy('date')->pluck('date')->toArray();

                // dd($dateBetween);
                // dd($dates);
                // $d_start->endOfMonth();
                // dd($d_start);
                // $dates_months = array_map(function($el){
                //     return substr($el,5,2);
                // },$dates);

                // dd($dates_months);
                // dd($d_start->startOfMonth()->copy()->addDays(9)->format('Y-m-d'));

                // $hydroposts = Hydropost::all();
                $wuas_all = Wua::all();
                $w_ids = $wuas_all->pluck('id')->toArray();
                // dd($h_ids);
                $newDecadas = array();
                
                foreach ($wuas_all as $wua_each) {
                    // while ($d_start->format('Y') <= $d_end->format('Y')) {
                        // while ($d_start->format('m') <= $d_end->format('m')) {
                        $d_start_clone = clone($d_start);
                            // dd('0');
                        while ($d_start_clone->copy()->subMonths(2)->diffInMonths($d_end)) {
                            $dec_d1 = [$d_start_clone->copy()->startOfMonth()->format('Y-m-d'),$d_start_clone->copy()->startOfMonth()->addDays(9)->format('Y-m-d')];
                            $dec_d2 = [$d_start_clone->copy()->startOfMonth()->addDays(10)->format('Y-m-d'),$d_start_clone->copy()->startOfMonth()->addDays(19)->format('Y-m-d')];
                            $dec_d3 = [$d_start_clone->copy()->startOfMonth()->addDays(20)->format('Y-m-d'),$d_start_clone->copy()->endOfMonth()->format('Y-m-d')];
                            // dd($dec_d3);
                            // dd('0');
                            $q1 = Qwua::where('wua_id','=',$wua_each->id)->whereBetween('date',$dec_d1)->sum('volume_w');
                            $q2 = Qwua::where('wua_id','=',$wua_each->id)->whereBetween('date',$dec_d2)->sum('volume_w');
                            $q3 = Qwua::where('wua_id','=',$wua_each->id)->whereBetween('date',$dec_d3)->sum('volume_w');
                            
                            if($d_start_clone->copy()->subMonths(1)->diffInMonths($d_end) == 0){
                                // dd($d_start_clone->format('Y-m-d'));
                                $ex = Decada::where('type','=',$req_type)->whereYear('date','=',$d_start_clone->format('Y'))->whereMonth('date','=',$d_start_clone->format('m'))->first();
                                if($ex){
                                    $ex->update(array(
                                        'volume_1' => $q1,
                                        'volume_2' => $q2,
                                        'volume_3' => $q3,
                                        'updated_at' => \Carbon\Carbon::now(),
                                    ));
                                    // dd('1');
                                } else {
                                    array_push($newDecadas, 
                                        array(
                                            // 'id' => NULL,
                                            'wua_id' => $wua_each->id,
                                            'hydropost_id' => NULL,
                                            'description' => NULL,
                                            'type' => $req_type, // 1 for qms, 2 for qwua
                                            'volume_1' => $q1,
                                            'volume_2' => $q2,
                                            'volume_3' => $q3,
                                            'date' => ($d_start_clone->copy()->subMonths(1)->diffInMonths($d_end) == 0) ? $d_start_clone->format('Y-m-d') : $d_start_clone->copy()->endOfMonth()->format('Y-m-d'),
                                            'created_at' => \Carbon\Carbon::now(),
                                            'updated_at' => \Carbon\Carbon::now(),
                                        )
                                    );
                                }
                            } else {
                             // if($q1 || $q2 || $q3){
                            if(true){
                                array_push($newDecadas, 
                                    array(
                                        // 'id' => NULL,
                                        'wua_id' => $wua_each->id,
                                        'hydropost_id' => NULL,
                                        'description' => NULL,
                                        'type' => $req_type, // 1 for qms, 2 for qwua
                                        'volume_1' => $q1,
                                        'volume_2' => $q2,
                                        'volume_3' => $q3,
                                        'date' => ($d_start_clone->copy()->subMonths(1)->diffInMonths($d_end) == 0) ? $d_start_clone->format('Y-m-d') : $d_start_clone->copy()->endOfMonth()->format('Y-m-d'),
                                        'created_at' => \Carbon\Carbon::now(),
                                        'updated_at' => \Carbon\Carbon::now(),
                                    )
                                );
                             }
                            }

                            $d_start_clone->addMonths(1);
                        }
                        // $d_start->addYears(1);
                    // }
                }
                // dd($newDecadas);

                Decada::insert($newDecadas);
                
                return redirect()->route('planirovanie.vodopadachi.index');
            }
        }

        $user = Auth::user();

        $req_basin_id = $request->input('basin_id');
        $req_canal_id = $request->input('canal_id');
        $req_wua_id = $request->input('wua_id');
        $req_year = $request->input('year');
        $req_month = $request->input('month');
        $req_export = $request->input('export');

        $basin_wua_ids = Wua::where('basin_id','=',$user->basin_id)->pluck('billing_id')->toArray();
        $wua_ids = array();

        $decadas = Decada::on('mysql')->orderBy('date', 'desc')->where('type','=',$req_type);
        $dec_year = 0;

        if(!empty($req_wua_id)) {
            $wua_ids = array($req_wua_id); // each wua
        } else if(!empty($req_canal_id)) {
            $wua_ids = Wua::where('canal_id','=',$req_canal_id)->pluck('id')->toArray(); // each canal
        } else if(!empty($req_basin_id)) {
            $wua_ids = Wua::where('basin_id','=',$req_basin_id)->pluck('id')->toArray(); // each canal
        }

        if(!empty($req_year)) {
            $decadas = $decadas->whereYear('date','=',$req_year);
        }

        if(!empty($req_month)) {
            $decadas = $decadas->whereMonth('date','=',$req_month);
        }

        $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);

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
            return Excel::download($export, 'VodopadachiExport.xlsx');
        }

        $decadas = $decadas->paginate(20);
        $decadas->year = $dec_year;

        $decadas->appends($request->all());

        return view('planirovanie/vodopadachi',[
            'columns' => $columns,
            'decadas' => $decadas,
            'type' => $req_type,
            'basins' => $basins,
            'years' => $years,
            'months' => $months,
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
