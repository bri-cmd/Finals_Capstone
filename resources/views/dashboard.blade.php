{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>

    @vite([
        'resources\css\app.css', 
        'resources\css\dashboard\sidebar.css',
        'resources\css\dashboard\header.css',
        'resources\css\dashboard\profile.css', 
        'resources\css\dashboard\table.css', 
        'resources\css\dashboard\modal.css', 
        'resources\css\customer\header.css', 
        'resources\js\app.js'
        ])

</head>
<body class="body">
    {{-- Display a dynamic header base on user information --}}
    @if (Auth::user()->role === 'Customer')
        <x-customerheader :email="Auth::user()->email" >
            {{ Auth::user()->first_name }}
        </x-customerheader >
    @else
        <x-dashboardheader :email="Auth::user()->email" :role="Auth::user()->role">
            {{-- retrieves the current authenticated user --}}
            {{ Auth::user()->first_name }}
        </x-dashboardheader>
    @endif

    {{-- Display a dynamic sidebar heading base on user --}}
    <x-adminsidenav :role="Auth::user()?->role" />

    <main class="main-content">
        <h1>Dashboard</h1>
        @include('customer.dashboard')
    </main>
</body>
</html>