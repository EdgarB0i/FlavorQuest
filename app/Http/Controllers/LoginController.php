<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            // Authentication passed
            $username = Auth::user()->name; // Get the username of the logged-in user
            return redirect()->route('home', ['username' => $username]);
        } else {
            // Authentication failed
            return back()->withErrors(['message' => 'Invalid login credentials.']);
        }
    }
    
    
    

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
