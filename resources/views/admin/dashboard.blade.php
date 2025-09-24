<x-dashboardlayout>
    <div class="p-6 space-y-6">

        {{-- Top Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-pink-100 p-6 rounded-2xl shadow">
                <h2 class="text-3xl font-bold">{{ $totalOrders }}</h2>
                <p class="text-gray-700">Total Orders</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-2xl shadow">
                <h2 class="text-3xl font-bold">{{ $pendingOrders }}</h2>
                <p class="text-gray-700">Pending Orders</p>
            </div>
            <div class="bg-green-100 p-6 rounded-2xl shadow">
                <h2 class="text-3xl font-bold">₱{{ number_format($revenue, 2) }}</h2>
                <p class="text-gray-700">Revenue</p>
            </div>
            <div class="bg-blue-500 text-white p-6 rounded-2xl shadow flex items-center gap-3">
                <span class="text-4xl">⚠️</span>
                <div>
                    <h2 class="text-3xl font-bold">{{ $lowStockItems }}</h2>
                    <p>Low Stock Items</p>
                </div>
            </div>
        </div>

        {{-- Chart + Recent Orders --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            {{-- Chart --}}
            <div class="lg:col-span-3 bg-white rounded-2xl shadow p-6">
                <h2 class="font mb-4">Sales Overview</h2>
                <div class="relative h-60"> {{-- slightly smaller height --}}
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
                <h2 class="font mb-4">Recent Orders</h2>
                <div>
                    <table class="w-full text-sm text-gray-600 border-separate border-spacing-y-2">
                        <thead>
                            <tr class="text-gray-500 text-xs uppercase">
                                <th class="py-3 px-4 text-left">Order ID</th>
                                <th class="py-3 px-4 text-left">Customer</th>
                                <th class="py-3 px-4 text-left">Date</th>
                                <th class="py-3 px-4 text-left">Amount</th>
                                <th class="py-3 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders->sortBy('id') as $order)
                                <tr>
                                    <td class="py-3 px-4">{{ $order->id }}</td>
                                    <td class="py-3 px-4">{{ $order->customer->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td class="py-3 px-4">₱{{ number_format($order->amount, 2) }}</td>
                                    <td class="py-3 px-4">
                                        @if($order->status === 'completed')
                                            <span class="text-green-600 font-semibold">Completed</span>
                                        @elseif($order->status === 'pending')
                                            <span class="text-yellow-600 font-semibold">Pending</span>
                                        @else
                                            <span class="text-blue-600 font-semibold">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesData = @json($salesData);

        const labels = ['Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        const dataPoints = labels.map((_, i) => salesData[i+1] ?? 0); // months are numeric 1-12

        const ctx = document.getElementById('salesChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Sales (₱)',
                        data: dataPoints,
                        borderColor: 'blue',
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    </script>
</x-dashboardlayout>
