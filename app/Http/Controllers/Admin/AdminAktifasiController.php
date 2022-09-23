<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KunciInputan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AdminAktifasiController extends Controller
{
    public function index()
    {
        $data = KunciInputan::all();
        return view('admin.aktivasi.index', compact('data'));
    }
    public function kunci($id)
    {
        $kunci = KunciInputan::findOrFail($id);
        try {
            $kunci->status = $kunci->status == 1 ? 0 : 1;
            $kunci->save();
            if ($kunci->status == 1) {
                toastr()->success('Berhasil membuka inputan!');
            } else {
                toastr()->success('Berhasil mengunci inputan!');
            }
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
}
