<?php

namespace App\Models;

use App\Models\Bulan;
use App\Models\SubKegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function sub_kegiatan()
    {
        return $this->hasMany(SubKegiatan::class);
    }
    public function bulan()
    {
        return $this->belongsTo(Bulan::class);
    }
    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'sub_kegiatan_id');
    }
}
