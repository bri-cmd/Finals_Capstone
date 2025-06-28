<nav class="nav-bar">

    {{-- fetching the user role in the database --}}
    {{-- ucfirst -> capitalizes the first character string --}}
    <h1>{{ ucfirst($role) }}</h1>

    {{-- grouping links in an array based on roles --}}
    @php
        $links = match($role) {
            'Admin' => [
                ['route' => route('dashboard') , 'label' => 'Dashboard', 'icon' => 'dashboard'],
                ['route' => route('useraccount') , 'label' => 'User Account', 'icon' => 'user'],
                ['route' => '' , 'label' => 'Order', 'icon' => 'order'],
                ['route' => '' , 'label' => 'Component Details', 'icon' => 'component'],
                ['route' => '' , 'label' => 'Sales Report', 'icon' => 'bargraph'],
                ['route' => '' , 'label' => 'Inventory Report', 'icon' => 'inventory'],
                ['route' => '' , 'label' => 'Software Details', 'icon' => 'software'],
                ['route' => '' , 'label' => 'Activity Logs', 'icon' => 'logs'],
                ['route' => '' , 'label' => 'Build', 'icon' => 'build', 'style' => 'last-nav'],
            ],
            'Staff' => [
                ['route' => '' , 'label' => 'Dashboard', 'icon' => 'dashboard'],
                ['route' => '' , 'label' => 'Order', 'icon' => 'order'],
                ['route' => '' , 'label' => 'Component Details', 'icon' => 'component'],
                ['route' => '' , 'label' => 'Software Details', 'icon' => 'software'],
                ['route' => '' , 'label' => 'Inventory Report', 'icon' => 'inventory'],
                ['route' => '' , 'label' => 'Build', 'icon' => 'build', 'style' => 'last-nav'],
            ],
            default => []
        };
    @endphp

    {{-- rendering links base on roles --}}
    <ul>
    @foreach ($links as $link)
        @php
            // checking if the current url matches the route
            $isActive = request()->is(ltrim(parse_url($link['route'], PHP_URL_PATH), '/' . '*'))
        @endphp
        <li class="{{ (($link['style'] ?? '' ) . ($isActive ? ' active' : '')) }}">
            <a href="{{ $link['route'] }}">
                <x-dynamic-component :component="'x-icons.' . $link['icon']" />
                {{ $link['label'] }}
            </a>
        </li>
    @endforeach
</ul>

</nav>