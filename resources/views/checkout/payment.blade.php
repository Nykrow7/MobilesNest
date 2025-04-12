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
                    <h2 class="text-xl font-semibold mb-4">Payment Method: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</h2>

                    @if ($order->payment_method === 'gcash')
                        <div class="space-y-4">
                            <div class="bg-blue-50 p-4 rounded-lg mb-4">
                                <div class="flex items-center mb-3">
                                    <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold mr-2">GCash</span>
                                    <h3 class="text-blue-800 font-medium">GCash Payment Instructions</h3>
                                </div>
                                <ol class="list-decimal pl-5 text-sm text-blue-800 space-y-2">
                                    <li>Open your GCash app on your mobile phone</li>
                                    <li>Send payment to GCash number: <strong>09123456789</strong></li>
                                    <li>Enter the exact amount: <strong>₱{{ number_format($order->final_amount, 2) }}</strong></li>
                                    <li>Use your Order Number <strong>{{ $order->order_number }}</strong> as reference</li>
                                    <li>Enter your GCash number and reference number below to complete your order</li>
                                </ol>
                            </div>

                            <div>
                                <label for="gcash_number" class="block text-sm font-medium text-gray-700">Your GCash Number</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">+63</span>
                                    <input type="text" name="gcash_number" id="gcash_number" placeholder="9123456789" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required maxlength="10" pattern="[0-9]{10}">
                                </div>
                                @error('gcash_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="reference" class="block text-sm font-medium text-gray-700">GCash Reference Number</label>
                                <input type="text" name="reference" id="reference" placeholder="e.g. 1234567890" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required maxlength="50">
                                <p class="text-xs text-gray-500 mt-1">The reference number provided by GCash after your payment</p>
                                @error('reference')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @elseif ($order->payment_method === 'cash_on_delivery')
                        <div class="space-y-4">
                            <div class="bg-green-50 p-4 rounded-lg mb-4">
                                <div class="flex items-center mb-3">
                                    <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-bold mr-2">COD</span>
                                    <h3 class="text-green-800 font-medium">Cash on Delivery Information</h3>
                                </div>
                                <ul class="list-disc pl-5 text-sm text-green-800 space-y-2">
                                    <li>Your order will be delivered to your shipping address</li>
                                    <li>Payment of <strong>₱{{ number_format($order->final_amount, 2) }}</strong> will be collected upon delivery</li>
                                    <li>Please prepare the exact amount if possible</li>
                                    <li>You can add delivery instructions below</li>
                                </ul>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Delivery Instructions (Optional)</label>
                                <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" maxlength="255" placeholder="Special instructions for delivery (e.g., landmark, preferred delivery time)"></textarea>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentForm = document.getElementById('payment-form');

        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading state
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';

            // Submit the form
            setTimeout(() => {
                this.submit();
            }, 500);
        });
    });
</script>
@endpush