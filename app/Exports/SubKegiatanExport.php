<?php

namespace App\Exports;

use App\Models\SubKegiatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubKegiatanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'SKPD',
            'No Rekening',
            'Nama Sub Kegiatan',
            'Kegiatan',
            'Sumber Dana',
            'Pengadaan',
            'Pelaksanaan',
            'DAU',
            'DAK',
            'DBHC',
            'Program Bupati',
            'Nominal Anggaran',
            'Pelaksanaan Anggaran',
            'Tahun Anggaran'
        ];
    }
    public function collection()
    {
        return SubKegiatan::join('users', 'sub_kegiatans.user_id', '=', 'users.id')
            ->join('anggarans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
            ->join('paks', 'paks.id', '=', 'sub_kegiatans.pak_id')
            ->join('sumber_danas', 'sub_kegiatans.sumber_dana_id', '=', 'sumber_danas.id')
            ->join('pengadaans', 'sub_kegiatans.pengadaan_id', '=', 'pengadaans.id')
            ->join('pelaksanaans', 'sub_kegiatans.pelaksanaan_id', '=', 'pelaksanaans.id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->get();
    }
    public function map($row): array
    {
        return [
            $row->nama_skpd,
            $row->rekening,
            $row->nama_sub_kegiatan,
            $row->bentuk_kegiatan,
            $row->nama_sumber_dana,
            $row->nama_pengadaan,
            $row->nama_pelaksanaan,
            $row->dau == 1 ? 'Ya' : 'Tidak',
            $row->dak == 1 ? 'Ya' : 'Tidak',
            $row->dbhc == 1 ? 'Ya' : 'Tidak',
            $row->nama_kpa,
            $row->program_bupati,
            $row->nominal_anggaran,
            session()->get('pelaksanaan') == 1 ? 'Sesudah Perubahan Anggaran' : 'Sebelum Perubahan Anggaran',
            $row->pak->tahun_anggaran
        ];
    }
}
