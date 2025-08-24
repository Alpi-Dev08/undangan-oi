<?php

namespace App\Exports;

use App\Models\Klinik\Drug;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DrugsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Drug::with('unit')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Unit',
            'Name',
            'Price',
            'Stock',
            'Created At',
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->unit ? $row->unit->name : '-',
            $row->name,
            $row->price,
            $row->stock,
            $row->created_at,
        ];
    }
}
