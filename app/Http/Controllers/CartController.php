<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the user's cart
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart
     * @param Request $request
     * @param Product|null $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request, $product = null)
    {
        // If product is passed in URL, use it; otherwise get from request
        if ($product) {
            $productId = $product;
        } else {
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);
            $productId = $request->product_id;
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'buy_now' => 'sometimes|boolean'
        ]);

        $product = Product::findOrFail($productId);

        // Check if product is in stock
        if ($product->inventory && $product->inventory->quantity < $request->quantity) {
            return back()->with('error', 'Sorry, this product is out of stock or has insufficient quantity.');
        }

        // Get or create cart
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);

        // Check if product already in cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity if product already in cart
            $cartItem->quantity += $request->quantity;
            // Update subtotal based on new quantity
            $cartItem->subtotal = $cartItem->price * $cartItem->quantity;
            $cartItem->save();
        } else {
            // Add new item to cart
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'unit_price' => $product->price,
                'subtotal' => $product->price * $request->quantity
            ]);
        }

        // Update cart total
        $cart->updateTotalAmount();

        // If buy_now is set, redirect to checkout
        if ($request->has('buy_now')) {
            return redirect()->route('checkout.index')->with('success', 'Product added to cart. Proceed with checkout.');
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    /**
     * Remove an item from the cart
     */
    public function remove($itemId)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cart->items()->where('id', $itemId)->delete();
            $cart->updateTotalAmount();
            return back()->with('success', 'Item removed from cart.');
        }

        return back()->with('error', 'Item could not be removed.');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cartItem = $cart->items()->findOrFail($itemId);
            $cartItem->quantity = $request->quantity;
            $cartItem->subtotal = $cartItem->price * $cartItem->quantity;
            $cartItem->save();

            // Update cart total
            $cart->updateTotalAmount();

            return back()->with('success', 'Cart updated successfully.');
        }

        return back()->with('error', 'Cart could not be updated.');
    }

    /**
     * Clear all items from the cart
     */
    public function clear()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cart->items()->delete();
            $cart->total_amount = 0;
            $cart->save();
            return back()->with('success', 'Cart cleared successfully.');
        }

        return back()->with('error', 'Cart could not be cleared.');
    }
}