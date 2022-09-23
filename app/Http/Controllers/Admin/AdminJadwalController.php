<?php

namespace App\Http\Controllers\Admin;

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

class AdminJadwalController extends Controller
{
    public function index()
    {
        $data = SubKegiatan::with(["anggaran"])->whereHas('anggaran', function ($q) {
            $q->where('pak_id', session()->get('pak_id'))
                ->where('pelaksanaan', session()->get('pelaksanaan'));
        })->where('pak_id', session()->get('pak_id'))
            ->get();
        return view('admin.jadwal.index', compact('data'));
    }
}
