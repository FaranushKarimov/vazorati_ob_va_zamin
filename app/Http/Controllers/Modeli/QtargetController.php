<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Qtarget;

class QtargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = array(
            "id" => "Код",
            "wua_id" => "Код АВП",
            "region_id" => "Код области",
            "qms_plan_per_day" => "Расход воды по плану на каждый день",
            "created_at" => "Время создания записи",
            "updated_at" => "Время обновления записи",
        );

        $qtargets = Qtarget::orderBy('id', 'desc')->paginate(20);
        return view("modeli.qtarget", [
            "qtargets" => $qtargets,
            "columns" => $columns,
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
            'qms_plan_per_day'=>'nullable',
        ]);
        Qtarget::create($data);
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
        $qtarget = Qtarget::findOrFail($id);

        return view('modeli.qtarget_edit', compact('qtarget', 'id'));
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
            'qms_plan_per_day'=>'nullable',
        ]);

        $qtarget = Qtarget::findOrFail($id);
        $qtarget->fill($data)->save();

        return redirect()->route('modeli.qtarget.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qtarget = Qtarget::findOrFail($id);
        $qtarget->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
