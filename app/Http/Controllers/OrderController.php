<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function checkout()
    {
        // Redirect to cart if empty
        $cart = Cart::getCurrentCart(Auth::id());
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add products before checkout.');
        }

        return view('orders.checkout', compact('cart'));
    }

    /**
     * Process the order.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:gcash,cash_on_delivery',
            // Add more validation rules as needed
        ]);

        // Get cart
        $cart = Cart::getCurrentCart(Auth::id());
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add products before checkout.');
        }

        // Create order
        $order = new Order([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $cart->total_amount,
            'discount_amount' => 0, // Implement discount logic if needed
            'final_amount' => $cart->total_amount, // Implement discount logic if needed
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'notes' => $request->notes ?? null,
        ]);
        $order->save();

        // Create order items
        foreach ($cart->items as $cartItem) {
            $product = $cartItem->product;

            // Check stock availability
            if ($product->stock_quantity < $cartItem->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Not enough stock available for {$product->name}. Available: {$product->stock_quantity}");
            }

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
                'subtotal' => $cartItem->subtotal,
            ]);

            // Update product stock
            $product->stock_quantity -= $cartItem->quantity;
            $product->save();
        }

        // Clear the cart
        $cart->items()->delete();
        $cart->total_amount = 0;
        $cart->save();

        // Redirect to order confirmation
        return redirect()->route('orders.confirmation', $order)
            ->with('success', 'Your order has been placed successfully!');
    }

    /**
     * Display order confirmation.
     */
    public function confirmation(Order $order)
    {
        // Ensure the order belongs to the current user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('items.product');
        return view('orders.confirmation', compact('order'));
    }

    /**
     * Display user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display a specific order.
     */
    public function show(Order $order)
    {
        // Ensure the order belongs to the current user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel(Order $order)
    {
        // Ensure the order belongs to the current user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only pending orders can be cancelled
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Only pending orders can be cancelled.');
        }

        // Update order status
        $order->status = 'cancelled';
        $order->save();

        // Restore product stock
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->stock_quantity += $item->quantity;
            $product->save();
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order cancelled successfully.');
    }

    /**
     * Mark an order as delivered (received by customer).
     */
    public function markDelivered(Order $order)
    {
        // Ensure the order belongs to the current user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only shipped orders can be marked as delivered
        if ($order->shipping_status !== 'shipped') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Only shipped orders can be marked as delivered.');
        }

        // Update shipping status and delivered_at timestamp
        $order->shipping_status = 'delivered';
        $order->delivered_at = now();
        $order->save();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order marked as delivered successfully.');
    }
}