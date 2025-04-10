<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        // Get current user's cart
        $userId = Auth::id();
        $sessionId = session()->getId();

        $cart = Cart::getCurrentCart($userId, $sessionId);

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add some products before checkout.');
        }

        // Load cart items with product information
        $cart->load('items.product');

        // If user is not logged in, show a message that they need to login to complete checkout
        $requiresLogin = !Auth::check();

        return view('checkout.index', compact('cart', 'requiresLogin'));
    }

    /**
     * Process the checkout and create an order.
     */
    public function process(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer',
            'recipient_name' => 'nullable|required_without:same_as_billing|string|max:255',
            'recipient_phone' => 'nullable|required_without:same_as_billing|string|max:20',
            'shipping_notes' => 'nullable|string|max:500',
        ]);

        // Get current user's cart
        $userId = Auth::id();
        $sessionId = session()->getId();

        $cart = Cart::getCurrentCart($userId, $sessionId);

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add some products before checkout.');
        }

        // Load cart items with product information
        $cart->load('items.product');

        try {
            DB::beginTransaction();

            // Determine recipient information
            $recipientName = isset($validated['same_as_billing']) ? $validated['name'] : $validated['recipient_name'];
            $recipientPhone = isset($validated['same_as_billing']) ? $validated['phone'] : $validated['recipient_phone'];

            // Create shipping address
            $shippingAddress = $validated['address'] . ', ' . $validated['city'] . ', ' . $validated['state'] . ', ' . $validated['postal_code'] . ', ' . $validated['country'];

            // Create order
            $order = new Order([
                'user_id' => $userId,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $cart->total_amount,
                'discount_amount' => 0, // Apply any discounts here
                'final_amount' => $cart->total_amount, // Adjust for discounts
                'status' => 'pending',
                'shipping_status' => 'pending',
                'shipping_address' => $shippingAddress,
                'recipient_name' => $recipientName,
                'recipient_phone' => $recipientPhone,
                'shipping_city' => $validated['city'],
                'shipping_state' => $validated['state'],
                'shipping_postal_code' => $validated['postal_code'],
                'shipping_country' => $validated['country'],
                'shipping_notes' => $validated['shipping_notes'] ?? null,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'estimated_delivery_date' => now()->addDays(5), // Default to 5 days delivery estimate
            ]);

            $order->save();

            // Create order items from cart items
            foreach ($cart->items as $cartItem) {
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->unit_price ?? $cartItem->price,
                    'subtotal' => $cartItem->subtotal ?? ($cartItem->price * $cartItem->quantity),
                ]);

                $orderItem->save();

                // Update product inventory
                $product = $cartItem->product;
                if ($product->inventory) {
                    $product->inventory->decreaseStock($cartItem->quantity);
                }
            }

            // Clear the cart
            $cart->items()->delete();
            $cart->total_amount = 0;
            $cart->save();

            DB::commit();

            // Redirect to payment page
            return redirect()->route('checkout.payment', ['order' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'An error occurred while processing your order. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the payment page for an order.
     */
    public function payment(Order $order)
    {
        // Check if order belongs to current user
        if (Auth::id() != $order->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Load order items with product information
        $order->load('items.product');

        return view('checkout.payment', compact('order'));
    }

    /**
     * Display the success page after successful checkout.
     */
    public function success(Order $order)
    {
        // Check if order belongs to current user
        if (Auth::id() != $order->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Load order items with product information
        $order->load('items.product', 'transactions');

        return view('checkout.success', compact('order'));
    }

    /**
     * Process a direct "Buy Now" request
     */
    public function buyNow(Request $request)
    {
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $product = Product::findOrFail($request->product_id);

    // Check if product is in stock
    if (!$product->inventory || $product->inventory->quantity < $request->quantity) {
        return back()->with('error', 'Sorry, this product is out of stock or has insufficient quantity.');
    }

    // Create a temporary cart for this purchase
    $cart = new Cart();
    $cart->user_id = Auth::id();
    $cart->save();

    // Add the product to this cart
    $cart->items()->create([
        'product_id' => $product->id,
        'quantity' => $request->quantity,
        'price' => $product->price
    ]);

    // Redirect to checkout with this cart
    return redirect()->route('checkout.index', ['cart_id' => $cart->id]);
    }
}