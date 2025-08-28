<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Techboxx</title>

    @vite([
        'resources\css\app.css',
        'resources\css\landingpage\header.css',
        'resources\css\build.css',
        'resources\css\buildext.css',
        'resources\js\app.js',
        'resources\js\component-viewer.js',
        ])
    
</head>
<body class="flex">
    @if (session('message'))
        <x-message :type="session('type')">
            {{ session('message') }}
        </x-message>
    @endif

    <header>
        <div class="header-logo">
            <img src="{{ asset('images\Logo.png') }}" alt="Logo" class="logo">
            <h2>Madoxx.qwe</h2>    
        </div>
    </header>

    <main class="main-content header">
        <h2 class="text-center">YOUR PC</h2>

        {{-- STEPS --}}
        <section>

        </section>

        {{-- COMPATIBILITY --}}
        <section>

        </section>

        {{-- COMPONENTS --}}
        <sectio class="">

        </section>
    </main>
</body>