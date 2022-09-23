<?php

namespace App\Http\Controllers\Operator;

use toastr;
use App\Models\Anggaran;
use App\Models\KunciInputan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Lokasi;
use App\Models\Pelaksanaan;
use App\Models\Pengadaan;
use App\Models\SubKegiatan;
use App\Models\SumberDana;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class OperatorSubKegiatanController extends Controller
{
    public function index()
    {
        $aktif = KunciInputan::firstWhere('nama_inputan', 'Entry Kegiatan');

        if (session()->get('pelaksanaan') == true) {
            $data = SubKegiatan::with(["anggaran"])->whereHas('anggaran', function ($q) {
                $q->where('pak_id', session()->get('pak_id'))
                    ->where('pelaksanaan', true);
            })->where('user_id', Auth()->user()->id)
                ->where('pak_id', session()->get('pak_id'))
                ->get();
            if (!$data->isEmpty()) {
                return view('operator.kegiatan.index', compact(['aktif', 'data']));
            }
            $perubahan = SubKegiatan::with(["anggaran"])->whereHas('anggaran', function ($q) {
                $q->where('pak_id', session()->get('pak_id'));
            })->where('user_id', Auth()->user()->id)
                ->where('pak_id', session()->get('pak_id'))
                ->get();
            return view('operator.perubahan_anggaran', compact('perubahan'));
        }

        $data = SubKegiatan::with(["anggaran"])->whereHas('anggaran', function ($q) {
            $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', false);
        })->where('user_id', Auth()->user()->id)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.kegiatan.index', compact(['aktif', 'data']));
    }
    public function create()
    {
        return view('operator.kegiatan.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'rekening' => 'required|integer',
            'sumberdana' => 'required',
            'subkegiatan' => 'required|string',
            'pengadaan' => 'required',
            'anggaran' => 'required|integer',
            'pelaksanaan' => 'required',
            'bentukkegiatan' => 'required',
            'programbupati' => 'required'
        ]);
        try {
            $lp = json_encode($request->laporan);
            $a = new SubKegiatan();
            foreach (json_decode($lp) as $val) {
                if ($val == "dau") {
                    $a->dau = 1;
                }
                if ($val == "dak") {
                    $a->dak = 1;
                }
                if ($val == "dbhc") {
                    $a->dbhc = 1;
                }
            }

            $a->user_id = Auth()->user()->id;
            $a->pak_id = session()->get('pak_id');
            $a->sumber_dana_id = $request->sumberdana;
            $a->pengadaan_id = $request->pengadaan;
            $a->pelaksanaan_id = $request->pelaksanaan;
            $a->rekening = $request->rekening;
            $a->nama_sub_kegiatan = $request->subkegiatan;
            $a->bentuk_kegiatan = $request->bentukkegiatan;
            $a->program_bupati = $request->programbupati;
            $a->save();

            $anggaran = new Anggaran;
            $anggaran->sub_kegiatan_id = $a->id;
            $anggaran->pak_id = session()->get('pak_id');
            $anggaran->nominal_anggaran = $request->anggaran;
            $anggaran->pelaksanaan = session()->get('pelaksanaan');
            $anggaran->save();

            toastr()->success('Data Sub Kegiatan berhasil ditambah!');
            return redirect('/operator/subkegiatan');
        } catch (QueryException $th) {
            dd($th->errorInfo);
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    public function show($id)
    {
        $data = [];
        if (session()->get('pelaksanaan') == false) {
            $data = SubKegiatan::with(["anggaran"])->whereHas('anggaran', function ($q) {
                $q->where('pak_id', session()->get('pak_id'))
                    ->where('pelaksanaan', false);
            })->where('id', $id)
                ->where('user_id', Auth()->user()->id)
                ->where('pak_id', session()->get('pak_id'))
                ->get();
        } else {
            $data = SubKegiatan::with(["anggaran"])->whereHas('anggaran', function ($q) {
                $q->where('pak_id', session()->get('pak_id'))
                    ->where('pelaksanaan', true);
            })->where('id', $id)
                ->where('user_id', Auth()->user()->id)
                ->where('pak_id', session()->get('pak_id'))
                ->get();
        }
        $dana = SumberDana::all();
        $pengadaan = Pengadaan::all();
        $pelaksanaan = Pelaksanaan::all();
        // dd($data);
        return view('operator.kegiatan.edit', compact('data', 'dana', 'pengadaan', 'pelaksanaan'));
    }
    public function update(Request $request, $id)
    {
        $kegiatan = SubKegiatan::findOrFail($id);
        try {
            $lp = json_encode($request->laporan);
            foreach (json_decode($lp) as $val) {
                if ($val == "dau") {
                    $kegiatan->dau = 1;
                } else {
                    $kegiatan->dau = null;
                }
                if ($val == "dak") {
                    $kegiatan->dak = 1;
                } else {
                    $kegiatan->dak = null;
                }
                if ($val == "dbhc") {
                    $kegiatan->dbhc = 1;
                } else {
                    $kegiatan->dbhc = null;
                }
            }
            $kegiatan->sumber_dana_id = $request->sumberdana;
            $kegiatan->pengadaan_id = $request->pengadaan;
            $kegiatan->pelaksanaan_id = $request->pelaksanaan;
            $kegiatan->rekening = $request->rekening;
            $kegiatan->nama_sub_kegiatan = $request->subkegiatan;
            $kegiatan->bentuk_kegiatan = $request->bentukkegiatan;
            $kegiatan->program_bupati = $request->program;
            $kegiatan->save();

            Anggaran::join('paks', 'paks.id', '=', 'anggarans.pak_id')
                ->where('sub_kegiatan_id', $id)
                ->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'))
                ->where('anggarans.id', $request->ag_id)
                ->update([
                    'nominal_anggaran' => $request->anggaran
                ]);
            toastr()->success('Berhasil memperbarui data sub kegiatan!');
            return redirect('/operator/subkegiatan');
        } catch (QueryException $th) {
            dd($th->errorInfo);
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        $kegiatan = SubKegiatan::findOrFail($id);
        try {
            Anggaran::firstWhere('sub_kegiatan_id', $id)->delete();
            Jadwal::where('sub_kegiatan_id', $id)->delete();
            Lokasi::where('sub_kegiatan_id', $id)->delete();
            $kegiatan->delete();
            toastr()->success('Berhasil menghapus data sub kegiatan');
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon');
            return redirect()->back();
        }
    }

    // Perubahan Anggaran
    public function perubahan(Request $request)
    {
        try {
            for ($i = 0; $i < count($request->id); $i++) {
                $anggaran = new Anggaran();
                $anggaran->sub_kegiatan_id = $request->id[$i];
                $anggaran->pak_id = session()->get('pak_id');
                $anggaran->nominal_anggaran = $request->anggaran[$i];
                $anggaran->pelaksanaan = session()->get('pelaksanaan');
                $anggaran->save();
            }
            toastr()->success('Berhasil melakukan perubahan anggaran!');
            return redirect('operator/subkegiatan');
        } catch (QueryException $e) {
            toastr()->error('Server tidak merespon!');
            return redirect()->back();
        }
    }
}
