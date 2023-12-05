<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pemasukkan() {
        return $this->hasOne(Pemasukkan::class);
    }

    public function pengeluaran() {
        return $this->hasOne(Pengeluaran::class);
    }
}
