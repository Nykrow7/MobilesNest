@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold mb-6">Your Shopping Cart</h1>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                
                @if($cart && $cart->items->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr>
                                    <td class="py-4 px-4 border-b border-gray-200">
                                        <div class="flex items-center">
                                            @if($item->product->primaryImage)
                                                <img class="h-12 w-12 mr-4 object-cover rounded" src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}">
                                            @else
                                                <div class="h-12 w-12 mr-4 bg-gray-200 rounded flex items-center justify-center">
                                                    <span class="text-gray-500 text-xs">No image</span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm leading-5 font-medium text-gray-900">{{ $item->product->name }}</div>
                                                <div class="text-sm leading-5 text-gray-500">{{ $item->product->brand }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm leading-5">
                                        {{ $item->formatted_unit_price }}
                                        @php
                                            $regularPrice = $item->product->price;
                                            $currentPrice = $item->unit_price;
                                            $hasBulkDiscount = $currentPrice < $regularPrice;
                                        @endphp
                                        
                                        @if($hasBulkDiscount)
                                            <div class="text-xs text-green-600 font-semibold mt-1">
                                                Bulk discount applied!
                                                <span class="line-through text-gray-500">${{ number_format($regularPrice, 2) }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200">
                                        <form action="{{ route('cart.update-quantity', $item) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}" class="form-input w-16 rounded-md shadow-sm">
                                            <button type="submit" class="ml-2 text-sm text-blue-600 hover:text-blue-800">Update</button>
                                        </form>
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm leading-5 text-gray-500">
                                        {{ $item->formatted_subtotal }}
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm leading-5 font-medium">
                                        <form action="{{ route('cart.remove-item', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="py-4 px-4 text-right font-medium">Total:</td>
                                    <td class="py-4 px-4 font-bold text-lg">{{ $cart->formatted_total_amount }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="mt-6 flex justify-between">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Clear Cart
                            </button>
                        </form>
                        
                        <a href="{{ route('checkout') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                            Proceed to Checkout
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">Your cart is empty.</p>
                        <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                            Continue Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection