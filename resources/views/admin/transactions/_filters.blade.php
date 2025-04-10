<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 text-indigo-700 font-medium"><i class="fas fa-filter me-2"></i>Filter Transactions</h6>
    </div>
    <div class="card-body bg-white">
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label text-gray-600 text-sm font-medium">Status</label>
                <select name="status" id="status" class="form-select shadow-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="payment_method" class="form-label text-gray-600 text-sm font-medium">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-select shadow-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Methods</option>
                    <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                    <option value="paypal" {{ request('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="date_from" class="form-label text-gray-600 text-sm font-medium">Date From</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" class="form-control pl-10 shadow-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
            </div>

            <div class="col-md-3">
                <label for="date_to" class="form-label text-gray-600 text-sm font-medium">Date To</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" class="form-control pl-10 shadow-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
            </div>

            <div class="col-md-4">
                <label for="search" class="form-label text-gray-600 text-sm font-medium">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" class="form-control pl-10 shadow-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="search" name="search" value="{{ request('search') }}" placeholder="Transaction/order number or customer name">
                </div>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn w-100 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-sm">
                    <i class="fas fa-filter me-2"></i> Apply Filters
                </button>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <a href="{{ route('admin.transactions.index') }}" class="btn w-100 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-undo me-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>