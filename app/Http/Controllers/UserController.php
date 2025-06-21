<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // user authentication functions
    public function login() {
        return view ('users.login');
    }

    public function register() {
        return view ('users.register');
    }

    public function forgot() {
        return view ('users.forgot');
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
        $userAccounts = User::all();

        // compact -> takes the string passed into a key-value pair
        return view('dashboard.useraccount', compact('unverifiedUsers', 'userAccounts'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|string',
        ]);

        // save password in a hash
        $validated['password'] = bcrypt($validated['password']);
        $validated['status'] = 'active'; 

        User::create($validated);

        return redirect()->route('useraccount')->with('success', 'User Created!');
    }

    public function registerUser(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
            'id_uploaded' => 'required|mimes:jpg,jpeg,png|max:2048',
        ]);

        // check if the email existed
        if (UserVerification::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'This email is already awaiting verification']);
        }

        // store the uploaded file in 'public/ids' folder
        $validated['id_uploaded'] = $request->file('id_uploaded')->store('ids', 'public');

        // save password in hash
        $validated['password'] = bcrypt($validated['password']);

        UserVerification::create($validated);

        return redirect()->route('home')->with('success', 'Account Created!');

        // consider functionality: making the id one-time-view
        // add new column in the user_verifications table
        // insert the following on the appropriate places:
        // function:
            // $table->timestamp('viewed_at')->nullable();
        // controller:
            // if ($user->viewed_at) {
            // abort(403, 'This ID has already been reviewed.');
            // }

            // $user->update(['viewed_at' => now()]);
        // display logic:
            // @if (!$unverifieduser->viewed_at)
            //     <img src="{{ asset('storage/' . $unverifieduser->id_uploaded) }}" alt="Valid ID">
            // @else
            //     <span class="text-red-600">ID already reviewed</span>
            // @endif

    }

    public function approve($id) {
        $unverified = UserVerification::findOrFail($id);

        User::create([
            'first_name' => $unverified->first_name,
            'last_name' => $unverified->last_name,
            'email' => $unverified->email,
            'password' => $unverified->password,
            'role' => 'customer',
            'status' => 'active'
        ]);
            // optionally sent email or notifiation here

            // delete the unverified record and id
            $unverified->delete();

            if ($unverified->id_uploaded) {
                Storage::disk('public')->delete($unverified->id_uploaded);
            }

            return back()->with('success', 'User has been approved and added.');
    }

    public function decline($id) {
        $unverified = UserVerification::findOrFail($id);

        $unverified->delete();
        if ($unverified->id_uploaded) {
            Storage::disk('public')->delete($unverified->id_uploaded);
        }

        return back()->with('success', 'User has been declined and deleted.');
    }

    public function dashboard() {
        return view ('dashboard.dashboard');
    }

}
