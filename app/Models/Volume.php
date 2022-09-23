<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    use HasFactory;
    protected $guarded = ['id_volume'];
    public function sub_kegiatan()
    {
        return $this->belongsTo(SubKegiatan::class);
    }
}
