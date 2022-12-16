<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UserRole;

class RoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $columns = array(
            "id" => "Код",
            "title" => "Именавание",
            "name_ru" => "Название на русском",
            "name_tj" => "Название на таджикском",
            "name_en" => "Название на английском",
            "description" => "Описание",
            "created_at" => "Время создания записи",
            "updated_at" => "Время обновление записи",
        );

        $roles = UserRole::paginate(10);

        $roles->appends($request->all());

        return view('administrator/roli',[
            "roles" => $roles,
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
            'title'=>['required', 'string', 'max:255'],
            'name_ru'=>['required', 'max:255'],
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'description'=>['required', 'max:255'],
        ]);
        UserRole::create($data);

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
        $role = UserRole::findOrFail($id);

        return view('administrator.roli_edit', compact('role', 'id'));
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
            'title'=>['required', 'string', 'max:255'],
            'name_ru'=>['required', 'max:255'],
            'name_tj'=>'nullable',
            'name_en'=>'nullable',
            'description'=>['required', 'max:255'],
        ]);

        $role = UserRole::findOrFail($id);
        $role->fill($data)->save();

        return redirect()->route('administrator.roli.index')->with('message', 'Сохранено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roli = UserRole::findOrFail($id);
        $roli->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
