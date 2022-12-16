<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\WaterBasinZone;
use App\Canal;
use App\Wua;
use App\BillingWua;
use App\Decada;

use \DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
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
        
        // $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);
        



        $user = Auth::user();

        // $req_basin_id = $request->input('basin_id');
        $req_canal_id = $request->input('canal_id');
        // $req_wua_id = $request->input('wua_id');
        $req_year = $request->input('year');
        // $req_export = $request->input('export');

        $basin_wua_ids = Wua::where('basin_id','=',$user->basin_id)->pluck('billing_id')->toArray();
        $canals = Canal::orderBy('id')->where('basin_id','=',$user->basin_id)->get(['id','basin_id','name_tj','name_ru','name_en']);
        $wua_ids = array();

        $comp_billings = BillingWua::on('sqlsrv')->orderBy('wua_name', 'asc');

        if(!empty($req_canal_id)) {
            $wua_ids = Wua::where('canal_id','=',$req_canal_id)->pluck('billing_id')->toArray(); // each canal
        } else if($canals->isNotEmpty()) {
            $wua_ids = Wua::where('canal_id','=',$canals->first()->id)->pluck('billing_id')->toArray(); // each canal
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

        return view('home',[
            // 'basins' => $basins,
            'canals' => $canals,
            'billings' => $comp_billings,
            // 'wuas' => $wuas,
            'years' => $years,
        ]);
    }
}
