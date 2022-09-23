<?php

use App\Models\Bulan;
use App\Models\Jadwal;
use App\Models\Lokasi;
use App\Models\Volume;
use App\Models\Anggaran;
use App\Models\PenanggungJawab;
use Illuminate\Database\QueryException;

class helper
{
  public static function sisa($param)
  {
    try {
      return $param = Jadwal::where('sub_kegiatan_id', $param)
        ->where('pelaksanaan', session()->get('pelaksanaan'))
        ->get()
        ->sum('keuangan_bulan_sekarang');
    } catch (QueryException $th) {
      $th->errorInfo;
      toastr()->info('Server tidak merespon');
      return redirect()->back();
    }
  }
  public static function BulanOfName($param)
  {
    try {
      $namaBulan = Bulan::firstWhere('id', $param);
      return $namaBulan->nama_bulan;
    } catch (QueryException $th) {
      $th->errorInfo;
      toastr()->info('Server tidak merespon');
      return redirect()->back();
    }
  }
  public static function GetPersent($param)
  {
    $cekLokasi = Lokasi::where('sub_kegiatan_id', $param)->get();
    $cekVolume = Volume::where('sub_kegiatan_id', $param)->get();
    $cekPenanggungJawab = PenanggungJawab::where('sub_kegiatan_id', $param)->get();
    $cekJadwal = Jadwal::where('sub_kegiatan_id', $param)->where('pelaksanaan', session()->get('pelaksanaan'))->get();
    $persent = 0;
    if (!$cekLokasi->isEmpty()) {
      $persent = 20;
    }
    if (!$cekVolume->isEmpty()) {
      $persent = $persent + 20;
    }
    if (!$cekPenanggungJawab->isEmpty()) {
      $persent = $persent + 20;
    }
    if (!$cekJadwal->isEmpty()) {
      if ($cekJadwal->count() == 12) {
        $persent = $persent + 40;
      }
    }
    return $persent;
  }
}
