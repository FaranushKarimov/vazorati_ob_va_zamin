<?php

namespace App\Http\Controllers\Planirovanie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\WaterBasinZone;
use App\Canal;
use App\Wua;
use App\BillingWua;
use App\Decada;

use App\Exports\ExcelExport;
use Excel;
use \DB;
use Auth;

class VodoraspredeleniiaController extends Controller
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
            "wua_id" => "Код АВП",
            "wua_name" => "Название АВП",
            "total_area" => "Итого (га)",
            "water_vol" => "Объем требуемой воды (тыс л/год)",
            "water_vol_fact" => "Объем исполь. воды (тыс л/год)",
            "water_vol_diff" => "Разница (тыс л/год)",
            "date" => "Год",
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

        $user = Auth::user();

        $req_basin_id = $request->input('basin_id');
        $req_canal_id = $request->input('canal_id');
        $req_wua_id = $request->input('wua_id');
        $req_year = $request->input('year');
        $req_export = $request->input('export');

        $basin_wua_ids = Wua::where('basin_id','=',$user->basin_id)->pluck('billing_id')->toArray();
        $wua_ids = array();

        $comp_billings = BillingWua::on('sqlsrv')->orderBy('wua_name', 'asc');

        if(!empty($req_wua_id)) {
            $wua_ids = array($req_wua_id); // each wua
        } else if(!empty($req_canal_id)) {
            $wua_ids = Wua::where('canal_id','=',$req_canal_id)->pluck('billing_id')->toArray(); // each canal
        } else if(!empty($req_basin_id)) {
            $wua_ids = Wua::where('basin_id','=',$req_basin_id)->pluck('billing_id')->toArray(); // each canal
        }

        if(empty($req_year)) {
            $req_year = 2019;
        }

        $comp_billings = $comp_billings->where('contract_date','like',$req_year . '%');
        $comp_billings = $comp_billings->whereIn('wua_id', $wua_ids);
        $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);
        
        if($user->role && $user->role->title =='super-admin') {
            if(!empty($req_basin_id)) {
                $comp_billings = $comp_billings->whereIn('wua_id', $wua_ids);
            } 
        } else {
            $comp_billings = $comp_billings->whereIn('wua_id', array_intersect($basin_wua_ids,$wua_ids));
            $basins = $basins->where('id','=',$user->basin_id);
        }

        if($req_export){
            $comp_billings = $comp_billings->get();

            $comp_billings->each(function ($item, $key) use ($req_year) {
                if($item->wua){
                    $wua_id = $item->wua->id;
                    $item->water_vol_fact = Decada::on('mysql')->select(['volume_1','volume_2','volume_3'])->whereYear('date','=',$req_year)->where('wua_id','=',$wua_id)->where('type','=',2)->sum(DB::raw('volume_1 + volume_2 + volume_3'));
                } else {
                    $item->water_vol_fact = NULL;
                }
            });

            $arr_all = [
                [
                    '#',
                    $columns['wua_id'],
                    $columns['wua_name'],
                    $columns['total_area'],
                    $columns['water_vol'],
                    $columns['water_vol_fact'],
                    $columns['water_vol_diff'],
                    $columns['date'],
                ]
            ];

            $arr = [];

            foreach ($comp_billings as $key => $comp_billing) {
                array_push($arr,$key+1);
                array_push($arr,$comp_billing->wua_id);
                array_push($arr,$comp_billing->wua ? $comp_billing->wua->name_ru : $comp_billing->wua_name);
                array_push($arr,number_format($comp_billing->total_area, 2));
                array_push($arr,number_format($comp_billing->water_vol/1000, 2));
                array_push($arr,number_format($comp_billing->water_vol_fact, 2));
                array_push($arr,number_format($comp_billing->water_vol_fact - $comp_billing->water_vol/1000, 2));
                array_push($arr,$comp_billing->contract_date);

                array_push($arr_all,$arr);

                $arr = [];
            }

            $export = new ExcelExport($arr_all);

            // return Excel::create('ExcelExport.xlsx', function($exc){
            //     $sheet = $exc->sheet();

            // })->download('xlsx');
            return Excel::download($export, 'ExcelExport.xlsx');
        }

        $comp_billings = $comp_billings->paginate(20);

        $comp_billings->each(function ($item, $key) use ($req_year) {
            if($item->wua){
                $wua_id = $item->wua->id;
                $item->water_vol_fact = Decada::on('mysql')->select(['volume_1','volume_2','volume_3'])->whereYear('date','=',$req_year)->where('wua_id','=',$wua_id)->where('type','=',2)->sum(DB::raw('volume_1 + volume_2 + volume_3'));
            } else {
                $item->water_vol_fact = NULL;
            }
        });

        $comp_billings->appends($request->all());

        return view('planirovanie/vodoraspredeleniia',[
            'columns' => $columns,
            'billings' => $comp_billings,
            'basins' => $basins,
            'years' => $years,
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

        $wuas = Wua::orderBy('id')->where('canal_id','=',$request->get('canal_id'))->get(['id','canal_id','billing_id','name_tj','name_ru','name_en']);
        return response()->json($wuas);
    }
}
