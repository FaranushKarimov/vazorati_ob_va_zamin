<?php 

namespace App\Exports;

// use App\Invoice;
use Maatwebsite\Excel\Concerns\FromArray;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithDrawings;
// use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithStartRow;

// use Maatwebsite\Excel\Concerns\WithEvents;

class ExcelExport implements FromArray,ShouldAutoSize
{
	protected $columns;
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        /*return [
            [1, 2, 3],
            [4, 5, 6]
        ];*/

        return $this->data;
    }

    /*public function headings(): array
    {
        return [
                '#',
                $this->columns['wua_id'],
                $this->columns['wua_name'],
                $this->columns['ghalla'],
                $this->columns['pakhta'],
                $this->columns['sabzavot'],
                $this->columns['poliziho'],
                $this->columns['kartoshka'],
                $this->columns['tamoku_sit_zir_chorvo'],
                $this->columns['beda'],
                $this->columns['sholi'],
                $this->columns['boghho'],
                $this->columns['jmaka_don_hos_1'],
                $this->columns['jmaka_don_hos_2'],
                $this->columns['jmaka_silos_hos_2'],
                $this->columns['total_area'],
                $this->columns['water_vol'],
                $this->columns['contract_date'],
        ];
    }*/

    /*public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('ИСУИ');
        $drawing->setDescription('Агентство мелиорации и ирригации при Правительстве Республики Таджикистан');
        $drawing->setPath(public_path('/img/gerb.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('H3');

        return $drawing;
    }*/

    /*public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('images/logo.png'));
                $drawing->setCoordinates('D1');

                $drawing->setWorksheet($event->sheet->getDelegate());
            },
        ];
    }*/
}

