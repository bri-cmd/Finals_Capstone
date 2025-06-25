<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>

    @vite(['resources\css\app.css', 'resources\css\users\form.css'])

</head>
<body>
    <form action="" method="" class="form">
        @csrf
        <x-logoheader>
            <x-slot name="header">
                <h1>Reset Your Password</h1>
                <p>What would you like your new password to be?</p>
            </x-slot>

            <div>
                <label for="newPass">New Password</label>
                <input type="password" name="newPass">    
            </div>
            
            <div">
                <label for="confirmPass">Confirm Password</label>
                <input type="password" name="confirmPass">   
            </div>
        </x-logoheader>

        <x-usersbutton label="Done"/>
    </form>
</body>
</html>