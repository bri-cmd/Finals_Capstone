{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>

    @vite(['resources\css\app.css', 'resources\css\form.css'])

</head>
<body>
    <form action="{{ route('password.email') }}" method="POST" class="form">
        @csrf
        <x-logoheader>
            <x-slot name="header">
                <h1>Forgot Your Password?</h1>
                <p>No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
            </x-slot>

            <div class="mt-4">
                <label for="email">Email</label>
                <input type="email" name="email">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs absolute bottom-[25%]" />
            </div>

            @if (session('status'))
                <p class="text-green-500 absolute bottom-[25%]">
                    {{ session('status') }}
                </p>
            @endif

        </x-logoheader>
        
        <x-usersbutton label="Email Password Reset Link"/>

    </form>
</body>
</html>