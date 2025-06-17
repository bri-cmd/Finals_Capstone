<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVerification;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login() {
        return view ('users.login');
    }

    public function register() {
        return view ('users.register');
    }

    public function forgot() {
        return view ('users.forgot');
    }

    public function dashboard() {
        return view ('dashboard.dashboard');
    }

    public function authenticated(Request $request) {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); // Logs the user in
            $request->session()->regenerate(); // Prevent session fixation

            return match ($user->role) {
                'admin' => redirect()->route('dashboard'),
                'staff' => redirect()->route('dashboard'),
                'customer' => redirect()->route('home'),
                default => redirect()->route('forgot'),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials',
        ]);
    }

    public function useraccount() {
        $unverifiedUsers = UserVerification::all();

        // compact -> takes the string passed into a key-value pair
        return view('dashboard.useraccount', compact('unverifiedUsers'));
    }

    public function store(Request $request) {

        // combining first name and last name from the fields
        $request->merge([
            'name' => $request->input('fname') . ' ' . $request->input('lname'),
        ]);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|string',
        ]);

        // save password in a hash
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('useraccount')->with('success', 'User Created!');
    }

}
