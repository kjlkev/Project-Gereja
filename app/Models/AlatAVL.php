<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatAvl extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function avl() {
        return $this->hasMany(Avl::class,'alatAvl_id');
    }
}
