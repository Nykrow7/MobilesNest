@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold mb-6">Checkout</h1>
                
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Order Summary -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-medium mb-4">Order Summary</h2>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                    <tr>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            <div class="flex items-center">
                                                @if($item->product->primaryImage)
                                                    <img class="h-10 w-10 mr-2 object-cover rounded" src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}">
                                                @else
                                                    <div class="h-10 w-10 mr-2 bg-gray-200 rounded flex items-center justify-center">
                                                        <span class="text-gray-500 text-xs">No image</span>
                                                    </div>
                                                @endif
                                                <div class="text-sm leading-5 font-medium text-gray-900">{{ $item->product->name }}</div>
                                            </div>
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200 text-sm leading-5 text-gray-500">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200 text-sm leading-5 text-gray-500">
                                            {{ $item->formatted_subtotal }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="py-2 px-4 text-right font-medium">Total:</td>
                                        <td class="py-2 px-4 font-bold">{{ $cart->formatted_total_amount }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Checkout Form -->
                    <div>
                        <h2 class="text-lg font-medium mb-4">Shipping & Payment Information</h2>
                        
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Shipping Address</label>
                                <textarea id="shipping_address" name="shipping_address" rows="3" class="form-textarea mt-1 block w-full rounded-md shadow-sm" required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                <select id="payment_method" name="payment_method" class="form-select mt-1 block w-full rounded-md shadow-sm" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                                </select>
                                @error('payment_method')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                                <textarea id="notes" name="notes" rows="2" class="form-textarea mt-1 block w-full rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            </div>
                            
                            <div class="flex items-center justify-between mt-6">
                                <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800">
                                    &larr; Back to Cart
                                </a>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection