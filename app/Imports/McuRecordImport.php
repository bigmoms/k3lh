<?php

namespace App\Imports;

use App\Models\McuRecord;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class McuRecordImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        $mapped = [];

        $columns = $this->generateExcelColumns('A', 'EH');
        foreach ($columns as $index => $excelColumn) {
            $columnKey = strtolower($excelColumn);
            $mapped[$columnKey] = $row[$index] ?? null;
        }

        return new McuRecord($mapped);
    }

    public function startRow(): int
    {
        return 4;
    }

    private function generateExcelColumns(string $start, string $end): array
    {
        $columns = [];
        $current = $start;

        while (true) {
            $columns[] = $current;
            if ($current === $end) break;
            $current = $this->nextExcelColumn($current);
        }

        return $columns;
    }

    private function nextExcelColumn(string $col): string
    {
        $length = strlen($col);
        for ($i = $length - 1; $i >= 0; $i--) {
            if ($col[$i] !== 'Z') {
                $col[$i] = chr(ord($col[$i]) + 1);
                for ($j = $i + 1; $j < $length; $j++) {
                    $col[$j] = 'A';
                }
                return $col;
            }
        }
        return 'A' . str_repeat('A', $length);
    }
}
