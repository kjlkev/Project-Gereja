<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avl extends Model
{
    use HasFactory;
    public $guarded = ['id'];

    public function alatAvl() {
        return $this->belongsTo(AlatAvl::class, 'alatAvl_id');
    }

    public function ibadah() {
        return $this->hasOne(Ibadah::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
