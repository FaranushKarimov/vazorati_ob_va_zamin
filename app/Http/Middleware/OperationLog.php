<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use App\OperationLog as OpLog;

class OperationLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $log = new OpLog;
        $op_type = 0;
        
        $user = Auth::user();
        if(!is_object($user)){
            $user = (object) ['id' => 'неизвестно','name' => 'неизвестно'];
        }
        $log->user_id = $user->id;
        
        if($request->isMethod('get')){
            $op_type = 1;
        } elseif ($request->isMethod('put')) {
                $op_type = 2;
        } elseif ($request->isMethod('post')) {
            if($request->input('id')){
                $op_type = 2;
            } else {
                $op_type = 3;
            }
        } elseif ($request->isMethod('delete')) {
            $op_type = 4;
        }

        switch ($op_type) {
            case 1:
                $log->type = 'просмотр';
                break;
            case 2:
                $log->type = 'редактирование';
                break;
            case 3:
                $log->type = 'создание';
                break;
            case 4:
                $log->type = 'удаление';
                break;
            
            default:
                $log->type = 'другое';
                break;
        }


        $log->operation = 'Пользователь:' . $user->name; // view,edit,create,delete,other // просмотр, редактирование, создание, удаление, другое
        $log->operation .= '; Тип:' . $log->type;
        $log->operation .= '; Ссылка:' . $request->fullUrl();
        $log->operation .= '; Запрос:' . $request->method();
        $log->operation .= '; Данные:' . json_encode($request->query());
        $log->operation .= '; IP-адрес:' . $request->ip();
        $log->operation .= '; Дата:' . \Carbon\Carbon::now()->format('d/m/Y H:i:s');

        $log->save();

        // $log->notes = '';

        return $next($request);
    }
}
