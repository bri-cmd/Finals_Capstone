<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Techboxx</title>

    @vite([
        'resources\css\app.css', ])
</head>
<body>
    @if (session('success'))
        <div id="flash">
            {{ session('success') }}
        </div>
        @endif
    <h1>Landing Page</h1>
    <a href="/users">Start testing</a>
</body>
</html>