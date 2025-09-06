<x-dashboardlayout>
    <div class="flex gap-4">
        {{-- add new staff/admin --}}
        <section class="section-style">
            <h2 class="section-header">Add New Admin / Staff</h2>

            <form action="{{ route('admin.users.add')}}" method="POST" class="form">
                @csrf
                
                <div class="input-label">
                    <label for="first_name">First name</label>
                    <input required type="text" name="first_name">
                </div>
                
                <div class="input-label">
                    <label for="last_name">Last Name</label>
                    <input required type="text" name="last_name">
                </div>

                <div class="input-label">
                    <label for="email">Email</label>
                    <input required type="email" name="email">
                </div>

                <div class="input-label">
                    <label for="password">Password</label>
                    <input required type="text" name="password">
                </div>

                <div class="input-label">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="pt-0 pb-0 pl-1">
                        <option value="Staff">Staff</option>
                        <option value="Admin">Admin</option>
                    </select>               
                </div>

                <button class="form-button">Add</button>

                {{-- validation error --}}
                {{-- @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500 text-xs">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif --}}
            </form>   
            
        </section>

        {{-- unverified users --}}
        <section class="section-style">
            <h2 class="section-header">Unverified Users</h2>
            
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
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
                                <td>{{ $unverifieduser->first_name}} {{ $unverifieduser->last_name}}</td>
                                <td>{{ $unverifieduser->email}}</td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/' . $unverifieduser->id_uploaded) }}" target="_blank" class="hover:underline">
                                        {{ basename($unverifieduser->id_uploaded)}}
                                    </a>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.users.approved', $unverifieduser->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" ><x-icons.check /></button>
                                        </form>
                                        <form action="{{ route('admin.users.decline', $unverifieduser->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" ><x-icons.close /></button>
                                        </form>
                                    </div>
                                </td>    
                            </tr>    
                        @endforeach
                    </tbody>
                </table>    
            </div>
        </section>    
    </div>
    
    
    {{-- user acccounts --}}
    <section class="section-style">
        <div class="header-container">
            <h2 class="section-header">User accounts</h2>
            
            {{-- search bar --}}
            <form action="{{ route('admin.useraccount') }}" method="GET">
                <input 
                    type="text"
                    name="search"
                    placeholder="Seach Users"
                    value="{{ request('search') }}" 
                    class="search-bar"
                >
                <button type="submit">
                    <x-icons.search class="search-icon"/>
                </button>
            </form>
        </div>

        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>    
        </div>
        
        <div class="table-body" x-data="{ showEditModal: false, selectedUser: {}, showViewModal: false, selectedUser: {} }">
            <table class="table">
                <tbody>
                    @foreach ($userAccounts as $userAccount)
                        <tr>
                            <td>{{ $userAccount->first_name }} {{ $userAccount->last_name}}</td>
                            <td>{{ $userAccount->email }}</td>
                            <td class="text-center">{{ ucfirst($userAccount->role) }}</td>
                            <td class="text-center">{{ ucfirst($userAccount->status) }}</td>
                            <td class="align-middle text-center">
                                <div class="flex justify-center gap-2">
                                    @if ($userAccount->role === 'Customer') 
                                        <button @click="showViewModal = true; selectedUser = {{ $userAccount->toJson() }}">
                                        {{-- <button @click="showModal = true; selectedUser = JSON.parse('{!! addslashes($userAccount->toJson()) !!}')"> --}}
                                            <x-icons.view />    
                                        </button>
                                    @else
                                        <button @click="showEditModal = true; selectedUser = {{ $userAccount->toJson() }}">
                                            <x-icons.edit />
                                        </button>
                                    @endif
                                    <form action="{{ route('admin.users.delete', $userAccount->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" ><x-icons.delete /></button>
                                    </form>
                                </div>
                            </td>    
                        </tr>    
                    @endforeach
                </tbody>
            </table>    

            {{-- Edit Modal --}}
            <div x-show="showEditModal" x-cloak x-transition class="modal">
                <div class="modal-form" @click.away="showEditModal = false">
                    <h2 class="text-center">Edit User</h2>

                    <form :action="'/users/' + selectedUser.id + '/update'" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" x-model="selectedUser.id">

                        <div>
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" x-model="selectedUser.first_name">
                        </div>
                        <div>
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" x-model="selectedUser.last_name">
                        </div>
                        <div>
                            <label for="email">Email</label>
                            <input type="email" name="email" x-model="selectedUser.email">
                        </div>

                        <div>
                            <label for="role">Role</label>
                            <select name="role" id="role" class="rounded" x-model="selectedUser.role">
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                            </select>               
                        </div>

                        <button type="submit">Save</button>
                    </form>
                </div>
            </div>

            {{-- View Modal --}}
            <div x-show="showViewModal" x-cloak x-transition class="modal">
                <div class="modal-form" @click.away="showViewModal = false">
                    <h2 class="text-center">Customer Details</h2>

                    <form>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" x-model="selectedUser.id">

                        <div>
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" x-model="selectedUser.first_name" readonly>
                        </div>
                        <div>
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" x-model="selectedUser.last_name" readonly>
                        </div>
                        <div>
                            <label for="email">Email</label>
                            <input type="text" name="email" x-model="selectedUser.email" readonly>
                        </div>

                        <div>
                            <label for="role">Role</label>
                            <input type="text" name="role" x-model="selectedUser.role" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-dashboardlayout>