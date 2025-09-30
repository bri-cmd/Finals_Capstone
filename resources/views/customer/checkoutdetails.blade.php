<x-dashboardlayout>
    <div class="p-6">
        <h2 class="text-2xl font-semibold mb-6">Checkout Details</h2>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border-b text-left text-sm font-medium text-gray-700">Component</th>
                        <th class="px-6 py-3 border-b text-left text-sm font-medium text-gray-700">Category</th>
                        <th class="px-6 py-3 border-b text-center text-sm font-medium text-gray-700">Qty</th>
                        <th class="px-6 py-3 border-b text-right text-sm font-medium text-gray-700">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($checkoutItems as $item)
                        <tr>
                            <td class="px-6 py-4 border-b">{{ $item['component'] }}</td>
                            <td class="px-6 py-4 border-b">{{ $item['category'] }}</td>
                            <td class="px-6 py-4 border-b text-center">{{ $item['qty'] }}</td>
                            <td class="px-6 py-4 border-b text-right">₱{{ number_format($item['price'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No checkout items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="flex justify-end p-6">
                <div class="text-lg font-semibold">
                    Total: ₱{{ number_format($total, 2) }}
                </div>
            </div>

            @if(isset($order))
                <div class="flex justify-end px-6 pb-6">
                    <button onclick="openModal()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Order Status
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Order Status Modal -->
    @if(isset($order))
        <div id="orderStatusModal" 
             class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-2/3 max-w-lg p-6 rounded shadow-lg relative">
                <button onclick="closeModal()" 
                        class="absolute top-2 right-2 text-gray-500 hover:text-black">✖</button>

                <h3 class="text-lg font-bold mb-4">Order Status</h3>

                <p><strong>Checkout ID:</strong> #{{ $order->id }}</p>
                <p><strong>Checkout Date:</strong> {{ optional($order->created_at)->format('F d, Y h:i A') ?? 'N/A' }}</p>
                <p><strong>Customer Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                <p><strong>Contact Number:</strong> {{ $contactNumber }}</p>

                <hr class="my-4">

                <h4 class="font-bold mb-2">Status Timeline</h4>
                <ul class="space-y-2 text-sm">
                    <li>
                        <strong>04/14/25 10:23 AM - Submitted:</strong>
                        Your order has been placed successfully.
                    </li>
                    <li>
                        <strong>04/14/25 11:10 AM - Pending Approval:</strong>
                        Order is being reviewed by our team.
                    </li>
                    <li>
                        <strong>04/14/25 02:35 PM - Approved:</strong>
                        Order approved and queued for shipping.
                    </li>
                    <li>
                        <strong>04/14/25 02:55 PM - To Pick Up:</strong>
                        Your order is ready to be picked up from the shop.
                    </li>
                </ul>

                <hr class="my-4">

                <p class="font-bold">
                    Current Status: 
                    <span class="text-green-600">{{ ucfirst($order->status ?? 'Pending') }}</span>
                </p>
            </div>
        </div>
    @endif

    <script>
        function openModal() {
            const modal = document.getElementById('orderStatusModal');
            if (modal) modal.classList.remove('hidden');
        }
        function closeModal() {
            const modal = document.getElementById('orderStatusModal');
            if (modal) modal.classList.add('hidden');
        }
    </script>
</x-dashboardlayout>
