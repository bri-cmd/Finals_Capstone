<x-dashboardlayout>
    <div class="p-6">
        <h2 class="text-2xl font-semibold mb-6">
            Welcome, {{ Auth::user()->name ?? 'Staff' }}
        </h2>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-sm text-gray-500">Orders in Progress</p>
                <h3 class="text-3xl font-bold text-indigo-600">{{ $ordersInProgress }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-sm text-gray-500">Inventory Warnings</p>
                <h3 class="text-3xl font-bold text-red-500">{{ $inventoryWarnings }}</h3>
            </div>
        </div>

        <!-- Tasks -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h4 class="font-semibold text-lg mb-3">Tasks</h4>
            <ul>
                @forelse($tasks as $task)
                    <li class="border-b py-2">
                        Pending Order Approval
                        <span class="font-mono text-gray-500">#{{ $task->id }}</span>
                    </li>
                @empty
                    <li class="text-gray-500">No pending tasks</li>
                @endforelse
            </ul>
        </div>

        <!-- Notifications -->
        <div class="bg-white rounded-xl shadow p-6">
            <h4 class="font-semibold text-lg mb-3">Notifications</h4>
            <ul class="space-y-2">
                @foreach($notifications['stockIns'] as $stockIn)
                    <li class="text-green-600">
                        Stock-in: {{ $stockIn->quantity_changed }} units (Component #{{ $stockIn->component_id }})
                    </li>
                @endforeach

                @foreach($notifications['stockOuts'] as $stockOut)
                    <li class="text-gray-700">
                        Stock-out: {{ $stockOut->quantity_changed }} units (Component #{{ $stockOut->component_id }})
                    </li>
                @endforeach

                @foreach($notifications['reorders'] as $component)
                    <li class="text-red-600 font-semibold">
                        Reorder alert: {{ $component->brand }} {{ $component->model }} (Stock: {{ $component->stock }})
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-dashboardlayout>
