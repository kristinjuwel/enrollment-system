<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication successful, redirect to the desired page
        return redirect()->intended('/dashboard');
    } else {
        $usernameExists = $this->usernameExists($credentials['username']);

        if ($usernameExists) {
            return redirect()->back()->withInput($request->only('username'))->with('error', 'Invalid username and password combination.');
        } else {
            return redirect()->route('register')->with('message', 'Username is not yet registered.');
        }
    }
}

private function usernameExists($username)
{
    return User::where('username', $username)->exists();
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }

}
