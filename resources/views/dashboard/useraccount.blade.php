<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Account</title>

    @vite([
        'resources\css\app.css', 
        'resources\css\dashboard\sidebar.css', 
        'resources\css\dashboard\form.css',
        'resources\css\dashboard\table.css'])

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

        {{-- add new staff/admin --}}
        <section class="add-user">
            <h2 class="section-header">Add New Admin / Staff</h2>

            <form action="{{ route('store.adduser')}}" method="POST" class="form">
                @csrf
                
                <div class="form-input">
                    <label for="fname">First name</label>
                    <input type="text" name="fname">
                </div>
                
                <div class="form-input">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname">
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

                {{-- validation error --}}
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500 text-xs">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>    
        </section>

        {{-- unverified users --}}
        <section class="unverified-users">
            <h2 class="section-header">Unverified Users</h2>
            
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="">Name</th>
                            <th>Email</th>
                            <th>ID Uploaded</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>    
            </div>
            
            <div class="table-body">
                <table class="table">
                    <tbody>
                        @foreach ($unverifiedUsers as $unverifieduser)
                            <tr>
                                <td>{{ $unverifieduser->name}}</td>
                                <td>{{ $unverifieduser->email}}</td>
                                <td>{{ $unverifieduser->id_uploaded}}</td>
                                <td>
                                    <button><x-icons.check /></button>
                                    <button><x-icons.close /></button>
                                </td>    
                            </tr>    
                        @endforeach
                    </tbody>
                </table>    
            </div>
            
        </section>
        
    </main>
</body>
</html>
