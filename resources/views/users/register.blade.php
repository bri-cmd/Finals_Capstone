<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

    @vite(['resources\css\app.css', ])

</head>
<body>
    <form action="" method="" class="login-form">
        <x-logoheader>
            <h1>Sign up</h1>      
            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p> 
        </x-logoheader>
        
        <div>
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>

        <div>
            <label for="validid">Upload a valid ID</label>
            <input type="file" id="validid" name="validid" accept="image/*" class="custom-file">

        </div>

        <x-usersbutton label="Register"/>
        
    </form>
</body>
</html>