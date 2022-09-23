<?php

namespace App\Http\Controllers\Operator;

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

class OperatorReportController extends Controller
{
    public function index()
    {
        if (request()->all() == null) {
            $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
                ->join('anggarans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
                ->where('sub_kegiatans.user_id', Auth()->user()->id)
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
            return view('operator.report.index', compact('data', 'bulan', 'batas', 'dana', 'selected', 'aktif', 'danaSelect'));
        }
        $data = Jadwal::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->join('anggarans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
            ->where('sub_kegiatans.user_id', Auth()->user()->id)
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
        return view('operator.report.index', compact('data', 'bulan', 'batas', 'dana', 'selected', 'aktif', 'danaSelect'));
    }
    public function store(Request $request)
    {
        try {
            foreach ($request->id as $key => $value) {
                if ($request->kegiatan[$key] == null && $request->keuangan[$key] == null) {
                    toastr()->error('Data tidak boleh kosong!');
                    return redirect()->back();
                } else {
                    $r = Jadwal::find($value);
                    if ($r->bulan_id > 1) {
                        $id = $r->id - 1;
                        $r = Jadwal::find($id);
                        $data = Jadwal::find($value);
                        $data->keuangan_bulan_sebelumnya = $r->keuangan_bulan_sekarang;
                        $data->kegiatan_bulan_sebelumnya = $r->kegiatan_bulan_sekarang;
                        $data->keuangan_bulan_sekarang = $request->keuangan[$key];
                        $data->kegiatan_bulan_sekarang = $request->kegiatan[$key];
                        $data->kendala = $request->kendala[$key];
                        $data->status = 1;
                        $data->save();
                    } else {
                        $data = Jadwal::find($value);
                        $data->keuangan_bulan_sekarang = $request->keuangan[$key];
                        $data->kegiatan_bulan_sekarang = $request->kegiatan[$key];
                        $data->kendala = $request->kendala[$key];
                        $data->status = 1;
                        $data->save();
                    }
                }
            };
            toastr()->success('Berhasil melakukan Report!');
            // dd($request->session()->get('_previous')['url']);
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon');
            return redirect()->back();
        }
    }
    public function rekapitulasi()
    {
        $data = Jadwal::join('bulans', 'bulans.id', '=', 'jadwals.bulan_id')
            ->join('anggarans', 'jadwals.sub_kegiatan_id', 'anggarans.sub_kegiatan_id')
            ->join('sub_kegiatans', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
            ->where('sub_kegiatans.user_id', Auth()->user()->id)
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))
            ->get();
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
                    ->where('user_id', Auth()->user()->id)
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
        };
        return view('operator.rekap.index', compact('tabel', 'rekap'));
    }
}
