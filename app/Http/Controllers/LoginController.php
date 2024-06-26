<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('login.index',[
            'title' => 'Login'
        ]);
    }
    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // dd(auth()->user()->is_admin);
            if(auth()->user()->is_admin == 1) {
                return redirect()->intended('/dashboard/jemaat');
            }
            elseif(auth()->user()->is_admin == 0) {
                return redirect()->intended('/jadwal-ibadah');
            }
        }
        return back()->with('loginError', 'Login failed!');
    }

    public function logout(){
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
