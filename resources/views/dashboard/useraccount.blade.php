<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Account</title>

    @vite(['resources\css\app.css', 'resources\css\dashboard\sidebar.css'])

</head>
<body class="body">

    {{-- Display a dynamic sidebar heading base on user --}}
    <x-adminsidenav :role="Auth::user()?->role" />

    <main class="main-content">
        <h2>Add New Admin / Staff</h2>

        <form action="" method="POST">
            @csrf
            <label for="username">Username</label>
            <input type="text">

            <label for="fullname">Full Name</label>
            <input type="text">

            <label for="email">Email</label>
            <input type="email">

            <label for="password">Password</label>
            <input type="text">

            <label for="role">Role</label>
            <input type="text">
        </form>
    </main>
</body>
</html>