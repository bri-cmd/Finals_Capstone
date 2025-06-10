<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    @vite(['resources\css\app.css', 'resources\css\users\login.css'])
</head>
<body>
    <form action="" method="" class="login-form">
        <x-logoheader>
            <h1>Login</h1>
            <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
        </x-logoheader>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email">    
        </div>
        
        <div">
            <label for="passsword">Password</label>
            <input type="password" name="password">   
            <a href="" class="forget-pass">Forget your password</a> 
        </div>

        <x-usersbutton label="Login"/>
    </form>

</body>
</html>