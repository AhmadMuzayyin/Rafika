<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use App\Models\Bulan;
use App\Models\Jadwal;
use App\Models\Pengadaan;
use App\Models\SubKegiatan;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminGrafikController extends Controller
{
    public function indexPengadaan()
    {
        return view('admin.grafik.pengadaan');
    }
    public function pengadaanData()
    {
        $data = SubKegiatan::join('pengadaans', 'pengadaans.id', '=', 'sub_kegiatans.pengadaan_id')
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
        return view('admin.grafik.sebaran');
    }
    public function sebaranData()
    {
        $data = SubKegiatan::join('lokasis', 'sub_kegiatans.id', '=', 'lokasis.sub_kegiatan_id')
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        $kec = [];
        foreach ($data->groupBy('kecamatan') as $key => $value) {
            array_push($kec, [
                'label' => $key,
                'data' => $value->count()
            ]);
        }
        return response()->json([
            'data' => $data,
            'kec' => $kec
        ], 200);
    }

    // For Grafik Sumber Dana
    public function indexsumberDana()
    {
        return view('admin.grafik.sumber_dana');
    }
    public function sumberDanaData()
    {
        $data = SubKegiatan::join('sumber_danas', 'sumber_danas.id', '=', 'sub_kegiatans.sumber_dana_id')
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
        return view('admin.grafik.pelaksanaan');
    }
    public function pelaksanaanData()
    {
        $data = SubKegiatan::join('pelaksanaans', 'pelaksanaans.id', '=', 'sub_kegiatans.pelaksanaan_id')
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
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('pelaksanaan', session()->get('pelaksanaan'))
            ->get()
            ->groupBy('bulan_id');
        return view('admin.grafik.laporan', compact('data'));
    }

    // For realisasi admin
    public function rfk($bulan)
    {
        $targetKegiatan = 0;
        $anggaran = 0;
        // Target Kegiatan
        $targetKegiatan = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('pelaksanaan', session()->get('pelaksanaan'))
            ->get()->sum('target_kegiatan');
        // Anggaran
        $anggaran = Anggaran::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->get()->sum('nominal_anggaran');
        // Data
        $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->join('anggarans', 'anggarans.sub_kegiatan_id', '=', 'jadwals.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
            ->where('jadwals.bulan_id', $bulan)
            ->get();
        $rfk = [
            'kegiatan' => [
                'target' => $data->sum('target_kegiatan') ? round($data->sum('target_kegiatan') / $targetKegiatan * 100, 2) : 0,
                'opd' => $data->count('user_id') ?? 0,
                'realisasi' => $data->sum('kegiatan_bulan_sekarang') ? round($data->sum('kegiatan_bulan_sekarang') / $targetKegiatan * 100, 2) : 0,
            ],
            'keuangan' => [
                'nominal_target' => $data->sum('target_keuangan') ?? 0,
                'nominal_realisasi' => $data->sum('keuangan_bulan_sekarang') ?? 0,
                'persentase_target' => $data->sum('target_keuangan') ? round($data->sum('target_keuangan') / $anggaran * 100, 2) : 0,
                'persentase_realisasi' => $data->sum('keuangan_bulan_sekarang') ? round($data->sum('keuangan_bulan_sekarang') / $anggaran * 100, 2) : 0
            ]
        ];
        return $rfk;
    }
    public function JenisPengadaan($bulan, $pengadaan)
    {
        $targetKegiatan = 0;
        $anggaran = 0;
        // Target Kegiatan
        $targetKegiatan = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('sub_kegiatans.pengadaan_id', $pengadaan)
            ->where('pelaksanaan', session()->get('pelaksanaan'))
            ->get()->sum('target_kegiatan');
        // Anggaran
        $anggaran = Anggaran::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('sub_kegiatans.pengadaan_id', $pengadaan)
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->get()->sum('nominal_anggaran');
        // Data
        $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->join('anggarans', 'anggarans.sub_kegiatan_id', '=', 'jadwals.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('sub_kegiatans.pengadaan_id', $pengadaan)
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
            ->where('jadwals.bulan_id', $bulan)
            ->get();

        $pengadaan = [
            'kegiatan' => [
                'target' => $data->sum('target_kegiatan') ? round($data->sum('target_kegiatan') / $targetKegiatan * 100, 2) : 0,
                'opd' => $data->count('user_id') ?? 0,
                'realisasi' => $data->sum('kegiatan_bulan_sekarang') ? round($data->sum('kegiatan_bulan_sekarang') / $targetKegiatan * 100, 2) : 0,
            ],
            'keuangan' => [
                'nominal_target' => $data->sum('target_keuangan') ?? 0,
                'nominal_realisasi' => $data->sum('keuangan_bulan_sekarang') ?? 0,
                'persentase_target' => $data->sum('target_keuangan') ? round($data->sum('target_keuangan') / $anggaran * 100, 2) : 0,
                'persentase_realisasi' => $data->sum('keuangan_bulan_sekarang') ? round($data->sum('keuangan_bulan_sekarang') / $anggaran * 100, 2) : 0
            ]
        ];
        return $pengadaan;
    }
    public function SumberDana($bulan, $sb)
    {
        $targetKegiatan = 0;
        $anggaran = 0;
        // Target Kegiatan
        $targetKegiatan = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('sub_kegiatans.sumber_dana_id', $sb)
            ->where('pelaksanaan', session()->get('pelaksanaan'))
            ->get()->sum('target_kegiatan');
        // Anggaran
        $anggaran = Anggaran::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('sub_kegiatans.sumber_dana_id', $sb)
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->get()->sum('nominal_anggaran');
        // Data
        $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->join('anggarans', 'anggarans.sub_kegiatan_id', '=', 'jadwals.sub_kegiatan_id')
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('sub_kegiatans.sumber_dana_id', $sb)
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
            ->where('jadwals.bulan_id', $bulan)
            ->get();

        $pengadaan = [
            'kegiatan' => [
                'target' => $data->sum('target_kegiatan') ? round($data->sum('target_kegiatan') / $targetKegiatan * 100, 2) : 0,
                'opd' => $data->count('user_id') ?? 0,
                'realisasi' => $data->sum('kegiatan_bulan_sekarang') ? round($data->sum('kegiatan_bulan_sekarang') / $targetKegiatan * 100, 2) : 0,
            ],
            'keuangan' => [
                'nominal_target' => $data->sum('target_keuangan') ?? 0,
                'nominal_realisasi' => $data->sum('keuangan_bulan_sekarang') ?? 0,
                'persentase_target' => $data->sum('target_keuangan') ? round($data->sum('target_keuangan') / $anggaran * 100, 2) : 0,
                'persentase_realisasi' => $data->sum('keuangan_bulan_sekarang') ? round($data->sum('keuangan_bulan_sekarang') / $anggaran * 100, 2) : 0
            ]
        ];
        return $pengadaan;
    }
    public function realisasi()
    {
        $bulan = Bulan::all();
        $pengadaan = Pengadaan::all();
        $jenisPG = '';
        request()->get('pengadaan') ? $jenisPG = Pengadaan::where('id', request()->get('pengadaan'))->first() : $jenisPG = Pengadaan::first();
        $dana = SumberDana::all();
        $jenisDANA = '';
        request()->get('dana') ? $jenisDANA = SumberDana::where('id', request()->get('dana'))->first() : $jenisDANA = SumberDana::first();
        $selected = 1;
        $bl = request()->get('bulan') ?? 1;
        $png = request()->get('pengadaan') ?? 1;
        $sbdn = request()->get('dana') ?? 1;
        $rfk = $this->rfk($bl);
        $pgn = $this->JenisPengadaan($bl, $png);
        $sumber = $this->SumberDana($bl, $sbdn);
        return view('admin.grafik.realisasi', compact('bulan', 'rfk', 'pgn', 'sumber', 'selected', 'pengadaan', 'jenisPG', 'dana', 'jenisDANA'));
    }
    // For Grafik Ranking
    public function rankingData()
    {
        $skpd = request()->get('skpd') ?? 1;
        $dana = request()->get('dana') ?? 1;
        $bulan = request()->get('bulan') ?? 1;
        $filter = request()->get('filter') ?? 1;
        $data = [];
        $anggaran = [];
        if ($skpd == 0) {
            $data = SubKegiatan::join('jadwals', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
                ->join('users', 'sub_kegiatans.user_id', '=', 'users.id')
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
                ->where('sumber_dana_id', $dana)
                ->where('status', true)
                ->get();
            $anggaran = Anggaran::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
                ->join('users', 'sub_kegiatans.user_id', '=', 'users.id')
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('sub_kegiatans.sumber_dana_id', $dana)
                ->where('anggarans.pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'))
                ->get()->toArray();
        } else {
            $data = SubKegiatan::join('jadwals', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
                ->join('users', 'sub_kegiatans.user_id', '=', 'users.id')
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
                ->where('users.kode_skpd', $skpd)
                ->where('sumber_dana_id', $dana)
                ->where('status', true)
                ->get();
            $anggaran = Anggaran::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
                ->join('users', 'sub_kegiatans.user_id', '=', 'users.id')
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('sub_kegiatans.sumber_dana_id', $dana)
                ->where('users.kode_skpd', $skpd)
                ->where('anggarans.pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'))
                ->get()->sum('nominal_anggaran');
        }

        $ok = array();
        foreach ($data->groupBy('user_id') as $key => $value) {
            $trKG = 0;
            $rfKG = 0;
            $trKU = 0;
            $rfKU = 0;
            foreach ($value as $kg) {
                $trKG += $kg->target_kegiatan;
                $trKU += $kg->target_keuangan;
                if ($kg->bulan_id <= $bulan) {
                    $rfKG += $kg->kegiatan_bulan_sekarang;
                    $rfKU += $kg->keuangan_bulan_sekarang;
                }
            }
            if ($filter == 1) {
                array_push($ok, [
                    'skpd' => $value[$key]->nama_skpd, 'data' => $rfKG ? round($rfKG / $trKG * 100, 2) : 0
                ]);
            } else {
                array_push($ok, [
                    'skpd' => $value[$key]->nama_skpd, 'data' => $rfKU ? round($rfKU / $anggaran * 100, 2) : 0
                ]);
            }
        }
        return response()->json($ok, 200);
    }
    public function ranking()
    {
        $bulan = Bulan::all();
        $selected = request()->get('bulan') ?? 1;
        $dana = SumberDana::all();
        $selectedDana = request()->get('dana') ?? 1;
        return view('admin.grafik.rangking', compact('bulan', 'dana', 'selected', 'selectedDana'));
    }
}
