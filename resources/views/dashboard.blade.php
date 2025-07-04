<x-dashboardlayout>
    @if (Auth::user()->role === 'Customer')
        @include('customer.dashboard')
    @elseif (Auth::user()->role === 'Staff')
    @elseif (Auth::user()->role === 'Admin')
    @endif
</x-dashboardlayout>