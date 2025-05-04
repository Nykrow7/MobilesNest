@extends('admin.layouts.app')

@section('admin-content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">User Details</h2>
                    <div class="space-x-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 mb-3">User Information</h3>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <div class="mb-3">
                                    <span class="block text-sm font-medium text-gray-500">Name</span>
                                    <span class="block text-base font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="block text-sm font-medium text-gray-500">Email</span>
                                    <span class="block text-base text-gray-900">{{ $user->email }}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="block text-sm font-medium text-gray-500">Role</span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-sm font-medium text-gray-500">Registered On</span>
                                    <span class="block text-base text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-700 mb-3">Account Activity</h3>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <div class="mb-3">
                                    <span class="block text-sm font-medium text-gray-500">Last Login</span>
                                    <span class="block text-base text-gray-900">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="block text-sm font-medium text-gray-500">Last Updated</span>
                                    <span class="block text-base text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-medium text-gray-500">Email Verified</span>
                                    <span class="block text-base text-gray-900">
                                        @if($user->email_verified_at)
                                            <span class="text-green-600">
                                                <i class="fas fa-check-circle mr-1"></i> 
                                                Verified on {{ $user->email_verified_at->format('M d, Y') }}
                                            </span>
                                        @else
                                            <span class="text-red-600">
                                                <i class="fas fa-times-circle mr-1"></i> 
                                                Not verified
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($user->orders && $user->orders->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-700 mb-3">Order History</h3>
                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($user->orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->formatted_total_amount }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{!! $order->status_badge !!}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
