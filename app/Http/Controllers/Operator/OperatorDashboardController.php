<?php

namespace App\Http\Controllers\Operator;

use App\Models\Pengadaan;
use App\Models\SumberDana;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bulan;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;

class OperatorDashboardController extends Controller
{
    public function index()
    {
        $data = SubKegiatan::where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get();
        $jml_sub = SubKegiatan::where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get()->count();
        $jml_dana = SumberDana::all();
        $jml_pengadaan = Pengadaan::all();
        $report = SubKegiatan::join('jadwals', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')->where('sub_kegiatans.user_id', Auth()->user()->id)->where('sub_kegiatans.pak_id', session()->get('pak_id'))->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))->where('jadwals.bulan_id', now()->format('n'))->where('jadwals.status', 1)->get();
        $jml_sub_lapor = 0;
        foreach ($data as $value) {
            $jml_dana_pake = $value->distinct()->count('sumber_dana_id');
            $jml_png_pake = $value->distinct()->count('pengadaan_id');
        }
        return view('operator.Dashboard', [
            'jml_sub' => $jml_sub,
            'jml_dana' => $jml_dana->count(),
            'jml_dana_pake' => $jml_dana_pake ?? 0,
            'jml_pengadaan' => $jml_pengadaan->count(),
            'jml_png_pake' => $jml_png_pake ?? 0,
            'jml_sub_lapor' => $report->count() ?? $jml_sub_lapor
        ]);
    }
    public function kegiatan()
    {
        $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->where('user_id', Auth()->user()->id)
            ->where('pak_id', session()->get('pak_id'))
            ->where('pelaksanaan', session()->get('pelaksanaan'))
            ->get()
            ->groupBy('bulan_id');
        $TargetKegiatan = [];
        $RealisasiKegiatan = [];
        $totalKegiatan = 0;
        foreach ($data as $item) {
            $totalKegiatan += $item->avg('target_kegiatan');
            array_push($TargetKegiatan, $item->avg('target_kegiatan'));
            array_push($RealisasiKegiatan, $item->avg('kegiatan_bulan_sekarang'));
        }
        $Tkegiatan = [];
        $RKegiatan = [];
        foreach ($TargetKegiatan as $tkg) {
            array_push($Tkegiatan, intval($tkg));
        }
        foreach ($RealisasiKegiatan as $rkg) {
            array_push($RKegiatan, intval($rkg));
        }
        $bulan = Bulan::all();
        $bl = [];
        foreach ($bulan as $val) {
            array_push($bl, $val->nama_bulan);
        }
        return response()->json([
            'targetkegiatan' => $Tkegiatan,
            'realisasiKegiatan' => $RKegiatan,
            'bulan' => $bl
        ], 200);
    }
    public function keuangan()
    {
        $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->where('user_id', Auth()->user()->id)
            ->where('pak_id', session()->get('pak_id'))
            ->where('pelaksanaan', session()->get('pelaksanaan'))
            ->get()
            ->groupBy('bulan_id');
        $TargetKeuangan = [];
        $RealisasiKeuangan = [];
        foreach ($data as $item) {
            array_push($TargetKeuangan, $item->sum('target_keuangan'));
            array_push($RealisasiKeuangan, $item->sum('keuangan_bulan_sekarang'));
        }
        $TKeuangan = [];
        $RKeuangan = [];
        foreach ($TargetKeuangan as $key => $tku) {
            if ($key > 0) {
                array_push($TKeuangan, $tku + $TKeuangan[$key - 1]);
            } else {
                array_push($TKeuangan, $tku);
            }
        }
        foreach ($RealisasiKeuangan as $ke => $rku) {
            if ($ke > 0) {
                array_push($RKeuangan, $rku + $RKeuangan[$ke - 1]);
            } else {
                array_push($RKeuangan, $rku);
            }
        }
        $bulan = Bulan::all();
        $bl = [];
        foreach ($bulan as $val) {
            array_push($bl, $val->nama_bulan);
        }
        return response()->json([
            'target' => $TKeuangan,
            'realisasi' => $RKeuangan,
            'bulan' => $bl
        ], 200);
    }
}
