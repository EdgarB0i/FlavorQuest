<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function showSignupForm()
    {
        return view('signup');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Check if email already exists in the database
        $existingUser = User::where('email', $validatedData['email'])->first();
        if ($existingUser) {
            return back()->withErrors(['email' => 'This email is already registered.']);
        }

        // Check if the user's email is "abid@gmail.com"
        $isAdmin = ($validatedData['email'] === 'abid@gmail.com');
        $isAdmin = ($validatedData['email'] === 'farhan@gmail.com');

        // Create and save the user
        $user = User::create([
            'name' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'admin' => $isAdmin, // Set the admin status based on the email
        ]);

        // Redirect back to the welcome page
        return redirect('/');
    }
}
