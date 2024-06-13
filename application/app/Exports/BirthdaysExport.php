<?php

namespace App\Exports;

use App\Models\YourModel; // Replace with your actual model class
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class BirthdaysExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
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
            'ID',
            'EMPLOYEE NAME',
            'DEPARTMENT',
            'POSITION',
            'BIRTHDAY',
            'MOBILE NUMBER',
        ];
    }

    public function map($row): array
    {
        return [
            $row->idno,
            $row->lastname . ' ' . $row->firstname . ' ' . $row->mi,
            $row->department,
            $row->jobposition,
            $row->birthday,
            $row->mobileno,
        ];
    }
}
