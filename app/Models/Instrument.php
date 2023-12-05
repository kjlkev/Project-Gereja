<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pemusik() {
        return $this->hasMany(Pemusik::class);
    }
}