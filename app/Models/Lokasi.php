<?php

namespace App\Models;

use App\Models\SubKegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lokasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function sub_kegiatan()
    {
        return $this->belongsTo(SubKegiatan::class);
    }
}
