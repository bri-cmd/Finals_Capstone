<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Techboxx</title>

    @vite([
        'resources\css\app.css',
        'resources\css\landingpage\header.css',
        'resources\js\app.js'])
</head>
<body class="flex">

    @if (session('message'))
        <x-message :type="session('type')">
            {{ session('message') }}
        </x-message>
    @endif

    <x-landingheader :name="Auth::user()?->first_name" />

    <main class="main-content">
        <h1>Landing Page</h1>
        <a href="{{ route('login') }}" class="hover:text-pink-500">Click here to start testing</a>
        <br>
        <a href="{{ route('techboxx.build') }}" class="hover:text-pink-500">Click here to start building</a>
    </main>
</body>
</html>