<?php

namespace App\Http\Controllers;

use App\agriculture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgricultureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $agriculture = DB::table('agriculture')
            ->select('wuas.id_from_billing','agriculture.water_for_corn','agriculture.water_for_cotton','agriculture.water_for_vegetables',
                'agriculture.water_for_gourds','agriculture.water_for_potatoes','agriculture.water_for_grass','agriculture.water_for_crops',
                 'agriculture.water_for_clover','agriculture.water_for_gardens','agriculture.water_for_crop_1','agriculture.water_for_crop_2','agriculture.summary_of_water','agriculture.volume_of_water')
            ->join('wuas','wuas.objectid','=','agriculture.id_wua')
            ->get();
        return view('agriculture.index',['agriculture'=>$agriculture]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('agriculture.create');
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
     * @param  \App\agriculture  $agriculture
     * @return \Illuminate\Http\Response
     */
    public function show(agriculture $agriculture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\agriculture  $agriculture
     * @return \Illuminate\Http\Response
     */
    public function edit(agriculture $agriculture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\agriculture  $agriculture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, agriculture $agriculture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\agriculture  $agriculture
     * @return \Illuminate\Http\Response
     */
    public function destroy(agriculture $agriculture)
    {
        //
    }
}
