<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>

    @vite(['resources\css\app.css', 'resources\css\dashboard\sidebar.css'])

</head>
<body>

    {{-- Display a dynamic sidebar heading base on user --}}
    <x-adminsidenav :role="Auth::user()?->role" />
</body>
</html>