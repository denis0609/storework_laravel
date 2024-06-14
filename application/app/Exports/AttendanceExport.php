<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AttendanceExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Employee Name',
            'Time In',
            'Time Out',
            'Break Time In',
            'Break Time Out',
            'Launch Time In',
            'Launch Time Out',
            'Total Hours'
        ];
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getStyle('A1:N1')->getFont()->setBold(true);
                $sheet->getStyle('A1:N' . ($this->query->count() + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A1:N' . ($this->query->count() + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             $sheet = $event->sheet->getDelegate();
    //             $sheet->getStyle('A1:I1')->getFont()->setBold(true);

    //             // Center align all columns
    //             $sheet->getStyle('A:I')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    //             // Set auto filter for the data
    //             // $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
    //         },
    //     ];
    // }
}
