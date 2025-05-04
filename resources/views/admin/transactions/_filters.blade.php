<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 text-black font-medium"><i class="fas fa-filter me-2"></i>Filter Transactions</h6>
    </div>
    <div class="card-body bg-white">
        <form action="{{ route('admin.transactions.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-black mb-1">Status</label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <!-- Payment Method Filter -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-black mb-1">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All Methods</option>
                        <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="paypal" {{ request('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                </div>

                <!-- Date From Filter -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-black mb-1">Date From</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                </div>

                <!-- Date To Filter -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-black mb-1">Date To</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>

                <!-- Search Filter -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-black mb-1">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="search" name="search" value="{{ request('search') }}" placeholder="Transaction/order number or customer name">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 mt-4">
                <a href="{{ route('admin.transactions.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-black font-medium rounded-md transition duration-150 ease-in-out">
                    <i class="fas fa-undo me-2"></i> Reset
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition duration-150 ease-in-out shadow-sm">
                    <i class="fas fa-filter me-2"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>
</div>