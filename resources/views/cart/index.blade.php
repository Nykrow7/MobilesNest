@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="page-container">
        <div class="content-section">
            <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
                <h1 class="heading-lg mb-0 text-gray-900">Your Shopping Cart</h1>
                <a href="{{ route('shop.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Continue Shopping
                </a>
            </div>

            @if(session('success'))
                <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(!$cart || $cart->items->isEmpty())
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8 text-center my-8">
                    <div class="bg-blue-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <svg class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Your cart is empty</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Start shopping to add items to your cart and discover our latest smartphone offerings.</p>
                    <a href="{{ route('shop.index') }}" class="btn-primary inline-flex items-center px-6 py-3 rounded-md shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Browse Products
                    </a>
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-8">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cart->items as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-16 w-16 rounded-md object-cover border border-gray-200 shadow-sm" src="{{ $item->product->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                            <div class="text-xs text-gray-500 mt-1">{{ $item->product->brand ?? 'Brand' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">@peso($item->price)</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center border border-gray-300 rounded-md shadow-sm">
                                            <button type="button" onclick="decrementQuantity(this)" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 focus:outline-none">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-12 text-center border-0 focus:ring-0 focus:outline-none">
                                            <button type="button" onclick="incrementQuantity(this)" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 focus:outline-none">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                        <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800 bg-blue-50 p-1.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">@peso($item->price * $item->quantity)</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800 font-medium bg-red-50 px-3 py-1.5 rounded-md text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-200">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <script>
                    function incrementQuantity(button) {
                        const input = button.parentNode.querySelector('input');
                        input.value = parseInt(input.value) + 1;
                    }

                    function decrementQuantity(button) {
                        const input = button.parentNode.querySelector('input');
                        const value = parseInt(input.value);
                        if (value > 1) {
                            input.value = value - 1;
                        }
                    }
                </script>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
                    <!-- Order Summary -->
                    <div class="lg:col-span-2">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Order Summary</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium text-gray-900">{{ $cart->formatted_total_amount }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium text-gray-900">Calculated at checkout</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3 mt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-900">Total</span>
                                        <span class="text-xl font-bold text-gray-900">{{ $cart->formatted_total_amount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Actions -->
                    <div class="lg:col-span-1">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                            <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                                <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">Checkout</h3>
                            </div>
                            <div class="space-y-4">
                                <a href="{{ route('checkout.index') }}" class="w-full btn-primary inline-flex items-center justify-center px-6 py-3 rounded-md shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                    Proceed to Checkout
                                </a>
                                <a href="{{ route('shop.index') }}" class="w-full btn-secondary inline-flex items-center justify-center px-6 py-3 rounded-md shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Add any additional scripts here
</script>
@endpush

@endsection