<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemusik extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function instrument() {
        return $this->belongsTo(Instrument::class, 'instrument_id');
    }
    public function ibadah() {
        return $this->hasOne(Ibadah::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
