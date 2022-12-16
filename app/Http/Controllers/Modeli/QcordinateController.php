<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Qcordinate;

use App\WaterBasinZone;
use App\Canal;
use App\Hydropost;

use App\Imports\QcordinatesImport;
use Excel;
use Auth;

class QcordinateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = array(
            "id" => "Код уровня воды",
            "hydropost_id" => "Название гидропоста",
            "height" => "Уровень (м)",
            "flow" => "Расход (л/с)",
            "created_at" => "Время создания записи",
            "updated_at" => "Время обновления записи",
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

        $months = array(
            '01' => 'Январь',
            '02' => 'Февраль',
            '03' => 'Март',
            '04' => 'Апрель',
            '05' => 'Май',
            '06' => 'Июнь',
            '07' => 'Июль',
            '08' => 'Август',
            '09' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь',
        );

        $user = Auth::user();

        $basin_canal_ids = Canal::where('basin_id','=',$user->basin_id)->pluck('id')->toArray();
        $basin_hyd_ids = Hydropost::whereIn('canal_id',$basin_canal_ids)->pluck('id')->toArray();
        $hyd_ids = array();

        $req_basin_id = $request->input('basin_id');
        $req_canal_id = $request->input('canal_id');
        $req_hyd_id = $request->input('hydropost_id');
        $req_year = $request->input('year');
        $req_month = $request->input('month');

        
        if(!empty($req_hyd_id)) {
            $hyd_ids = array($req_hyd_id);
        } else if($req_canal_id){
            $hyd_ids = Hydropost::where('canal_id','=',$req_canal_id)->pluck('id')->toArray();
        } else if($req_basin_id){
            $canal_ids = Canal::where('basin_id','=',$req_basin_id)->pluck('id')->toArray();
            $hyd_ids = Hydropost::whereIn('canal_id', $canal_ids)->pluck('id')->toArray();
        } 

        $qcordinates = Qcordinate::orderBy('hydropost_id', 'asc')->orderBy('height', 'asc');
        $basins = WaterBasinZone::orderBy('id','asc')->get(['id','name_tj','name_ru','name_en']);
        $hydroposts = Hydropost::orderBy('id','asc');

        if(!empty($req_year)) {
            $qcordinates = $qcordinates->whereYear('created_at','=',$req_year);
        }

        if(!empty($req_month)) {
            $qcordinates = $qcordinates->whereMonth('created_at','=',$req_month);
        }

        if($user->role && $user->role->title =='super-admin'){
            if($req_basin_id){
                $qcordinates = $qcordinates->whereIn('hydropost_id', $hyd_ids);
            }
        } else {
            $qcordinates = $qcordinates->whereIn('hydropost_id', array_intersect($basin_hyd_ids,$hyd_ids));
            // $hydroposts = $hydroposts->whereIn('id', array_intersect($basin_hyd_ids,$hyd_ids));
            $basins = $basins->where('id','=',$user->basin_id);
        }
        
        $hydroposts = $hydroposts->get();
        $qcordinates = $qcordinates->paginate(20);

        $qcordinates->appends($request->all());

        return view("modeli.qcordinate", [
            'qcordinates' => $qcordinates,
            'basins' => $basins,
            'hydroposts' => $hydroposts,
            'years' => $years,
            'months' => $months,
            'columns' => $columns,
        ]);
    }

    /**
     * Import from excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function importExcel(Request $request)
    {
        $this->validate($request, [
            'excel_file'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('excel_file');

        Excel::import(new QcordinatesImport, $path);
        return back()->with('message', 'Импорт успешно.');
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
            'hydropost_id' => 'required',
            'height'=>'required',
            'flow'=>'required',
        ]);
        Qcordinate::create($data);
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
        $qcordinate = Qcordinate::findOrFail($id);

        return view('modeli.qcordinate_edit', compact('qcordinate', 'id'));
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
            'hydropost_id' => 'required',
            'height'=>'required',
            'flow'=>'required',
        ]);

        $qcordinate = Qcordinate::findOrFail($id);
        $qcordinate->fill($data)->save();

        return redirect()->route('modeli.qcordinate.index')->with('message', 'Сохранено!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qcordinate = Qcordinate::findOrFail($id);
        $qcordinate->delete();

        return redirect()->back()->with('message', 'Удалена!');
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
     * Return ajax hydropost names
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxHydropost(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'canal_id' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $hyds = Hydropost::orderBy('id')->where('canal_id','=',$request->get('canal_id'))->get(['id','canal_id','name_tj','name_ru','name_en']);
        return response()->json($hyds);
    }
}
