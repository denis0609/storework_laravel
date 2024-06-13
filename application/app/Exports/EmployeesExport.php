<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
            'ID',
            'LAST NAME',
            'FIRST NAME',
            "AGE",
            'GENDER',
            'CIVIL STATUS',
            'MOBILE NUMBER',
            'EMAIL ADDRESS',
            'EMPLOYMENT TYPE',
            'EMPLOYMENT STATUS',
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
}
