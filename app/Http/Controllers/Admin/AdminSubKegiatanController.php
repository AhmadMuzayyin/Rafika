<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SubKegiatanExport;
use toastr;
use App\Models\Jadwal;
use App\Models\Lokasi;
use App\Models\Anggaran;
use App\Models\Pengadaan;
use App\Models\SumberDana;
use App\Models\Pelaksanaan;
use App\Models\SubKegiatan;
use App\Models\KunciInputan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;

class AdminSubKegiatanController extends Controller
{
    public function index()
    {
        $aktif = KunciInputan::firstWhere('nama_inputan', 'Entry Kegiatan');

        if (session()->get('pelaksanaan') == true) {
            $data = SubKegiatan::with(["anggaran"])->whereHas('anggaran', function ($q) {
                $q->where('pak_id', session()->get('pak_id'))
                    ->where('pelaksanaan', true);
            })->where('pak_id', session()->get('pak_id'))
                ->get();
            return view('admin.kegiatan.index', compact(['aktif', 'data']));
        }

        $data = SubKegiatan::with(["anggaran"])->whereHas('anggaran', function ($q) {
            $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', false);
        })->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('admin.kegiatan.index', compact(['aktif', 'data']));
    }
    public function export()
    {
        return Excel::download(new SubKegiatanExport, 'Kegiatan.xlsx');
    }
}
