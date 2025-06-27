<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserAccountController extends Controller
{
    public function useraccount(Request $request) {
        $unverifiedUsers = UserVerification::all();
        $search = $request->input('search');

        $userAccounts = User::all()->sortByDesc(function ($user) use ($search) {
            if (!$search) return false;

            return  stripos($user->first_name, $search) !== false ||
                    stripos($user->last_name, $search) !== false ||
                    stripos($user->email, $search) !== false;
        });


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

        return redirect()->route('useraccount')->with([
            'message' => 'User Created!',
            'type' => 'success',
        ]);
    }

    public function approve($id) {
        $unverified = UserVerification::findOrFail($id);

        // check if a user with the same email already exists
        if (User::where('email', $unverified->email)->exists()) {
            return back()->with([
                'message' => 'This email is already registered and cannot be approved again.',
                'type' => 'error',
            ]);
        }
        
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

            return back()->with([
                'message' => 'User has been approved and added.',
                'type' => 'success',    
            ]);
    }

    public function decline($id) {
        $unverified = UserVerification::findOrFail($id);

        $unverified->delete();
        if ($unverified->id_uploaded) {
            Storage::disk('public')->delete($unverified->id_uploaded);
        }

        return back()->with([
            'message' => 'User has been declined and deleted.',
            'type' => 'error',
        ]);
    }

    public function dashboard() {
        return view ('dashboard.dashboard');
    }
}
