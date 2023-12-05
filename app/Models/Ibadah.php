<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ibadah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pengajarans() {
        return $this->hasMany(Pengajaran::class);
    }

    public function avls() {
        return $this->hasMany(AVL::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function ushers() {
        return $this->hasMany(Usher::class);
    }

    public function pemusiks() {
        return $this->hasMany(Pemusik::class);
    }
}
