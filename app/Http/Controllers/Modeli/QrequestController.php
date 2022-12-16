<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Qrequest;

class QrequestController extends Controller
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
            "region_id" => "Код области",
            "wua_id" => "Код АВП",
            "qms_request_per_day" => "Запрос воды на каждый день",
            "created_at" => "Время создание записи",
            "updated_at" => "Время обновления записи",
        );

        $qrequests = Qrequest::orderBy('id', 'desc')->paginate(20);
        return view("modeli.qrequest", [
            "qrequests" => $qrequests,
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
            'region_id'=>'nullable',
            'wua_id'=>'nullable',
            'qms_request_per_day'=>'nullable',
        ]);
        Qrequest::create($data);
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
        $qrequest = Qrequest::findOrFail($id);

        return view('modeli.qrequest_edit', compact('qrequest', 'id'));
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
            'region_id'=>'nullable',
            'wua_id'=>'nullable',
            'qms_request_per_day'=>'nullable',
        ]);

        $qrequest = Qrequest::findOrFail($id);
        $qrequest->fill($data)->save();

        return redirect()->route('modeli.qrequest.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qrequest = Qrequest::findOrFail($id);
        $qrequest->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
