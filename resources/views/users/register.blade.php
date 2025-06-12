<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

    @vite(['resources\css\app.css', 'resources\css\users\form.css'])

</head>
<body>
    <form action="" method="" class="form">
        <x-logoheader name="header">
            <x-slot name="header">
                <h1>Sign up</h1>      
                <p>Already have an account? <a href="{{ route('login') }}">Login</a></p> 
            </x-slot>
        
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
                <label for="validid" class="upload-label">
                    Upload a valid ID
                    <x-icons.info/>
                </label>    
                
                <div class="id-upload">
                    <input type="file" id="validid" name="validid" accept="image/*" class="custom-file">
                    <x-icons.upload />    
                </div>
            </div>
        </x-logoheader>

        <x-usersbutton label="Register"/>
        
    </form>
</body>
</html>