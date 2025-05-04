@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-green-50 border border-green-200 rounded-lg shadow-lg p-8 max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-green-800">Payment Successful!</h1>
            <p class="text-green-700 mt-2 text-lg">Thank you for your purchase. Your order has been received and is being processed.</p>
        </div>

        <div class="bg-white rounded-lg border border-green-100 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-2">Order Information</h3>
                    <div class="space-y-2">
                        <p class="flex justify-between">
                            <span class="text-gray-600">Order Number:</span>
                            <span class="font-semibold">{{ $order->order_number }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-semibold">{{ $order->created_at->format('F d, Y') }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-600">Total Amount:</span>
                            <span class="font-semibold">{{ $order->formatted_final_amount }}</span>
                        </p>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-2">Payment Details</h3>
                    <div class="space-y-2">
                        <p class="flex justify-between">
                            <span class="text-gray-600">Payment Method:</span>
                            <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-600">Payment Status:</span>
                            <span class="font-semibold text-green-600">Paid</span>
                        </p>
                        @if($transaction)
                        <p class="flex justify-between">
                            <span class="text-gray-600">Transaction ID:</span>
                            <span class="font-semibold">{{ $transaction->transaction_number }}</span>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center space-y-4">
            <p class="text-gray-600">You will be redirected to the shop in <span id="countdown">5</span> seconds...</p>
            
            <div class="flex justify-center space-x-4">
                <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    View Order Details
                </a>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Countdown and redirect
    document.addEventListener('DOMContentLoaded', function() {
        let seconds = 5;
        const countdownElement = document.getElementById('countdown');
        
        const interval = setInterval(function() {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = "{{ route('shop.index') }}";
            }
        }, 1000);
    });
</script>
@endsection
