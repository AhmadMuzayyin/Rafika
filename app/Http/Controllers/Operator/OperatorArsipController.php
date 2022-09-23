<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Bulan;
use App\Models\Jadwal;
use App\Models\Pak;
use App\Models\SubKegiatan;
use App\Models\SumberDana;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorArsipController extends Controller
{
    public function index()
    {
        if (request()->get('dana') != null) {
            $data = Bulan::all();
            $dana = SumberDana::all();
            $selected = request()->get('dana');
            return view('operator.arsip.index', compact('data', 'dana', 'selected'));
        } else {
            $data = Bulan::all();
            $dana = SumberDana::all();
            $selected = 1;
            return view('operator.arsip.index', compact('data', 'dana', 'selected'));
        }
    }

    public function cover(Request $request)
    {
        SubKegiatan::where('sumber_dana_id', $request->dana)->get();
        try {
            $data = $request->all();
            $bulan = Bulan::firstWhere('id', $request->bulan);
            $dana = SumberDana::firstWhere('id', $request->dana);
            $tag = Pak::firstWhere('id', session()->get('pak_id'));
            $skpd = User::firstWhere('id', Auth()->user()->id);
            $paket = SubKegiatan::where('sumber_dana_id', $request->dana)
                ->where('pak_id', session()->get('pak_id'))
                ->get()->count();
            $data = [
                'bulan' => $bulan,
                'dana' => $dana,
                'tag' => $tag,
                'skpd' => $skpd,
                'paket' => $paket
            ];
            $main = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
                ->join('anggarans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
                ->where('user_id', Auth()->user()->id)
                ->where('status', 1)
                ->where('sumber_dana_id', $request->dana)
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('anggarans.pak_id', session()->get('pak_id'))
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
                ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
                ->get();
            $validasi = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
                ->join('anggarans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
                ->where('user_id', Auth()->user()->id)
                ->where('status', 1)
                ->where('sumber_dana_id', $request->dana)
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('anggarans.pak_id', session()->get('pak_id'))
                ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
                ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
                ->where('bulan_id', $request->bulan)
                ->get();
            $realKegiatan = 0;
            $realKeuangan = 0;
            if (!$validasi->isEmpty()) {
                for ($i = 0; $i < $request->bulan; $i++) {
                    $realKegiatan += $main[$i]->kegiatan_bulan_sekarang;
                    $realKeuangan += $main[$i]->keuangan_bulan_sekarang;
                }
            }
            return view('operator.arsip.cover', compact('data', 'main', 'realKegiatan', 'realKeuangan'));
        } catch (QueryException $th) {
            return redirect()->back()->with('info', 'Tidak ada data untuk ditampilkan!');
        }
    }
    public function jadwal(Request $request)
    {
        SubKegiatan::where('sumber_dana_id', $request->dana)->get();
        try {
            $dana = SumberDana::firstWhere('id', $request->dana);
            $data = SubKegiatan::with(["lokasi", "penanggung_jawab", "pak"])
                ->whereHas('anggaran', function ($q) {
                    return $q->where('pak_id', session()->get('pak_id'))
                        ->where('pelaksanaan', session()->get('pelaksanaan'));
                })
                ->whereHas('jadwal', function ($q) {
                    return $q->where('pelaksanaan', session()->get('pelaksanaan'));
                })
                ->where('user_id', Auth()->user()->id)
                ->where('sumber_dana_id', $request->dana)
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->get();
            // dd($data);
            $thn = Pak::firstWhere('id', session()->get('pak_id'));
            $bulan = Bulan::all();
            return view('operator.arsip.jadwal', compact('data', 'bulan', 'thn', 'dana'));
        } catch (\Exception $th) {
            return redirect()->back()->with('info', 'Tidak ada data untuk ditampilkan!');
        }
    }
    public function rfk(Request $request)
    {
        SubKegiatan::where('sumber_dana_id', $request->dana)->get();
        try {
            $dana = SumberDana::firstWhere('id', $request->dana);
            $bl = Bulan::firstWhere('id', $request->bulan);
            $data = SubKegiatan::with(["lokasi", "penanggung_jawab", "pak", "pengadaan"])
                ->whereHas('anggaran', function ($q) {
                    return $q->where('pak_id', session()->get('pak_id'))
                        ->where('pelaksanaan', session()->get('pelaksanaan'));
                })->whereHas('jadwal', function ($q) {
                    return $q->where('pelaksanaan', session()->get('pelaksanaan'));
                })
                ->where('user_id', Auth()->user()->id)
                ->where('sumber_dana_id', $request->dana)
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->get();
            $thn = 0;
            foreach ($data as $ikeh) {
                $thn = $ikeh->pak->tahun_anggaran;
            }
            $bulan = Bulan::all();
            return view('operator.arsip.rfk', compact('data', 'bulan', 'thn', 'dana', 'bl'));
        } catch (\Exception $th) {
            return redirect()->back()->with('info', 'Tidak ada data untuk ditampilkan!');
        }
    }
    public function grafik(Request $request)
    {
        SubKegiatan::where('sumber_dana_id', $request->dana)->get();
        try {
            $dana = SumberDana::firstWhere('id', $request->dana);
            $bl = Bulan::firstWhere('id', $request->bulan);
            $data = SubKegiatan::join('anggarans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
                ->where('user_id', Auth()->user()->id)
                ->where('sumber_dana_id', $request->dana)
                ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
                ->where('anggarans.pak_id', session()->get('pak_id'))
                ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
                ->get();
            $thn = 0;
            $anggaran = 0;
            foreach ($data->groupBy('nama_sub_kegiatan') as $ikeh) {
                foreach ($ikeh as $it) {
                    $thn = $it->pak->tahun_anggaran;
                    $anggaran += $it->nominal_anggaran;
                }
            }
            $tkegiatan = 0;
            $rkegiatan = 0;
            $tkeuangan = 0;
            $rkeuangan = 0;
            $kegiatan = 0;
            foreach ($data->load('jadwal') as $val) {
                foreach ($val->jadwal as $key => $rk) {
                    if ($rk->pelaksanaan == session()->get('pelaksanaan')) {
                        if ($rk->bulan_id <= $request->bulan) {
                            $tkegiatan += $rk->target_kegiatan;
                            $rkegiatan += $rk->kegiatan_bulan_sekarang;
                            $tkeuangan += $rk->target_keuangan;
                            $rkeuangan += $rk->keuangan_bulan_sekarang;
                        }
                        $kegiatan += $rk->target_kegiatan;
                    }
                }
            }
            $grafik = [
                'tarkegiatan' => $tkegiatan > 0 && $kegiatan > 0 ? $tkegiatan / $kegiatan * 100 : 0,
                'relkegiatan' => $rkegiatan > 0 && $kegiatan > 0  ? $rkegiatan / $kegiatan * 100 : 0,
                'tarkeuangan' => $tkeuangan > 0 ? round($tkeuangan / $anggaran * 100, 2) : 0,
                'relkeuangan' => $rkeuangan > 0 ? round($rkeuangan / $anggaran * 100, 2) : 0,
            ];
            return view('operator.arsip.grafik', compact('data', 'thn', 'dana', 'bl', 'grafik'));
        } catch (QueryException $th) {
            return redirect()->back()->with('info', 'Tidak ada data untuk ditampilkan!');
        }
    }
}
