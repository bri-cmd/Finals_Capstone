<x-dashboardlayout>
    <h2>Order Processing</h2>

    <div class="header-container">
        <div class="order-tab">
            <button class="active">Order Builds</button>
            <button>Check-out Components</button>
        </div>
    </div>

    <section class="section-style !pl-0 !h-[65vh]">
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Build Details</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Pickup Status</th>
                        <th>Pickup Date</th>
                        <th>Payment Status</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table> 
        </div>

        <div class="overflow-y-scroll">
             <table class="table">
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id}}</td>
                        <td class="build-details">{{ $order->userBuild->build_name}}</td>
                        <td class="text-center !pr-[1.5%]">{{ $order->created_at ? $order->created_at->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->pickup_status }}</td>
                        <td>{{ $order->pickup_date ? $order->pickup_date : '-' }}</td>
                        <td>{{ $order->payment_status }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td class="align-middle text-center">
                            <div class="flex justify-center gap-2">
                                @if ($order->status === 'Pending')
                                    <x-icons.check/>
                                    <x-icons.close/>      
                                @else
                                    <x-icons.pickup/>    
                                @endif
                            </div>
                        </td>
                    </tr>    
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>

</x-dashboardlayout>
