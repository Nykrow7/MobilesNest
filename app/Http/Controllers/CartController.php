<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the cart.
     */
    public function index()
    {
        $cart = $this->getCart();
        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = $this->getCart();

        // Check if product is already in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity if product already exists in cart
            $cartItem->quantity += $request->quantity;
            
            // Get the applicable bulk pricing tier for the new quantity
            $newUnitPrice = $product->getPriceForQuantity($cartItem->quantity);
            $cartItem->unit_price = $newUnitPrice;
            $cartItem->subtotal = $cartItem->quantity * $newUnitPrice;
            $cartItem->save();
        } else {
            // Get the applicable bulk pricing tier for the quantity
            $unitPrice = $product->getPriceForQuantity($request->quantity);
            
            // Add new item to cart
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $unitPrice * $request->quantity,
            ]);
        }

        // Update cart total
        $cart->updateTotalAmount();

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    /**
     * Update cart item quantity.
     */
    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ensure the cart item belongs to the current user's cart
        $cart = $this->getCart();
        if ($cartItem->cart_id !== $cart->id) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }

        $cartItem->quantity = $request->quantity;
        
        // Get the product to check for applicable bulk pricing
        $product = Product::findOrFail($cartItem->product_id);
        
        // Get the applicable bulk pricing tier for the new quantity
        $newUnitPrice = $product->getPriceForQuantity($cartItem->quantity);
        $cartItem->unit_price = $newUnitPrice;
        $cartItem->subtotal = $cartItem->quantity * $newUnitPrice;
        $cartItem->save();

        // Update cart total
        $cart->updateTotalAmount();

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(CartItem $cartItem)
    {
        // Ensure the cart item belongs to the current user's cart
        $cart = $this->getCart();
        if ($cartItem->cart_id !== $cart->id) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }

        $cartItem->delete();

        // Update cart total
        $cart->updateTotalAmount();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    /**
     * Clear the cart.
     */
    public function clearCart()
    {
        $cart = $this->getCart();
        $cart->items()->delete();
        $cart->total_amount = 0;
        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }

    /**
     * Get the current user's cart or create a new one.
     */
    protected function getCart()
    {
        if (Auth::check()) {
            // For authenticated users
            return Cart::getCurrentCart(Auth::id());
        } else {
            // For guests, use session ID
            $sessionId = Session::get('cart_session_id');
            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
                Session::put('cart_session_id', $sessionId);
            }
            return Cart::getCurrentCart(null, $sessionId);
        }
    }
}