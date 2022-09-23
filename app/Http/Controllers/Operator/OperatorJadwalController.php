<?php

namespace App\Http\Controllers\Operator;

use toastr;
use App\Models\Bulan;
use App\Models\Jadwal;
use App\Models\Lokasi;
use App\Models\Volume;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use App\Models\UserPenanggunJawab;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use App\Models\KunciInputan;
use App\Models\PenanggungJawab;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;

class OperatorJadwalController extends Controller
{
    public function index()
    {
        $data = SubKegiatan::with(["anggaran"])->whereHas('anggaran', function ($q) {
            $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('user_id', Auth()->user()->id)
            ->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('operator.jadwal.index', compact('data'));
    }
    // For Lokasi Kegiatan
    public function lokasi($id)
    {
        $data = SubKegiatan::firstWhere('id', $id);
        $lokasi = Lokasi::where('sub_kegiatan_id', $id)->get();
        $page = 'lokasi';
        $token = 'Rafika@token#928OkasYehag@2022$';
        return view('operator.jadwal.edit', compact('data', 'lokasi', 'page', 'token'));
    }
    public function lokasiStore(Request $request)
    {
        try {
            $lokasi = new Lokasi();
            $lokasi->sub_kegiatan_id = $request->id;
            $lokasi->alamat = $request->lokasi;
            $lokasi->kecamatan = $request->lokasi;
            $lokasi->latitude = $request->latt;
            $lokasi->longitude = $request->long;
            $lokasi->save();
            toastr()->success('Berhasil menambah data lokasi!');
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    public function lokasiDestroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        try {
            $lokasi->delete();
            return response()->json([
                'data' => 'Success'
            ], 200);
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    // For volume kegiatan
    public function volume($id)
    {
        $data = SubKegiatan::firstWhere('id', $id);
        $volume = Volume::firstWhere('sub_kegiatan_id', $id);
        $page = 'volume';
        $token = 'Rafika@token#928OkasYehag@2022$';
        return view('operator.jadwal.edit', compact('data', 'volume', 'page', 'token'));
    }
    public function volumeStore(Request $request, $id)
    {
        try {
            $volume = Volume::firstWhere('sub_kegiatan_id', $id);
            if (isset($volume) == true) {
                $volume = Volume::find($volume->id);
                $volume->volume = $request->volume;
                $volume->satuan_volume = $request->satuan;
                $volume->save();
            } else {
                $volume = new Volume();
                $volume->sub_kegiatan_id = $id;
                $volume->volume = $request->volume;
                $volume->satuan_volume = $request->satuan;
                $volume->save();
            }
            toastr()->success('Berhasil menambah data volume!');
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    // For PPTK
    public function pptk($id)
    {
        $data = SubKegiatan::firstWhere('id', $id);
        $user = UserPenanggunJawab::where('user_id', Auth()->user()->id)->get();
        $pptk = PenanggungJawab::firstWhere('sub_kegiatan_id', $id);
        $page = 'pptk';
        $token = 'Rafika@token#928OkasYehag@2022$';
        return view('operator.jadwal.edit', compact('data', 'user', 'pptk', 'page', 'token'));
    }
    public function userpptkStore(Request $request, $id)
    {
        try {
            $user = new UserPenanggunJawab();
            $user->user_id = Auth()->user()->id;
            $user->nip = $request->nip;
            $user->nama_penanggung_jawab = $request->nama;
            $user->save();
            toastr()->success('Berhasil menambah data User PPTK');
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    public function userpptkUpdate(Request $request)
    {
        $user = UserPenanggunJawab::findOrFail($request->id);
        try {
            $user->nip = $request->nip;
            $user->nama_penanggung_jawab;
            $user->save();
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    public function userpptkDestroy($id)
    {
        $user = UserPenanggunJawab::findOrFail($id);
        try {
            $cek = Jadwal::firstWhere('user_penanggun_jawab_id', $id);
            if (isset($cek) == true) {
                toastr()->error('Data User PPTK tidak dapat dihapus!');
                return redirect()->back();
            } else {
                $user->delete();
            }
            toastr()->success('Berhasil menghapus data User PPTK!');
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    public function pptkStore(Request $request, $id)
    {
        try {
            $pptk = PenanggungJawab::firstWhere('sub_kegiatan_id', $id);
            if (isset($pptk) == true) {
                $bulan = Bulan::all();
                foreach ($bulan as $key => $value) {
                    DB::table('penanggung_jawabs')
                        ->where('sub_kegiatan_id', $id)
                        ->update(['user_penanggun_jawab_id' => $request->pptk]);
                }
            } else {
                $pptk = new PenanggungJawab();
                $pptk->sub_kegiatan_id = $id;
                $pptk->user_penanggun_jawab_id = $request->pptk;
                $pptk->save();
            }
            toastr()->success('Berhasil memilih PPTK');
            return redirect()->back();
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
    // For Target Kegiatan dan Keuangan
    public function target($id)
    {
        $data = SubKegiatan::firstWhere('id', $id);
        $anggaran = Anggaran::where('sub_kegiatan_id', $id)->where('pelaksanaan', session()->get('pelaksanaan'))->first();
        $jadwal = [];
        $cek = Jadwal::where('sub_kegiatan_id', $id)->where('pelaksanaan', session()->get('pelaksanaan'))->get();
        if (!$cek->isEmpty()) {
            $jadwal = Jadwal::where('sub_kegiatan_id', $id)->where('pelaksanaan', session()->get('pelaksanaan'))->get();
        } else {
            $jadwal = Jadwal::where('sub_kegiatan_id', $id)->get();
        }
        $progres = 0;
        if (isset($jadwal)) {
            if (isset($jadwal[0]->target_kegiatan) && isset($jadwal[0]->target_keuangan)) {
                $progres = 100;
            }
        }
        $page = 'target';
        $token = 'Rafika@token#928OkasYehag@2022$';
        $aktif = KunciInputan::firstWhere('nama_inputan', 'Target Fisik & Target Keuangan');
        return view('operator.jadwal.edit', compact('data', 'anggaran', 'jadwal', 'page', 'token', 'aktif', 'progres'));
    }
    public function targetStore(Request $request, $id)
    {
        try {
            $total_keuangan = 0;
            $total_kegiatan = 0;
            $anggaran = (int)$request->anggaran;
            $kegiatan = 100;
            for ($i = 0; $i < 12; $i++) {
                if (session()->get('pelaksanaan') == false) {
                    $total_keuangan += $request->keuangan[$i];
                    $total_kegiatan += $request->kegiatan[$i];
                } else {
                    $total_keuangan += $request->keuangan[$i];
                }
            }
            if ($total_keuangan <> $anggaran) {
                toastr()->error('Target keuangan tidak boleh kurang atau lebih dari anggaran!');
                return redirect()->back();
            }
            if (session()->get('pelaksanaan') == false) {
                if ($total_kegiatan <> $kegiatan) {
                    toastr()->error('Target kegiatan tidak boleh kurang atau lebih dari anggaran!');
                    return redirect()->back();
                }
            }
            if ($request->funcKU == true) {
                $bulan = Bulan::all();
                $jd = Jadwal::where('sub_kegiatan_id', $id)->where('pelaksanaan', false)->get();
                foreach ($bulan as $key => $value) {
                    if (session()->get('pelaksanaan') == false) {
                        $jadwal = new Jadwal();
                        $jadwal->sub_kegiatan_id = $id;
                        $jadwal->bulan_id = $value->id;
                        $jadwal->pelaksanaan = session()->get('pelaksanaan');
                        $jadwal->target_kegiatan = $request->kegiatan[$key];
                        $jadwal->target_keuangan = $request->keuangan[$key];
                        $jadwal->save();
                    } else {
                        $jadwal = new Jadwal();
                        $jadwal->sub_kegiatan_id = $id;
                        $jadwal->bulan_id = $value->id;
                        $jadwal->pelaksanaan = session()->get('pelaksanaan');
                        $jadwal->target_kegiatan = $jd[$key]->target_kegiatan;
                        $jadwal->kegiatan_bulan_sebelumnya = $jd[$key]->kegiatan_bulan_sebelumnya;
                        $jadwal->kegiatan_bulan_sekarang = $jd[$key]->kegiatan_bulan_sekarang;
                        $jadwal->target_keuangan = $request->keuangan[$key];
                        $jadwal->keuangan_bulan_sebelumnya = $jd[$key]->keuangan_bulan_sebelumnya;
                        $jadwal->keuangan_bulan_sekarang = $jd[$key]->keuangan_bulan_sekarang;
                        $jadwal->kendala = $jd[$key]->kendala;
                        $jadwal->status = $jd[$key]->status;
                        $jadwal->save();
                    }
                }
                if (session()->get('pelaksanaan') == false) {
                    toastr()->success('Berhasil menambah data Target Kegiatan dan Keuangan!');
                } else {
                    toastr()->success('Berhasil menambah data perubahan anggaran!');
                }
                return redirect()->back();
            } else {
                $cek = Jadwal::where('sub_kegiatan_id', $id)->where('pelaksanaan', session()->get('pelaksanaan'))->get();
                if ($cek) {
                    $bulan = Bulan::all();
                    foreach ($bulan as $key => $val) {
                        if (session()->get('pelaksanaan') == false) {
                            Jadwal::where('sub_kegiatan_id', $id)
                                ->where('pelaksanaan', session()->get('pelaksanaan'))
                                ->where('bulan_id', $val->id)
                                ->update([
                                    'target_kegiatan' => $request->kegiatan[$key],
                                    'target_keuangan' => $request->keuangan[$key]
                                ]);
                        } else {
                            Jadwal::where('sub_kegiatan_id', $id)
                                ->where('pelaksanaan', session()->get('pelaksanaan'))
                                ->where('bulan_id', $val->id)
                                ->update([
                                    'target_keuangan' => $request->keuangan[$key]
                                ]);
                        }
                    }
                    toastr()->success('Berhasil melakukan perubahan data!');
                    return redirect()->back();
                }
                toastr()->warning('Tidak ada data untuk melakukan perubahan');
                return redirect()->back();
            }
        } catch (QueryException $th) {
            $th->errorInfo;
            toastr()->info('Server tidak merespon!');
            return redirect()->back();
        }
    }
}
