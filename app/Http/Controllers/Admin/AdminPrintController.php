<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pak;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;

class AdminPrintController extends Controller
{
    public function dau()
    {
        $print = 'dau';
        $dana = 'DAU';
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('dau', true)
            ->where('pak_id', session()->get('pak_id'))
            ->get()->groupBy('user_id');
        return view('admin.print.index', compact('print', 'dana', 'data'));
    }
    public function dak()
    {
        $print = 'dak';
        $dana = 'DAK';
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('dak', true)
            ->where('pak_id', session()->get('pak_id'))
            ->get()->groupBy('user_id');
        return view('admin.print.index', compact('print', 'dana', 'data'));
    }
    public function dbhc()
    {
        $print = 'dbhc';
        $dana = 'DBHC';
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('dbhc', true)
            ->where('pak_id', session()->get('pak_id'))
            ->get()->groupBy('user_id');
        return view('admin.print.index', compact('print', 'dana', 'data'));
    }
    public function kontruksi()
    {
        $print = 'pengadaan';
        $dana = 'KONTRUKSI';
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('pengadaan_id', 1)
            ->where('pak_id', session()->get('pak_id'))
            ->get()->groupBy('user_id');
        return view('admin.print.index', compact('print', 'dana', 'data'));
    }
    public function barang()
    {
        $print = 'pengadaan';
        $dana = 'BARANG';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('pengadaan_id', 2)
            ->where('pak_id', session()->get('pak_id'))
            ->get()->groupBy('user_id');
        return view('admin.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function konsultansi()
    {
        $print = 'pengadaan';
        $dana = 'KONSULTANSI';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('pengadaan_id', 3)
            ->where('pak_id', session()->get('pak_id'))
            ->get()->groupBy('user_id');
        return view('admin.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function lainnya()
    {
        $print = 'pengadaan';
        $dana = 'JASA LAINNYA';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('pengadaan_id', 4)
            ->where('pak_id', session()->get('pak_id'))
            ->get()->groupBy('user_id');
        return view('admin.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function prioritas()
    {
        $print = 'pengadaan';
        $dana = 'PROGRAM PRIORITAS BUPATI';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('program_bupati', 'Ya')
            ->where('pak_id', session()->get('pak_id'))
            ->get()->groupBy('user_id');
        return view('admin.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function kendala()
    {
        $print = 'kendala';
        $dana = 'KENDALA';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('jadwal', function ($q) {
            $q->where('kendala', '!=', null);
        })->with(["anggaran", "jadwal"])
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('admin.print.index', compact('print', 'dana', 'thn', 'data'));
    }
}
