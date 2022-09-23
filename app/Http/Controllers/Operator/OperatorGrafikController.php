<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorGrafikController extends Controller
{
    public function indexPengadaan()
    {
        return view('operator.grafik.pengadaan');
    }
    public function pengadaanData()
    {
        $data = SubKegiatan::join('pengadaans', 'pengadaans.id', '=', 'sub_kegiatans.pengadaan_id')
            ->where('user_id', Auth()->user()->id)
            ->where('pak_id', session()->get('pak_id'))
            ->get()
            ->groupBy('nama_pengadaan');
        return response()->json([
            'data' => $data
        ], 200);
    }

    // For Grafik Sebaran
    public function indexSebaran()
    {
        return view('operator.grafik.sebaran');
    }
    public function sebaranData()
    {
        $data = SubKegiatan::join('lokasis', 'sub_kegiatans.id', '=', 'lokasis.sub_kegiatan_id')
            ->where('user_id', Auth()->user()->id)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return response()->json([
            'data' => $data
        ], 200);
    }

    // For Grafik Sumber Dana
    public function indexsumberDana()
    {
        return view('operator.grafik.sumber_dana');
    }
    public function sumberDanaData()
    {
        $data = SubKegiatan::join('sumber_danas', 'sumber_danas.id', '=', 'sub_kegiatans.sumber_dana_id')
            ->where('user_id', Auth()->user()->id)
            ->where('pak_id', session()->get('pak_id'))
            ->get()
            ->groupBy('nama_sumber_dana');
        return response()->json([
            'data' => $data
        ], 200);
    }

    // For Grafik Pelaksanaan
    public function indexPelaksanaan()
    {
        return view('operator.grafik.pelaksanaan');
    }
    public function pelaksanaanData()
    {
        $data = SubKegiatan::join('pelaksanaans', 'pelaksanaans.id', '=', 'sub_kegiatans.pelaksanaan_id')
            ->where('user_id', Auth()->user()->id)
            ->where('pak_id', session()->get('pak_id'))
            ->get()
            ->groupBy('nama_pelaksanaan');
        return response()->json([
            'data' => $data
        ], 200);
    }

    // For Laporan
    public function laporan()
    {
        $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->where('sub_kegiatans.user_id', Auth()->user()->id)
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('pelaksanaan', session()->get('pelaksanaan'))
            ->get()
            ->groupBy('bulan_id');
        return view('operator.grafik.laporan', compact('data'));
    }
}
