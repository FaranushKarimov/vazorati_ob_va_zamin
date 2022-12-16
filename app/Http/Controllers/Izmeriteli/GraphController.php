<?php

namespace App\Http\Controllers\Izmeriteli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\WaterBasinZone;


class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);
        $req_basin_id = $request->input('basin_id');
        $selectedBasin = WaterBasinZone::find($req_basin_id);
        $link = "https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Abb3248e6105572a771fa2318a68981d170a4da021e6e325d562ab96945d87bd2&amp;width=900&amp;height=720&amp;id=ya_map&amp;lang=ru_RU&amp;scroll=true";
        $selectedIframe = '';

        if($selectedBasin && str_contains(mb_strtolower($selectedBasin->name_ru),"зарафшан")) {
            $selectedIframe = "zarafshan";
            $link = "https://www.google.com/maps/d/embed?mid=12C_afXf-mTKlROOBPCKvIKK-B3Mymx0U";
            // $link = "https://www.google.com/maps/d/embed?mid=182InUP8wrD-qHN54SujVT-9HLvjA817U"; // for WUAs
        } elseif($selectedBasin && str_contains(mb_strtolower($selectedBasin->name_ru),'кафирниган')) {
            $selectedIframe = "kafirnigan";
            $link = "https://www.google.com/maps/d/embed?mid=1kS1dyBzN6f9GI77P4GPNgCMNgbvfmOsn";
        } else {
            $selectedIframe = "none";
        }

        if(!$req_basin_id) {
            $selectedIframe = "all";
        }
        
        return view('izmeriteli/graph',[
            'basins' => $basins,
            'iframe' => $selectedIframe,
            'link' => $link,
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
}
