<header class="header">
    <div>
        <img src="{{ asset('images\Logo.png') }}" alt="Logo" class="logo">
        <h2>Madoxx.qwe</h2>    
    </div>
    
    <div class="gap-3">
        <x-icons.bell/>
        <div class="gap-1">
            <x-icons.profile/>
            <p>{{ $slot }}</p>
            <p class="role">Admin</p>
            <x-icons.arrow class="hover:text-gray-500"/>
        </div>    
    </div>
    
</header>