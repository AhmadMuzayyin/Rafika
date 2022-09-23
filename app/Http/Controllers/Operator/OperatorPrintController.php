<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Pak;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;

class OperatorPrintController extends Controller
{
    public function dau()
    {
        $print = 'dau';
        $dana = 'DAU';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })
            ->where('user_id', Auth()->user()->id)
            ->where('dau', true)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function dak()
    {
        $print = 'dak';
        $dana = 'DAK';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })
            ->where('user_id', Auth()->user()->id)
            ->where('dak', true)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function dbhc()
    {
        $print = 'dbhc';
        $dana = 'DBHC';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })
            ->where('user_id', Auth()->user()->id)
            ->where('dbhc', true)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function kontruksi()
    {
        $print = 'pengadaan';
        $dana = 'KONTRUKSI';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })
            ->where('user_id', Auth()->user()->id)
            ->where('pengadaan_id', 1)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function barang()
    {
        $print = 'pengadaan';
        $dana = 'BARANG';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })
            ->where('user_id', Auth()->user()->id)
            ->where('pengadaan_id', 2)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function konsultansi()
    {
        $print = 'pengadaan';
        $dana = 'KONSULTANSI';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })
            ->where('user_id', Auth()->user()->id)
            ->where('pengadaan_id', 3)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function lainnya()
    {
        $print = 'pengadaan';
        $dana = 'JASA LAINNYA';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })
            ->where('user_id', Auth()->user()->id)
            ->where('pengadaan_id', 4)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function prioritas()
    {
        $print = 'pengadaan';
        $dana = 'PROGRAM PRIORITAS BUPATI';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('anggaran', function ($q) {
            return $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })
            ->where('user_id', Auth()->user()->id)
            ->where('program_bupati', 'Ya')
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.print.index', compact('print', 'dana', 'thn', 'data'));
    }
    public function kendala()
    {
        $print = 'kendala';
        $dana = 'KENDALA';
        $thn = Pak::firstWhere('id', session()->get('pak_id'));
        $data = SubKegiatan::whereHas('jadwal', function ($q) {
            $q->where('kendala', '!=', null);
        })->with(["anggaran", "jadwal"])
            ->where('user_id', Auth()->user()->id)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.print.index', compact('print', 'dana', 'thn', 'data'));
    }
}
