@extends('admin.layouts.app')

@section('admin-content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Edit Order #{{ $order->order_number }}</h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Orders
                    </a>
                </div>

                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="status" name="status">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="shipping_status" class="block text-sm font-medium text-gray-700 mb-1">Shipping Status</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="shipping_status" name="shipping_status">
                                <option value="pending" {{ $order->shipping_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shipped" {{ $order->shipping_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->shipping_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                            @error('shipping_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-1">Tracking Number</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="tracking_number" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}">
                            @error('tracking_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="estimated_delivery_date" class="block text-sm font-medium text-gray-700 mb-1">Estimated Delivery Date</label>
                            <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="estimated_delivery_date" name="estimated_delivery_date" value="{{ old('estimated_delivery_date', $order->estimated_delivery_date ? $order->estimated_delivery_date->format('Y-m-d') : '') }}">
                            @error('estimated_delivery_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Admin Notes</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="notes" name="notes" rows="3">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mt-6">
                        <h3 class="text-lg font-medium text-gray-700 mb-3">Shipping Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Recipient Information</h4>
                                <div class="bg-white p-3 rounded border border-gray-200">
                                    <p class="text-sm mb-1"><span class="font-medium">Name:</span> {{ $order->recipient_name }}</p>
                                    <p class="text-sm mb-1"><span class="font-medium">Phone:</span> {{ $order->recipient_phone }}</p>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Address</h4>
                                <div class="bg-white p-3 rounded border border-gray-200">
                                    <p class="text-sm">{{ $order->shipping_address }}</p>
                                </div>
                            </div>
                        </div>

                        @if($order->shipping_notes)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Delivery Instructions</h4>
                            <div class="bg-white p-3 rounded border border-gray-200">
                                <p class="text-sm">{{ $order->shipping_notes }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Shipping Dates</h4>
                            <div class="bg-white p-3 rounded border border-gray-200">
                                @if($order->shipped_at)
                                    <p class="text-sm mb-1"><span class="font-medium">Shipped Date:</span> {{ $order->shipped_at->format('M d, Y') }}</p>
                                @endif
                                @if($order->delivered_at)
                                    <p class="text-sm mb-1"><span class="font-medium">Delivered Date:</span> {{ $order->delivered_at->format('M d, Y') }}</p>
                                @endif
                                @if(!$order->shipped_at && !$order->delivered_at)
                                    <p class="text-sm text-gray-500">No shipping dates recorded yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-700 mb-3">Order Items</h3>
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->formatted_unit_price }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->formatted_subtotal }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">Total:</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->formatted_total_amount }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</a>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
