<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use App\Models\KunciPak;
use App\Models\Pak;
use App\Models\SubKegiatan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AdminTahunAnggaranController extends Controller
{
    public function index()
    {
        $data = Pak::all();
        return view('admin.pak.index', compact('data'));
    }
    public function store(Request $request)
    {
        try {
            $pak = new Pak();
            $pak->tahun_anggaran = $request->tahun_anggaran;
            $pak->save();
            for ($i = 0; $i < 2; $i++) {
                $kunci = new KunciPak();
                $kunci->pak_id = $pak->id;
                $kunci->pelaksanaan = $i;
                $kunci->status = false;
                $kunci->save();
            }
            toastr()->success('Berhasil menambah tahun anggaran baru!');
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
        }
    }
    public function kunci(Request $request)
    {
        try {
            if (isset($request->sebelum)) {
                $kunci = KunciPak::firstWhere('id', $request->sebelum);
                if ($kunci) {
                    if ($kunci->status == 0) {
                        $kunci->status = 1;
                        $kunci->save();
                        toastr()->success('PAK Sebelum berhasil di buka!');
                    } else {
                        $kunci->status = 0;
                        $kunci->save();
                        toastr()->success('PAK Sebelum berhasil di kunci!');
                    }
                }
            } else {
                $kunci = KunciPak::firstWhere('id', $request->sesudah);
                if ($kunci) {
                    if ($kunci->status == 0) {
                        $kunci->status = 1;
                        $kunci->save();
                        toastr()->success('PAK Sesudah berhasil di buka!');
                    } else {
                        $kunci->status = 0;
                        $kunci->save();
                        toastr()->success('PAK Sesudah berhasil di kunci!');
                    }
                }
            }
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        $pak = Pak::findOrFail($id);
        try {
            $cekAg = Anggaran::where('pak_id', $id)->get();
            $cekKg = SubKegiatan::where('pak_id', $id)->get();
            if (!$cekAg->isEmpty() && !$cekKg->isEmpty()) {
                toastr()->error('Tahun Anggaran sedang digunakan');
                return redirect()->back();
            } else {
                $pak->delete();
                toastr()->success('Data Tahun Anggaran berhasil dihapus!');
            }
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
}
