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

        // hardware map just like in cart
        $hardwareMap = config('hardware');

        $checkoutItems = $order->items->map(function ($item) use ($hardwareMap) {
            $product = null;
            $category = 'N/A';
            $component = $item->name ?? 'Unknown';

            if (!empty($item->product_type) && isset($hardwareMap[$item->product_type])) {
                $model = $hardwareMap[$item->product_type];
                $product = $model::find($item->product_id);

                if ($product) {
                    $component = trim(($product->brand ?? '') . ' ' . ($product->model ?? '') . ' ' . ($product->name ?? ''));
                    $category = $product->category->name ?? ucfirst($item->product_type);
                }
            }

            return [
                'component' => $component,
                'category'  => $category,
                'qty'       => $item->quantity ?? 1,
                'price'     => $item->price ?? 0,
            ];
        });

        $total = $checkoutItems->sum(fn($it) => $it['price'] * $it['qty']);

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
