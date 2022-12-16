<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\OperationLog;

class LogsController extends Controller
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
            "user_id" => "Пользователь",
            "type" => "Тип операции",
            "operation" => "Детали операции",
            "created_at" => "Время создания записи",
            "notes" => "Примечание",
            "updated_at" => "Время обновления примечаний",
        );

        $type_filters = array(
            ["id"=>"view", "name"=>"просмотр"],
            ["id"=>"edit", "name"=>"редактирование"],
            ["id"=>"create", "name"=>"создание"],
            ["id"=>"delete", "name"=>"удаление"],
            ["id"=>"other", "name"=>"другое"],
        );

        // dd($type_filters[0]);

        $users = User::orderBy('name', 'desc')->get();
        $operation_logs = OperationLog::orderBy('created_at', 'desc');

        if(!empty($request->get('user_id'))) {
            $operation_logs = $operation_logs->where('user_id','=',$request->get('user_id'));
        }

        if(!empty($request->get('type'))) {
            $operation_logs = $operation_logs->where('type','=',$request->get('type'));
        }

        $operation_logs = $operation_logs->paginate(10);
        $operation_logs->appends($request->all());

        return view('administrator/logs',[
            "operation_logs" => $operation_logs,
            "users" => $users,
            "type_filters" => $type_filters,
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
        $data = $this->validate($request, [
            'notes'=>['required', 'string', 'max:255'],
        ]);

        $operation_log = OperationLog::findOrFail($id);
        $operation_log->fill($data)->save();

        return redirect()->back()->with('message', 'Сохранено!');
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
