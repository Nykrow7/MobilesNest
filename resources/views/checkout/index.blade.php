@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(isset($requiresLogin) && $requiresLogin)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
        <p class="font-bold">Login Required</p>
        <p>You need to <a href="{{ route('login') }}" class="underline font-semibold">login</a> or <a href="{{ route('register') }}" class="underline font-semibold">register</a> to complete your purchase.</p>
    </div>
    @endif

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Checkout Form -->
        <div class="md:w-2/3">
            <h1 class="text-2xl font-bold mb-6">Checkout</h1>

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf

                <!-- Shipping Information -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                    <p class="text-sm text-gray-500 mb-4">Please provide accurate shipping details to ensure smooth delivery.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Billing Information -->
                        <div class="md:col-span-2 mb-2">
                            <h3 class="text-lg font-medium text-gray-800">Billing Information</h3>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Shipping Recipient Information -->
                        <div class="md:col-span-2 mt-4 mb-2">
                            <h3 class="text-lg font-medium text-gray-800">Recipient Information</h3>
                            <div class="flex items-center mt-2">
                                <input type="checkbox" id="same_as_billing" name="same_as_billing" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                                <label for="same_as_billing" class="ml-2 block text-sm text-gray-700">Same as billing information</label>
                            </div>
                        </div>

                        <div id="recipient_fields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
                            <div>
                                <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-1">Recipient Name</label>
                                <input type="text" id="recipient_name" name="recipient_name" value="{{ old('recipient_name') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('recipient_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="recipient_phone" class="block text-sm font-medium text-gray-700 mb-1">Recipient Phone</label>
                                <input type="text" id="recipient_phone" name="recipient_phone" value="{{ old('recipient_phone') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('recipient_phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="md:col-span-2 mt-4 mb-2">
                            <h3 class="text-lg font-medium text-gray-800">Shipping Address</h3>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                            <input type="text" id="state" name="state" value="{{ old('state') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('state')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal/ZIP Code</label>
                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('postal_code')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <input type="text" id="country" name="country" value="{{ old('country', 'Philippines') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('country')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="shipping_notes" class="block text-sm font-medium text-gray-700 mb-1">Delivery Instructions (Optional)</label>
                            <textarea id="shipping_notes" name="shipping_notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('shipping_notes') }}</textarea>
                            @error('shipping_notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Payment Method</h2>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input id="payment_method_gcash" name="payment_method" type="radio" value="gcash" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('payment_method') == 'gcash' ? 'checked' : '' }} required>
                            <label for="payment_method_gcash" class="ml-3 block text-sm font-medium text-gray-700 flex items-center">
                                <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold mr-2">GCash</span>
                                GCash Mobile Payment
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input id="payment_method_cash_on_delivery" name="payment_method" type="radio" value="cash_on_delivery" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }}>
                            <label for="payment_method_cash_on_delivery" class="ml-3 block text-sm font-medium text-gray-700 flex items-center">
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-bold mr-2">COD</span>
                                Cash on Delivery
                            </label>
                        </div>
                    </div>

                    @error('payment_method')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Place Order
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="md:w-1/3">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                <div class="divide-y divide-gray-200">
                    @foreach($cart->items as $item)
                    <div class="py-4 flex">
                        <div class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-md overflow-hidden">
                            @if($item->product->primaryImage)
                                <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <span class="text-gray-500 text-xs">No image</span>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">@peso($item->price * $item->quantity)</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Subtotal</span>
                        <span>{{ $cart->formatted_total_amount }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="flex justify-between text-base font-medium text-gray-900 mt-4 pt-4 border-t border-gray-200">
                        <span>Total</span>
                        <span>{{ $cart->formatted_total_amount }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('cart.index') }}" class="block text-center text-sm text-blue-600 hover:text-blue-500">
                        &larr; Return to Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle recipient information toggle
        const sameAsBillingCheckbox = document.getElementById('same_as_billing');
        const recipientFields = document.getElementById('recipient_fields');
        const recipientName = document.getElementById('recipient_name');
        const recipientPhone = document.getElementById('recipient_phone');

        function toggleRecipientFields() {
            if (sameAsBillingCheckbox.checked) {
                recipientFields.style.display = 'none';
                recipientName.required = false;
                recipientPhone.required = false;
            } else {
                recipientFields.style.display = 'grid';
                recipientName.required = true;
                recipientPhone.required = true;
            }
        }

        // Initial state
        toggleRecipientFields();

        // Handle checkbox change
        sameAsBillingCheckbox.addEventListener('change', toggleRecipientFields);
    });
</script>
@endpush