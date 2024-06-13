<?php

namespace App\Exports;

use App\Models\User; // Adjust the model import as per your setup
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class AccountsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
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
            'EMPLOYEE NAME',
            'EMAIL',
            'ACCOUNT TYPE',
        ];
    }

    public function map($row): array
    {
        $accountType = $row->acc_type == 2 ? 'Admin' : 'Employee';

        return [
            $row->name,
            $row->email,
            $accountType,
        ];
    }
}
