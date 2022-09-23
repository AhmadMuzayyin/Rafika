<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::where('isAdmin', false)->get();
    }
    public function headings(): array
    {
        return [
            'Username',
            'Nama SKPD',
            'Nomor Telp Kantor',
            'Alamat Kantor',
            'Nama Operator',
            'Alamat Operator',
            'Nomor Telp Operator',
            'Nama KPA',
            'Level'
        ];
    }
    public function map($row): array
    {
        return [
            $row->username,
            $row->nama_skpd,
            $row->nomor_tlp_kantor,
            $row->alamat_kantor,
            $row->nama_operator,
            $row->alamat_operator,
            $row->nomor_tlp_operator,
            $row->nama_kpa,
            $row->isAdmin == 0 ? 'Operator' : 'Admin',
        ];
    }
}
