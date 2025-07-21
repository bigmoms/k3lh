<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class McuImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new McuRecordImport(), // Hanya sheet pertama (index 0)
        ];
    }
}
