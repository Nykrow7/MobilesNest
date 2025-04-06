@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Payment Form -->
        <div class="md:w-2/3">
            <h1 class="text-2xl font-bold mb-6">Payment Details</h1>
            
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('transactions.process', $order) }}" method="POST" id="payment-form">
                @csrf
                
                <!-- Payment Information -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Payment Method: {{ ucfirst($order->payment_method) }}</h2>
                    
                    @if ($order->payment_method === 'credit_card')
                        <div class="space-y-4">
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required maxlength="19" pattern="\d{4}\s?\d{4}\s?\d{4}\s?\d{4}">
                                @error('card_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="card_expiry" class="block text-sm font-medium text-gray-700">Expiration Date</label>
                                    <input type="text" name="card_expiry" id="card_expiry" placeholder="MM/YY" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required maxlength="5" pattern="(0[1-9]|1[0-2])\/([0-9]{2})">
                                    @error('card_expiry')
<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="card_cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                    <input type="password" name="card_cvv" id="card_cvv" placeholder="123" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required maxlength="4" pattern="\d{3,4}">
                                    @error('card_cvv')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="card_name" class="block text-sm font-medium text-gray-700">Name on Card</label>
                                <input type="text" name="card_name" id="card_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required pattern="[A-Za-z\s]+" maxlength="255">
                                @error('card_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @elseif ($order->payment_method === 'paypal')
                        <div>
                            <label for="paypal_email" class="block text-sm font-medium text-gray-700">PayPal Email</label>
                            <input type="email" name="paypal_email" id="paypal_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('paypal_email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @elseif ($order->payment_method === 'bank_transfer')
                        <div class="space-y-4">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required pattern="[A-Za-z\s]+" maxlength="100">
                                @error('bank_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="reference" class="block text-sm font-medium text-gray-700">Reference Number</label>
                                <input type="text" name="reference" id="reference" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required pattern="[A-Za-z0-9-]+" maxlength="50">
                                @error('reference')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="bg-yellow-50 p-4 rounded-md">
                                <p class="text-sm text-yellow-700">
                                    Please make a bank transfer to the following account and provide the reference number above:
                                </p>
                                <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside">
                                    <li>Bank: Example Bank</li>
                                    <li>Account Name: MobilesNest</li>
                                    <li>Account Number: 1234567890</li>
                                    <li>Sort Code: 12-34-56</li>
                                    <li>Reference: {{ $order->order_number }}</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="flex justify-between items-center">
                    <a href="{{ route('checkout.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Back to Shipping
                    </a>
                    
                    <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Complete Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
