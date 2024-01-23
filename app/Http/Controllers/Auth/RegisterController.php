<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:student,professor',
        ]);

        User::create([
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
        ]);

        // Registration successful, redirect to the desired page
        return redirect()->intended('/dashboard')->with('message', 'Registration successful!');
    }

    public function editProfile()
{
    $user = Auth::user();
    return view('student.profile_edit', compact('user'));
}


public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'first_name' => 'required',
        'middle_name' => 'nullable',
        'last_name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'username' => 'required|unique:users,username,' . $user->id,
    ]);

    $user->update([
        'first_name' => $request->input('first_name'),
        'middle_name' => $request->input('middle_name'),
        'last_name' => $request->input('last_name'),
        'email' => $request->input('email'),
        'username' => $request->input('username'),
    ]);

    return redirect()->route('student.dashboard')->with('success', 'Profile updated successfully!');
}

}


