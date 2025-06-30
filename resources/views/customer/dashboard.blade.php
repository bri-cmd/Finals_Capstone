<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    @vite([
    'resources\css\app.css', 
    'resources\css\customer\header.css',
    'resources\js\app.js'
        ])
</head>
<body>
    <x-customerheader :email="Auth::user()->email" >
        {{ Auth::user()->first_name }}
    </x-customerheader >
</body>
</html>