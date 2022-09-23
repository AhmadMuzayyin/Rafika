<?php

namespace App\Models;

use App\Models\UserPenanggunJawab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenanggungJawab extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function user_penanggun_jawab()
    {
        return $this->belongsTo(UserPenanggunJawab::class);
    }
}
