<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class CheckoutDetailsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Get latest order for the logged-in user
        $order = Order::where('user_id', $userId)
            ->latest()
            ->with(['items', 'user'])
            ->first();

        if (!$order) {
            return view('customer.checkoutdetails', [
                'checkoutItems' => collect(),
                'total' => 0,
                'order' => null,
                'contactNumber' => 'N/A',
            ]);
        }

        // ✅ Use data directly from order_items table (like cart does)
        $checkoutItems = $order->items->map(function ($item) {
            return [
                'component' => $item->name ?? 'Unknown',
                'category'  => $item->category ?? ucfirst($item->product_type ?? 'N/A'),
                'qty'       => $item->quantity ?? 1,
                'price'     => $item->price ?? 0,
            ];
        });

        $total = $checkoutItems->sum(fn($it) => $it['price'] * $it['qty']);

        // Resolve contact number
        $contactNumber = $order->contact
            ?? $order->phone
            ?? $order->phone_number
            ?? ($order->user->contact ?? $order->user->phone ?? $order->user->phone_number ?? null)
            ?? 'N/A';

        return view('customer.checkoutdetails', [
            'checkoutItems' => $checkoutItems,
            'total' => $total,
            'order' => $order,
            'contactNumber' => $contactNumber,
        ]);
    }
}
