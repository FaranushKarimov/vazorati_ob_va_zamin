<?php

namespace App\Imports;

use App\Qcordinate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

HeadingRowFormatter::default('none');

class QcordinatesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        if(empty($row['hydropost_id'])) return null;
        
        return new Qcordinate([
            // 'name'     => $row[0],
            // 'email'    => $row[1], 
            'hydropost_id'  => $row['hydropost_id'],
            'height' => $row['height'],
            'flow'    => $row['flow'],
        ]);
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }
}
