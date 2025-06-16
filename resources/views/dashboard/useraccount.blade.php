<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Account</title>

    @vite(['resources\css\app.css', 'resources\css\dashboard\sidebar.css', 'resources\css\dashboard\form.css'])

</head>
<body class="body">
    
    
    {{-- Display a dynamic sidebar heading base on user --}}
    <x-adminsidenav :role="Auth::user()?->role" />

    <main class="main-content">
        @if (session('success'))
        <div id="flash">
            {{ session('success') }}
        </div>
        @endif

        <h2>Add New Admin / Staff</h2>

        <section class="add-user">
            <form action="{{ route('store.adduser')}}" method="POST" class="form">
                @csrf
                
                <div class="form-input">
                    <label for="username">Username</label>
                    <input type="text" name="username">
                </div>
                
                <div class="form-input">
                    <label for="name">Full Name</label>
                    <input type="text" name="name">
                </div>

                <div class="form-input">
                    <label for="email">Email</label>
                    <input type="email" name="email">
                </div>

                <div class="form-input">
                    <label for="password">Password</label>
                    <input type="text" name="password">
                </div>

                <div class="form-input">
                    <label for="role">Role</label>
                    <select name="role" id="role">
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>               
                </div>

                <button class="form-button"">Add</button>
            </form>    
        </section>
        
    </main>
</body>
</html>
