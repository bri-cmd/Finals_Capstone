<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'id_uploaded' => ['required', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        // store the uploaded file in 'public/ids' folder
        // avoid accidental overrites or security issues
        $file = $request->file('id_uploaded');
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $path =  $file->storeAs('ids', $filename, 'public');

        $user = UserVerification::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_uploaded' => $path,
        ]);

        event(new Registered($user));

        // comment this out if: the newly registered user will automatically log in and will not be waiting for admin approval
        // if commented out, change route to dashboard or landing page
        // Auth::login($user); 

        return redirect()->route('home')->with([
            'message' => 'Your account has been submitted and is pending review.',
            'type' => 'success',
        ]);

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
}
