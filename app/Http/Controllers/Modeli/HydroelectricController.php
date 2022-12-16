<?php

namespace App\Http\Controllers\Modeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hydroelectric;
use App\Exports\ExcelExport;
use Excel;
class HydroelectricController extends Controller
{
    //
    public function index() {
        $columns = $this->getColumns();

        $hydroelectrics = Hydroelectric::orderBy('id', 'desc')->paginate(20);
        return view("modeli.hydroelectric", [
            "hydroelectrics" => $hydroelectrics,
            "columns" => $columns,
    ]);
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
            'date'=>'required',
            'river'=>'required',
            'height'=>'required',
            'consumption'=>'nullable',
            'idle_reset'=>'nullable',
            'maximum_level' => 'nullable',
            'minimum_level' => 'nullable',
            'power_generation' => 'nullable',
            'volume' => 'nullable'
        ]);
        Hydroelectric::create($data);
        return redirect()->back()->with('message', 'Добавлен!');
    }

    public function edit($id)
    {
        $columns = $this->getColumns();
        $hydroelectric = Hydroelectric::findOrFail($id);
        return view('modeli.hydroelectric_edit', compact('hydroelectric', 'id', 'columns'));
    }

   

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name_ru'=>'required',
            'name_tj'=>'required',
            'name_en'=>'nullable',
            'state'=>'required',
            'town'=>'nullable',
            'hydroelectric_code'=>'required',
            'date'=>'required',
            'river'=>'required',
            'height'=>'required',
            'consumption'=>'nullable',
            'idle_reset'=>'nullable',
            'maximum_level' => 'nullable',
            'minimum_level' => 'nullable',
            'power_generation' => 'nullable',
            'volume' => 'nullable',
        ]);

        $hydroelectric = Hydroelectric::findOrFail($id);
        $hydroelectric->fill($data)->save();

        return redirect()->route('modeli.hydroelectric.index')->with('message', 'Сохранено!');
    
    }

    public function destroy($id)
    {
        $hydroelectric = Hydroelectric::findOrFail($id);
        $hydroelectric->delete();

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
            "date" => "Дата эксплуатации",
            "river" => "Река (источник воды)",
            "height" => "Высота плотины (метр)",
            "consumption" => "Расход воды через турбины(кубический метр в час)",
            "idle_reset" => "Холостой сброс(кубический метр в час)",
            "maximum_level" => "Максимальный уровень верхнего бьефа (метр)",
            "minimum_level" => "Минимальный уровень верхнего бьефа(метр)",
            "power_generation" => "Выработка электроэнергии(мегаВт/год)",
            "volume" => "Объем воды водохранилища (в кубическом метре)",
            "created_at" => "Дата создания записи",
            "updated_at" => "Дата изменения записи",
        ];
    }
}
