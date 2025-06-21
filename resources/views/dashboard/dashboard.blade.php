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
        ])

</head>
<body class="body">
    {{-- Display a dynamic header base on user information --}}
    <x-dashboardheader>
        {{-- retrieves the current authenticated user --}}
        {{ Auth::user()->first_name }}
    </x-dashboardheader>

    {{-- Display a dynamic sidebar heading base on user --}}
    <x-adminsidenav :role="Auth::user()?->role" />

    <main class="main-content">
        <h1>Dashboard</h1>
    </main>
</body>
</html>