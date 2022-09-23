<?php

namespace App\Http\Controllers;

use App\Models\KunciPak;
use App\Models\Pak;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PakController extends Controller
{
    public function pak()
    {
        if (session()->get('pak_id') != null && session()->get('pelaksanaan') != null) {
            $pak = Pak::firstWhere('id', session()->get('pak_id'));
            $pelaksanaan = session()->get('pelaksanaan') == true ? 'Sesudah Perubahan' : 'Sebelum Perubahan';
            toastr()->success('Anda sedang berada di Tahun Anggaran ' . $pak->tahun_anggaran . ' ' . $pelaksanaan);
            return redirect()->back();
        } else {
            $pak = KunciPak::join('paks', 'paks.id', '=', 'kunci_paks.pak_id')
                ->where('kunci_paks.status', 1)
                ->get();
            return view('pak', [
                'data' => $pak
            ]);
        }
    }
    public function redirect(Request $request)
    {
        session([
            'pak_id' => $request->pak_id,
            'pelaksanaan' => $request->pelaksanaan
        ]);
        if (Auth::user()->isAdmin == true) {
            return to_route('admin.dashboard');
        } else {
            return to_route('operator.dashboard');
        }
    }
    public function perubahan(Request $request)
    {
        try {
            if ($request->perubahan == 1) {
                session()->forget(['pak_id', 'pelaksanaan']);
                $pak = KunciPak::join('paks', 'paks.id', '=', 'kunci_paks.pak_id')
                    ->where('kunci_paks.status', 1)
                    ->get();
                return view('pak', [
                    'data' => $pak
                ]);
            }
        } catch (QueryException $th) {
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
}
