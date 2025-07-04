<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index() {
        return view('dashboard');
    }

    public function update(Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
        ]);

        $emailChanged = $request->email !== $user->email;

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'email_verified_at' => $emailChanged ? null : $user->email_verified_at,
        ]);

        return redirect()->route('customerDashboard')->with([
            'message' => $emailChanged
                ? 'Profile Updated. Please verify your new email address'
                : 'Profile updated successfully.',
            'type' => 'success',
        ]);
    }
}
