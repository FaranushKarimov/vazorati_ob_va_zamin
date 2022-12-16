<?php

namespace App\Http\Controllers\Planirovanie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Billing;
use App\BillingWua;

use App\WaterBasinZone;
use App\Canal;
use App\Wua;

use App\Exports\ExcelExport;
use Excel;
use Auth;

class SevaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = array(
            "kho_id" => "Код Д/Х ",
            "kho_name" => "Наименование Д/Х",
            "kho_head" => "ФИО Руководителя",
            "wua_id" => "Код АВП",
            "wua_name" => "Название АВП",
            "ghalla" => "Зерно",
            "pakhta" => "Хлопок",
            "sabzavot" => "Овощи",
            "poliziho" => "Бахчевые",
            "kartoshka" => "Картошка",
            "tamoku_sit_zir_chorvo" => "Табак, цитрус и травы",
            "beda" => "Клевер",
            "sholi" => "Рис",
            "boghho" => "Сады",
            "jmaka_don_hos_1" => "Кукуруза 1-ый урожай",
            "jmaka_don_hos_2" => "Кукуруза 2-ой урожай",
            "jmaka_silos_hos_2" => "Кукуруза силос 2-ой урожай",
            "total_area" => "Итого (га/год)",
            "water_vol" => "Объем требуемой воды (м3/год)",
            "contract_date" => "Дата контракта",
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

        // $type = $request->input('type');
        $user = Auth::user();

        $req_basin_id = $request->input('basin_id');
        $req_canal_id = $request->input('canal_id');
        $req_wua_id = $request->input('wua_id');
        $req_year = $request->input('year');
        $req_export = $request->input('export');
        
        $basin_wua_ids = Wua::where('basin_id','=',$user->basin_id)->pluck('billing_id')->toArray();
        $wua_ids = array();

        $billings = BillingWua::on('sqlsrv')->orderBy('wua_name', 'asc');

        if(!empty($req_year)){
            $billings = $billings->where('contract_date','like',$req_year . '%');
            if(!empty($req_wua_id)) {
                $wua_ids = array($req_wua_id);
                // each wua
            } else if($req_canal_id){
                $wua_ids = Wua::where('canal_id','=',$req_canal_id)->pluck('billing_id')->toArray();
                // each canal
            } else if($req_basin_id){
                $wua_ids = Wua::where('basin_id','=',$req_basin_id)->pluck('billing_id')->toArray();
                // each canal
            } 
        } else {
            if(!empty($req_wua_id)) {
                $wua_ids = array($req_wua_id); // each wua
            } else if($req_canal_id){
                $wua_ids = Wua::where('canal_id','=',$req_canal_id)->pluck('billing_id')->toArray(); // each canal
            } else if($req_basin_id){
                $wua_ids = Wua::where('basin_id','=',$req_basin_id)->pluck('billing_id')->toArray(); // each basin
            } 
        }
 
        $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);

        if($user->role && $user->role->title =='super-admin'){
            if($req_basin_id){
                $billings = $billings->whereIn('wua_id', $wua_ids);
            }
        } else {
            $billings = $billings->whereIn('wua_id', array_intersect($basin_wua_ids,$wua_ids));
            $basins = $basins->where('id','=',$user->basin_id);
        }

        if($req_export){
            $billings = $billings->get();
            $arr_all = [
                [
                    '#',
                    $columns['wua_id'],
                    $columns['wua_name'],
                    $columns['ghalla'],
                    $columns['pakhta'],
                    $columns['sabzavot'],
                    $columns['poliziho'],
                    $columns['kartoshka'],
                    $columns['tamoku_sit_zir_chorvo'],
                    $columns['beda'],
                    $columns['sholi'],
                    $columns['boghho'],
                    $columns['jmaka_don_hos_1'],
                    $columns['jmaka_don_hos_2'],
                    $columns['jmaka_silos_hos_2'],
                    $columns['total_area'],
                    $columns['water_vol'],
                    $columns['contract_date'],
                ]
            ];

            $arr = [];

            foreach ($billings as $key => $billing) {
                array_push($arr,$key+1);
                array_push($arr,$billing->wua_id);
                array_push($arr,$billing->wua ? $billing->wua->name_ru : $billing->wua_name);
                array_push($arr,number_format($billing->ghalla, 2));
                array_push($arr,number_format($billing->pakhta, 2));
                array_push($arr,number_format($billing->sabzavot, 2));
                array_push($arr,number_format($billing->poliziho, 2));
                array_push($arr,number_format($billing->kartoshka, 2));
                array_push($arr,number_format($billing->tamoku_sit_zir_chorvo, 2));
                array_push($arr,number_format($billing->beda, 2));
                array_push($arr,number_format($billing->sholi, 2));
                array_push($arr,number_format($billing->boghho, 2));
                array_push($arr,number_format($billing->jmaka_don_hos_1, 2));
                array_push($arr,number_format($billing->jmaka_don_hos_2, 2));
                array_push($arr,number_format($billing->jmaka_silos_hos_2, 2));
                array_push($arr,number_format($billing->total_area, 2));
                array_push($arr,number_format($billing->water_vol, 2));
                array_push($arr,$billing->contract_date);

                array_push($arr_all,$arr);

                $arr = [];
            }

            $export = new ExcelExport($arr_all);

            // return Excel::create('ExcelExport.xlsx', function($exc){
            //     $sheet = $exc->sheet();

            // })->download('xlsx');
            return Excel::download($export, 'ExcelExport.xlsx');
        }

        $billings = $billings->paginate(20);
        $billings->appends($request->all());
          
        return view('planirovanie/seva',[
            'columns' => $columns,
            'billings' => $billings,
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
