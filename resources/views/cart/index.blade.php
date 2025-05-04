@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="page-container">
        <div class="content-section">
            <h1 class="heading-lg mb-6 text-gray-900">Your Shopping Cart</h1>

                @if(session('success'))
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-4 mb-6 rounded-r-md shadow-sm" role="alert">
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
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-md shadow-sm" role="alert">
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
                    <div class="card-flat text-center py-12">
                        <div class="bg-blue-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <svg class="h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="heading-md mb-3">Your cart is empty</h3>
                        <p class="paragraph mb-8 max-w-md mx-auto">Start shopping to add items to your cart and discover our latest smartphone offerings.</p>
                        <div>
                            <a href="{{ route('shop.index') }}" class="btn-primary inline-flex items-center px-6 py-3 rounded-lg shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                @else
                    <div class="table-container overflow-x-auto mb-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th scope="col" class="table-header">Product</th>
                                    <th scope="col" class="table-header">Price</th>
                                    <th scope="col" class="table-header">Quantity</th>
                                    <th scope="col" class="table-header">Total</th>
                                    <th scope="col" class="table-header">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cart->items as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="table-cell">
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
                                    <td class="table-cell">
                                        <div class="text-sm text-gray-800 font-medium">@peso($item->price)</div>
                                    </td>
                                    <td class="table-cell">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                                                <button type="button" onclick="decrementQuantity(this)" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-12 text-center border-0 focus:ring-0">
                                                <button type="button" onclick="incrementQuantity(this)" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800 bg-blue-50 p-1 rounded-full">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="table-cell font-semibold text-gray-900">
                                        @peso($item->price * $item->quantity)
                                    </td>
                                    <td class="table-cell text-right">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium bg-red-50 px-3 py-1 rounded-full text-sm transition-colors duration-200">
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

                    <div class="divider"></div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="card-accent p-4 flex items-center">
                            <div class="mr-4">
                                <span class="text-sm text-gray-600 block mb-1">Cart Total:</span>
                                <span class="text-2xl font-bold text-gray-900">{{ $cart->formatted_total_amount }}</span>
                            </div>
                            <svg class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('shop.index') }}" class="btn-secondary inline-flex items-center justify-center px-6 py-3 rounded-lg shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Continue Shopping
                            </a>
                            <a href="{{ route('checkout.index') }}" class="btn-primary inline-flex items-center justify-center px-6 py-3 rounded-lg shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                                Proceed to Checkout
                            </a>
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