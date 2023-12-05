<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DaftarJemaatController extends Controller
{
    public function index()
    {
        $jemaats = User::whereNotIn('id', [1])->get();

        return view('daftar-jemaat.index', compact('jemaats'));
    }
}
