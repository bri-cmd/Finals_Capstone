<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PayPalController extends Controller
{
    private $client;

    public function __construct()
    {
        $clientId = env('PAYPAL_CLIENT_ID') ?: env('CLIENT_ID');
        $clientSecret = env('PAYPAL_SECRET') ?: env('CLIENT_SECRET');

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $this->client = new PayPalHttpClient($environment);
    }

    public function create(Request $request)
    {
        $amount = $request->input('amount');
        $order_id = $request->input('order_id');
        // selected is a comma-separated list of cart item ids (string) passed from CheckoutController
        $selected = $request->input('selected');

        $paypalRequest = new OrdersCreateRequest();
        $paypalRequest->prefer('return=representation');
        $paypalRequest->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "PHP",
                    "value" => (string) $amount
                ]
            ]],
            "application_context" => [
                // include selected in return/cancel URLs so we can identify which cart items to remove later
                "return_url" => route('paypal.success', ['order_id' => $order_id, 'selected' => $selected]),
                "cancel_url" => route('paypal.cancel', ['order_id' => $order_id, 'selected' => $selected]),
            ]
        ];

        try {
            $response = $this->client->execute($paypalRequest);
        } catch (\Exception $e) {
            Log::error('PayPal create error: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Unable to start PayPal payment.');
        }

        foreach ($response->result->links as $link) {
            if ($link->rel === 'approve') {
                return redirect($link->href);
            }
        }

        return redirect()->route('cart.index')->with('error', 'Unable to start PayPal payment.');
    }

    public function success(Request $request)
    {
        $paypalOrderId = $request->query('token');
        $orderId = $request->query('order_id');
        $selectedRaw = $request->query('selected', null);

        // parse selected cart item IDs into array of ints
        $selectedIds = [];
        if ($selectedRaw) {
            $selectedIds = array_filter(array_map('intval', explode(',', $selectedRaw)));
        }

        try {
            $captureRequest = new OrdersCaptureRequest($paypalOrderId);
            $captureResponse = $this->client->execute($captureRequest);
        } catch (\Exception $e) {
            Log::error('PayPal capture error: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Payment capture failed.');
        }

        if (isset($captureResponse->result->status) && $captureResponse->result->status === "COMPLETED") {
            $order = Order::find($orderId);
            if ($order) {
                $order->update(['status' => 'paid', 'payment_method' => 'PayPal']);
            }

            $payer = $captureResponse->result->payer ?? null;
            $capture = $captureResponse->result->purchase_units[0]->payments->captures[0] ?? null;

            Payment::create([
                'order_id' => $order->id ?? null,
                'order_id_paypal' => $captureResponse->result->id ?? null,
                'payer_email' => $payer->email_address ?? null,
                'payer_name' => isset($payer->name) ? ($payer->name->given_name . ' ' . ($payer->name->surname ?? '')) : null,
                'status' => $captureResponse->result->status ?? null,
                'amount' => $capture->amount->value ?? null,
                'currency' => $capture->amount->currency_code ?? null,
                'transaction_id' => $capture->id ?? null,
            ]);

            // CLEAR THE CART ITEMS FOR THE AUTHENTICATED USER
            if (Auth::check()) {
                $shoppingCart = Auth::user()->shoppingCart;
                if ($shoppingCart) {
                    if (!empty($selectedIds)) {
                        // delete by cart item IDs (preferred)
                        $shoppingCart->cartItem()->whereIn('id', $selectedIds)->delete();
                    } else {
                        // fallback: delete items whose product_id matches the order's order items
                        $orderItems = OrderItem::where('order_id', $order->id ?? 0)->get();
                        foreach ($orderItems as $oi) {
                            $shoppingCart->cartItem()->where('product_id', $oi->product_id)->delete();
                        }
                    }
                }
            }

            return redirect()->route('cart.index')->with('success', 'Payment successful! Order placed.');
        }

        return redirect()->route('cart.index')->with('error', 'Payment not completed.');
    }

    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update(['status' => 'cancelled']);
            }
        }
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled.');
    }
}
