<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ibadah() {
        return $this->belongsTo(Ibadah::class);
    }
}
