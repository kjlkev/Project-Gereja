<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){
        return view('register.index',[
            'title' => 'Register'
        ]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'fullname' => 'required|min:3|max:255',
            'username' => 'required|unique:users|min:3|max:255',
            'password' => 'required|min:5|max:255',
        ]);
        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);

        // Redirect to the login page or another appropriate page
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }
}
