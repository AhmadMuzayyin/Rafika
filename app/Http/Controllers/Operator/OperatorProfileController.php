<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use App\Models\Jadwal;
use App\Models\SubKegiatan;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorProfileController extends Controller
{
    public function index($id)
    {
        $user = User::firstWhere('id', $id);
        $getAnggaran = Anggaran::join('sub_kegiatans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
            ->where('anggarans.pelaksanaan', session()->get('pelaksanaan'))
            ->where('anggarans.pak_id', session()->get('pak_id'))
            ->where('sub_kegiatans.pak_id', session()->get('pak_id'))
            ->get('nominal_anggaran');
        $anggaran = 0;
        foreach ($getAnggaran as $val) {
            $anggaran += $val->nominal_anggaran;
        }
        $kegiatan = SubKegiatan::where('user_id', Auth()->user()->id)->where('pak_id', session()->get('pak_id'))->get()->count();

        $melapor = SubKegiatan::join('jadwals', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')->where('sub_kegiatans.user_id', Auth()->user()->id)->where('sub_kegiatans.pak_id', session()->get('pak_id'))->where('jadwals.pelaksanaan', session()->get('pelaksanaan'))->where('jadwals.bulan_id', now()->format('n'))->where('jadwals.status', 1)->get()->count();

        return view('operator.profile.index', compact('user', 'anggaran', 'kegiatan', 'melapor'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        try {
            if ($request->file('foto')) {
                $fileName = Auth()->user()->username . '-' . now()->format('d-M-Y') . time() . '.' . $request->file('foto')->getClientOriginalName();
                $user->nama_skpd = $request->nama_skpd;
                $user->nama_kpa = $request->nama_kpa;
                $user->nama_operator = $request->nama_operator;
                $user->nomor_tlp_kantor = $request->no_kantor;
                $user->nomor_tlp_operator = $request->no_hp;
                $user->images = $fileName;
                if ($request->password) {
                    $user->password = bcrypt($request->password);
                }
                $user->save();
                $request->file('foto')->storeAs('public/uploads', $fileName);
            } else {
                $user->nama_skpd = $request->nama_skpd;
                $user->nama_kpa = $request->nama_kpa;
                $user->nama_operator = $request->nama_operator;
                $user->nomor_tlp_kantor = $request->no_kantor;
                $user->nomor_tlp_operator = $request->no_hp;
                if ($request->password) {
                    $user->password = bcrypt($request->password);
                }
                $user->save();
            }
            toastr()->success('Berhasil memperbarui profil anda!');
            return redirect()->back();
        } catch (QueryException $th) {
            dd($th->errorInfo);
            toastr()->error('Server tidak merespon!');
            return redirect()->back();
        }
    }
}
