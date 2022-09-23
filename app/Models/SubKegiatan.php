<?php

namespace App\Models;

use App\Models\Pak;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Lokasi;
use App\Models\Volume;
use App\Models\Anggaran;
use App\Models\Pengadaan;
use App\Models\SumberDana;
use App\Models\Pelaksanaan;
use App\Models\PenanggungJawab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubKegiatan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class);
    }
    public function pelaksanaan()
    {
        return $this->belongsTo(Pelaksanaan::class);
    }
    public function sumber_dana()
    {
        return $this->belongsTo(SumberDana::class);
    }
    public function anggaran()
    {
        return $this->hasMany(Anggaran::class);
    }
    public function lokasi()
    {
        return $this->hasMany(Lokasi::class);
    }
    public function volume()
    {
        return $this->hasMany(Volume::class);
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
    public function penanggung_jawab()
    {
        return $this->hasMany(PenanggungJawab::class);
    }
    public function pak()
    {
        return $this->belongsTo(Pak::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
