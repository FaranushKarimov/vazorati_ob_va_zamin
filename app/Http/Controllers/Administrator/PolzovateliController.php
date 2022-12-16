<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use App\User;
use App\UserRole;
use App\WaterBasinZone;

class PolzovateliController extends Controller
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
            "name" => "Именавание",
            "email" => "Логин (E-mail)",
            "basin_id" => "Название бассейна",
            "role_id" => "Роль",
            "password" => "Пароль",
            "password_confirmation" => "Подтверждение пароля",
            "created_at" => "Время создания записи",
            "updated_at" => "Время обновление записи",
        );

        $polzovatels = User::orderBy('id', 'desc');

        if(!empty($request->get('basin_id'))) {
            $polzovatels = $polzovatels->where('basin_id','=',$request->get('basin_id'));
        } 

        if(!empty($request->get('role_id'))) {
            $polzovatels = $polzovatels->where('role_id','=',$request->get('role_id'));
        } 

        $polzovatels = $polzovatels->paginate(10);

        $roles = UserRole::all();
        $basins = WaterBasinZone::all();

        $polzovatels->appends($request->all());

        return view('administrator/polzovateli',[
            "polzovatels" => $polzovatels,
            "roles" => $roles,
            "basins" => $basins,
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
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users'],
            'basin_id'=>'required',
            'role_id'=>'nullable',
            'password'=>['required', 'string', 'min:6', 'confirmed'],
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);

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
        $polzovatel = User::findOrFail($id);

        $roles = UserRole::all();
        $basins = WaterBasinZone::all();

        return view('administrator.polzovateli_edit', [
            "polzovatel" => $polzovatel,
            "id" => $id,
            "roles" => $roles,
            "basins" => $basins,
        ]);
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
            'name'=>['required', 'string', 'max:255'],
            // 'email'=>['required', 'string', 'email', 'max:255', 'exists:users'],
            'basin_id'=>'required',
            'role_id'=>'nullable',
            // 'password'=>['required', 'string', 'min:8', 'confirmed'],
        ]);

        if( !empty($request->get('password')) ) {
            $pa = $this->validate($request,['password'=>['required', 'string', 'min:6', 'confirmed']]);
            $data['password'] = Hash::make($pa['password']);
        }

        $polzovatel = User::findOrFail($id);
        $polzovatel->fill($data)->save();

        return redirect()->route('administrator.polzovateli.index')->with('message', 'Сохранено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $polzovatel = User::findOrFail($id);
        $polzovatel->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }
}
