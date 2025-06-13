<nav class="nav-bar">

    {{-- fetching the user role in the database --}}
    {{-- ucfirst -> capitalizes the first character string --}}
    <h1>{{ ucfirst($role) }}</h1>

    {{-- grouping links in an array based on roles --}}
    @php
        $links = match($role) {
            'admin' => [
                ['route' => '' , 'label' => 'Dashboard', 'icon' => 'dashboard'],
                ['route' => '' , 'label' => 'User Account', 'icon' => 'user'],
                ['route' => '' , 'label' => 'Order', 'icon' => 'order'],
                ['route' => '' , 'label' => 'Component Details', 'icon' => 'component'],
                ['route' => '' , 'label' => 'Sales Report', 'icon' => 'bargraph'],
                ['route' => '' , 'label' => 'Inventory Report', 'icon' => 'inventory'],
                ['route' => '' , 'label' => 'Software Details', 'icon' => 'software'],
                ['route' => '' , 'label' => 'Activity Logs', 'icon' => 'logs'],
                ['route' => '' , 'label' => 'Build', 'icon' => 'build', 'style' => 'last-nav'],
            ],
            'staff' => [
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
        <li class="{{ $link['style'] ?? '' }}">
            <a href="{{ $link['route'] }}">
                <x-dynamic-component :component="'x-icons.' . $link['icon']" />
                {{ $link['label'] }}
            </a>
        </li>
    @endforeach
</ul>

</nav>