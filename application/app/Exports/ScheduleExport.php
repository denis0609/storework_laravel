<?php

namespace App\Exports;

use App\Models\Schedule; // Replace with your actual model class
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScheduleExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'IDNO',
            'EMPLOYEE',
            'START TIME',
            'OFF TIME',
            'DATE FROM',
            'DATE TO',
            'HOURS',
            'RESTDAY',
            'STATUS',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A:I')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:I')->getAlignment()->setWrapText(true);
        // Add more styling as needed
    }
}
