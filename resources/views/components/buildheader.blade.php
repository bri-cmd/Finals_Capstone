<header class="header">
    <div class="header-logo">
        <img src="{{ asset('images\Logo.png') }}" alt="Logo" class="logo">
        <h2>Madoxx.qwe</h2>    
    </div>
    <div class="header-nav">
        <div class="header-link">
            <a href="">Your Builds</a>
            <a href="">Cart</a>
            <a href="">Products</a>
        </div>
        <div class="header-button">
            @auth
                @if (auth()->user()->role === 'Customer')
                    {{-- show custom content for logged-in customer --}}
                    <form action="{{ route('customer.dashboard') }}">
                        @csrf
                        <button>{{ $name }}</button>
                    </form>
                @endif
                @if (auth()->user()->role === 'Staff')
                    {{-- show custom content for logged-in customer --}}
                    <form action="{{ route('staff.dashboard') }}">
                        @csrf
                        <button>{{ $name }}</button>
                    </form>
                @endif
                @if (auth()->user()->role === 'Admin')
                    {{-- show custom content for logged-in customer --}}
                    <form action="{{ route('admin.dashboard') }}">
                        @csrf
                        <button>{{ $name }}</button>
                    </form>
                @endif
            @else
                {{-- show sign in button if not authenticated --}}
                <form action="{{ route('login') }}">
                    @csrf
                    <button>Sign In</button>
                </form>
            @endauth
        </div>
    </div>
</header>