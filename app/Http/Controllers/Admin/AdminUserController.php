<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use function PHPSTORM_META\map;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;

class AdminUserController extends Controller
{
    public function index()
    {
        $data = User::orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('data'));
    }
    public function create()
    {
        return view('admin.users.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'kode_skpd' => 'required|in:1,2,3,4,5',
            'nama_skpd' => 'required',
            'nomor_tlp_kantor' => 'required',
            'alamat_kantor' => 'required',
            'nama_operator' => 'required',
            'nomor_tlp_operator' => 'required',
            'alamat_operator' => 'required',
            'nama_kpa' => 'required',
            'level' => 'required'
        ]);
        $opd = new User();
        $opd->username = $request->username;
        $opd->password = bcrypt($request->password);
        $opd->kode_skpd = $request->kode_skpd;
        $opd->nama_skpd = $request->nama_skpd;
        $opd->nomor_tlp_kantor = $request->nomor_tlp_kantor;
        $opd->alamat_kantor = $request->alamat_kantor;
        $opd->nama_operator = $request->nama_operator;
        $opd->nomor_tlp_operator = $request->nomor_tlp_operator;
        $opd->alamat_operator = $request->alamat_operator;
        $opd->nama_kpa = $request->nama_kpa;
        $opd->images = 'default.jpg';
        $opd->isAdmin = $request->level;
        $opd->save();
        toastr()->success('Berhasil mengubah data opd!');
        return redirect('/admin/users');
    }
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('admin.users.edit', compact('data'));
    }
    public function update(Request $request, $id)
    {
        $opd = User::findOrFail($id);
        try {
            $request->validate([
                'kode_skpd' => 'required|in:1,2,3,4,5',
                'nama_skpd' => 'required',
                'nomor_tlp_kantor' => 'required',
                'alamat_kantor' => 'required',
                'nama_operator' => 'required',
                'nomor_tlp_operator' => 'required',
                'nama_kpa' => 'required',
                'username' => 'required|unique:users,username,' . $id,
                'level' => 'required'
            ]);
            $opd->kode_skpd = $request->kode_skpd;
            $opd->nama_skpd = $request->nama_skpd;
            $opd->alamat_kantor = $request->alamat_kantor;
            $opd->nomor_tlp_kantor = $request->nomor_tlp_kantor;
            $opd->nama_operator = $request->nama_operator;
            $opd->nomor_tlp_operator = $request->nomor_tlp_operator;
            $opd->nama_kpa = $request->nama_kpa;
            $opd->username = $request->username;
            if ($request->password) {
                $opd->password = bcrypt($request->password);
            }
            $opd->isAdmin = $request->level;
            $opd->save();
            toastr()->success('Berhasil mengubah data opd!');
            return redirect('/admin/users');
        } catch (QueryException $th) {
            toastr()->error('Server tidak merespon');
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        $opd = User::findOrFail($id);
        try {
            DB::table('sub_kegiatans')
                ->join('jadwals', 'sub_kegiatans.id', '=', 'jadwals.sub_kegiatan_id')
                ->join('lokasis', 'sub_kegiatans.id', '=', 'lokasis.sub_kegiatan_id')
                ->join('anggarans', 'sub_kegiatans.id', '=', 'anggarans.sub_kegiatan_id')
                ->join('penanggung_jawabs', 'sub_kegiatans.id', '=', 'penanggung_jawabs.sub_kegiatan_id')
                ->where('user_id', $id)->delete();
            DB::table('user_penanggun_jawabs')->where('user_id', $id)->delete();
            $opd->delete();
            toastr()->success('Data opd berhasil dihapus!');
            return redirect()->back();
        } catch (QueryException $th) {
            dd($th->errorInfo);
            toastr()->error('Server tidak merespon');
            return redirect()->back();
        }
    }
    public function export()
    {
        return Excel::download(new UserExport, 'opd.xlsx');
    }
}
