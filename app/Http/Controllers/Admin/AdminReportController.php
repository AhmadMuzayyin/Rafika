<?php

namespace App\Http\Controllers\Admin;

use toastr;
use App\Models\Bulan;
use App\Models\Jadwal;
use App\Models\SumberDana;
use App\Models\KunciInputan;
use Illuminate\Http\Request;
use Dflydev\DotAccessData\Data;
use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use App\Models\SubKegiatan;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function index()
    {
        if (request()->all() == null) {
            $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
                ->join('anggarans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')

                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('sub_kegiatans.sumber_dana_id', 1)
                ->where('anggarans.pak_id', session()->get('pak_id'))
                ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
                ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
                ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
                ->where('bulan_id', date('n'))
                ->get([
                    'target_kegiatan',
                    'kegiatan_bulan_sebelumnya',
                    'kegiatan_bulan_sekarang',
                    'keuangan_bulan_sebelumnya',
                    'keuangan_bulan_sekarang',
                    'kendala',
                    'nama_sub_kegiatan',
                    'nominal_anggaran',
                    'jadwals.sub_kegiatan_id',
                    'jadwals.id'
                ]);
            $bulan = Bulan::all();
            $batas = date('n');
            $dana = SumberDana::all();
            $danaSelect = 1;
            $selected = Bulan::firstWhere('id', date('n'));
            $aktif = KunciInputan::firstWhere('nama_inputan', 'Laporan RFK');
            return view('admin.report.index', compact('data', 'bulan', 'batas', 'dana', 'selected', 'aktif', 'danaSelect'));
        }
        $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->join('anggarans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('sub_kegiatans.sumber_dana_id', request()->get('dana'))
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
            ->where('bulan_id', request()->get('bulan'))
            ->get([
                'target_kegiatan',
                'kegiatan_bulan_sebelumnya',
                'kegiatan_bulan_sekarang',
                'keuangan_bulan_sebelumnya',
                'keuangan_bulan_sekarang',
                'kendala',
                'nama_sub_kegiatan',
                'nominal_anggaran',
                'jadwals.sub_kegiatan_id',
                'jadwals.id'
            ]);
        $bulan = Bulan::all();
        $batas = date('n');
        $dana = SumberDana::all();
        $danaSelect = request()->get('dana');
        $selected = Bulan::firstWhere('id', request()->get('bulan'));
        $aktif = KunciInputan::firstWhere('nama_inputan', 'Laporan RFK');
        return view('admin.report.index', compact('data', 'bulan', 'batas', 'dana', 'selected', 'aktif', 'danaSelect'));
    }

    public function rekapitulasi()
    {
        $bulan = Bulan::all();
        $dana = SumberDana::all();
        $selected = request()->get('bulan') ?? 1;
        $selectedDana = request()->get('dana') ?? 1;
        $skpdSelect = request()->get('skpd') ?? 1;
        $data = [];
        if (request()->get('skpd') && request()->get('skpd') != 'all') {
            $data = Jadwal::join('bulans', 'bulans.id', '=', 'jadwals.bulan_id')
                ->join('anggarans', 'jadwals.sub_kegiatan_id', 'anggarans.sub_kegiatan_id')
                ->join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
                ->join('users', 'sub_kegiatans.user_id', '=', 'users.id')
                ->where('anggarans.pak_id', session()->get('pak_id'))
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
                ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
                ->where('sub_kegiatans.sumber_dana_id', $selectedDana)
                ->where('jadwals.bulan_id', $selected)
                ->where('users.kode_skpd', $skpdSelect)
                ->get();
        } else {
            $data = Jadwal::join('bulans', 'bulans.id', '=', 'jadwals.bulan_id')
                ->join('anggarans', 'jadwals.sub_kegiatan_id', 'anggarans.sub_kegiatan_id')
                ->join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
                ->join('users', 'sub_kegiatans.user_id', '=', 'users.id')
                ->where('anggarans.pak_id', session()->get('pak_id'))
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
                ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
                ->where('sub_kegiatans.sumber_dana_id', $selectedDana)
                ->where('jadwals.bulan_id', $selected)
                ->get();
        }
        $anggaran = 0;
        $jml_keuangan = 0;
        $tabel = [];
        $rekap = [];
        foreach ($data->groupBy('sub_kegiatan_id') as $key => $value) {
            $anggaran += Anggaran::where('pak_id', session()->get('pak_id'))
                ->where('sub_kegiatan_id', $key)
                ->where('pelaksanaan', session()->get('pelaksanaan'))
                ->get()->sum('nominal_anggaran');

            $jml_keuangan += Jadwal::where('sub_kegiatan_id', $key)
                ->where('status', 1)
                ->where('pelaksanaan', session()->get('pelaksanaan'))
                ->get()->sum('keuangan_bulan_sekarang');
            $rekap = [
                'jml_paket' => SubKegiatan::where('pak_id', session()->get('pak_id'))
                    ->get()->count('id'),
                'anggaran' => $anggaran,
                'jml_kegiatan' => Jadwal::where('sub_kegiatan_id', $key)
                    ->where('status', 1)
                    ->where('pelaksanaan', session()->get('pelaksanaan'))
                    ->get()->sum('kegiatan_bulan_sekarang'),
                'target_kegiatan' => Jadwal::where('sub_kegiatan_id', $key)
                    ->where('pelaksanaan', session()->get('pelaksanaan'))
                    ->get()->sum('target_kegiatan'),
                'jml_keuangan' => $jml_keuangan,
            ];
            $tabel = $data->groupBy('bulan_id');
        }
        return view('admin.rekap.index', compact('tabel', 'rekap', 'anggaran', 'bulan', 'dana', 'selected', 'selectedDana', 'skpdSelect'));
    }
}
