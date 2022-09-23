<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenggunaAnggaran;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AdminPenggunaAnggaranController extends Controller
{
    public function index()
    {
        $data = PenggunaAnggaran::first();
        return view('admin.pa.index', compact('data'));
    }
    public function store(Request $request)
    {
        try {
            $cekPA = PenggunaAnggaran::first();
            if ($cekPA) {
                $cekPA->delete();
            }
            $pa = new PenggunaAnggaran();
            $pa->nip = $request->nip;
            $pa->nama_pengguna_anggaran = $request->nama;
            $pa->jabatan = $request->jabatan;
            $pa->save();
            toastr()->success('Berhasil menyimpan data Pengguna Anggaran');
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
}
