<?php

namespace App\Models;

use App\Models\KunciPak;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pak extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kunci_pak()
    {
        return $this->hasMany(KunciPak::class);
    }
}
