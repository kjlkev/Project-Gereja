<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateProfileController extends Controller
{
    public function index() {
        return view('profile.index');
    }

    public function updateprofile(Request $request) {
        // dd($request->all());
        $validatedData = $request->validate([
            'fullname' => 'required|min:3|max:255',
            'username' => 'min:3|max:255|unique:users,username,' . auth()->user()->id,
            'no_tlpn' => 'nullable|min:10|max:13',
            'tgl_lahir' => 'nullable|date_format:Y-m-d', 
            'gender' => 'nullable|in:female,male', 
        ]);
        // Update the user's profile with the validated data
        auth()->user()->update($validatedData);

        return redirect('/profile')->with('success', 'Profile updated!');
    }
}
