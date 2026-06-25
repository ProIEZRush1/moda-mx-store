<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function __construct(private readonly Cart $cart)
    {
    }

    public function checkout(): RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $secret = config('services.stripe.secret');

        if (empty($secret)) {
            return redirect()->route('cart.index')->with(
                'error',
                'El pago con tarjeta aún no está configurado. Configura STRIPE_KEY y STRIPE_SECRET para habilitar el checkout.'
            );
        }

        $items = $this->cart->detailed();

        $lineItems = [];
        foreach ($items as $item) {
            $name = $item['name'];
            if (! empty($item['size'])) {
                $name .= ' (Talla: ' . $item['size'] . ')';
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'mxn',
                    'product_data' => ['name' => $name],
                    'unit_amount' => (int) round($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        try {
            Stripe::setApiKey($secret);

            $session = StripeSession::create([
                'mode' => 'payment',
                'line_items' => $lineItems,
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cart.index'),
            ]);
        } catch (\Throwable $e) {
            Log::error('Stripe checkout error', ['message' => $e->getMessage()]);

            return redirect()->route('cart.index')->with(
                'error',
                'No se pudo iniciar el pago con Stripe. Verifica tus llaves de Stripe.'
            );
        }

        // Create a pending order linked to the Stripe session.
        $order = Order::create([
            'order_number' => 'MX-' . strtoupper(Str::random(8)),
            'total' => $this->cart->total(),
            'status' => 'pending',
            'stripe_session_id' => $session->id,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'size' => $item['size'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'line_total' => $item['price'] * $item['quantity'],
            ]);
        }

        return redirect()->away($session->url);
    }

    public function success(Request $request): View|RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return redirect()->route('home');
        }

        $order = Order::where('stripe_session_id', $sessionId)->first();

        if ($order) {
            $secret = config('services.stripe.secret');
            $paid = true;

            if (! empty($secret)) {
                try {
                    Stripe::setApiKey($secret);
                    $session = StripeSession::retrieve($sessionId);
                    $paid = ($session->payment_status === 'paid');

                    if ($session->customer_details) {
                        $order->customer_name = $session->customer_details->name;
                        $order->customer_email = $session->customer_details->email;
                    }
                } catch (\Throwable $e) {
                    Log::error('Stripe session retrieve error', ['message' => $e->getMessage()]);
                }
            }

            if ($paid && $order->status !== 'paid') {
                $order->status = 'paid';
            }
            $order->save();
        }

        $this->cart->clear();

        return view('storefront.success', ['order' => $order]);
    }
}
