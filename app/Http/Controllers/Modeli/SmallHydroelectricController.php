<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SmallHydroelectric;
use App\Exports\ExcelExport;
use Excel;

class SmallHydroelectricController extends Controller
{
    //
    public function index() {
        $columns = $this->getColumns();
        $arr_all = [
            [
                $columns['id'],
                $columns['name_ru'],
                $columns['name_tj'],
                $columns['name_en'],
                $columns['state'],
                $columns['town'],
                $columns['hydroelectric_code'],
                $columns['river'],
                $columns['power_generation'],
                $columns['created_at'],
                $columns['updated_at'],
            ]
        ];
        $export = new ExcelExport($arr_all);

        $smallhydroelectrics = SmallHydroelectric::orderBy('id', 'desc')->paginate(20);
        return view("modeli.smallhydroelectric", [
            "smallhydroelectrics" => $smallhydroelectrics,
            "columns" => $columns,
            "export" => Excel::download($export, 'ExcelExport.xlsx')
        ]);
    }

    public function ExportExcel(){
        $columns = $this->getColumns();
        $arr_all = [
            [
                $columns['id'],
                $columns['name_ru'],
                $columns['name_tj'],
                $columns['name_en'],
                $columns['state'],
                $columns['town'],
                $columns['hydroelectric_code'],
                $columns['river'],
                $columns['power_generation'],
                $columns['created_at'],
                $columns['updated_at'],
            ]
        ];
        $export = new ExcelExport($arr_all);
        return Excel::download($export, 'ExcelExport.xlsx');
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name_ru'=>'required',
            'name_tj'=>'required',
            'name_en'=>'nullable',
            'state'=>'required',
            'town'=>'required',
            'hydroelectric_code'=>'required',
            'river'=>'required',
            'power_generation' => 'nullable',
        ]);
        SmallHydroelectric::create($data);
        return redirect()->back()->with('message', 'Добавлен!');
    }

    public function edit($id)
    {
        $columns = $this->getColumns();
        $smallhydroelectric = SmallHydroelectric::findOrFail($id);
        return view('modeli.smallhydroelectric_edit', compact('smallhydroelectric', 'id', 'columns'));
    }

    public function destroy($id)
    {
        $smallhydroelectric = SmallHydroelectric::findOrFail($id);
        $smallhydroelectric->delete();

        return redirect()->back()->with('message', 'Удалена!');
    }

    private function getColumns() {
        return [
            "id" => "Код ирригации",
            "name_ru" => "Название ГЭС на русском языке",
            "name_tj" => "Название ГЭС на таджикском языке",
            "name_en" => "Название ГЭС на английском языке",
            "state" => "Название области",
            "town" => "Название района",
            "hydroelectric_code" => "Код ГЭС",
            "river" => "Река (источник воды)",
            "power_generation" => "Выработка электроэнергии(мегаВт/год)",
            "created_at" => "Дата создания записи",
            "updated_at" => "Дата изменения записи",
        ];
    }
}
