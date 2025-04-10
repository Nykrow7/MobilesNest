@extends('layouts.app')

@section('content')
<!-- Success Message -->
@if (session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
    <div class="flex items-center">
        <div class="py-1"><i class="fas fa-check-circle text-green-500 mr-2"></i></div>
        <div>
            <p class="font-medium">{{ session('success') }}</p>
            @if(session('last_transaction_id'))
            <p class="text-sm mt-1">
                Your transaction has been recorded. An administrator will process your order shortly.
            </p>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-blue-900 to-blue-600">
    <div class="container mx-auto px-4 py-16 md:py-24">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-black !text-black" style="color: black !important;">Discover the Latest Smartphones</h1>
            <p class="text-xl mb-8 text-black !text-black" style="color: black !important;">Find the perfect device that matches your style and needs</p>
            <div class="flex space-x-4">
                <a href="#phone-grid" class="bg-white text-black !text-black hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition duration-200 inline-flex items-center" style="color: black !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                    Browse Phones
                </a>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-gray-100 to-transparent"></div>
</div>

<div class="container mx-auto px-4 py-12" id="phone-grid">
    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-8 mb-10">
        <!-- Sidebar Filters -->
        <div class="w-full md:w-1/4">
            <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Filters</h2>
                <form action="{{ route('shop.index') }}" method="GET">
                    <!-- Brand Filter -->
                    <div class="mb-6">
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                        <select id="brand" name="brand" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="mb-6">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search by name, brand, specs..." class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Try searching for brand names, features, or specifications like "Samsung", "5G", "camera", etc.</p>
                    </div>

                    <!-- Submit and Clear Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Apply Filters
                        </button>
                        <a href="{{ route('shop.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="w-full md:w-3/4">
            <!-- Results Summary -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Available Phones</h2>
                <p class="text-gray-600">{{ $phones->total() }} products found</p>
            </div>

            <!-- Phones Grid -->
            @if($phones->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($phones as $phone)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-md transition-all duration-300 border border-gray-100 flex flex-col h-full">
                    <div class="relative overflow-hidden">
                        <a href="{{ route('shop.show', $phone->slug) }}">
                            @if($phone->primaryImage)
                            <img src="{{ asset('storage/' . $phone->primaryImage->image_path) }}" alt="{{ $phone->name }}" class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                            <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif

                            @if($phone->is_featured)
                            <div class="absolute top-0 right-0 mt-3 mr-3">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Featured
                                </span>
                            </div>
                            @endif
                        </a>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex-grow">
                            <a href="{{ route('shop.show', $phone->slug) }}">
                                <div class="flex items-center mb-2">
                                    <span class="text-sm font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">{{ $phone->brand }}</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors duration-200">{{ $phone->name }}</h3>
                            </a>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-blue-600">@peso($phone->price)</span>
                            <a href="{{ route('shop.show', $phone->slug) }}" class="inline-flex items-center justify-center bg-blue-100 text-blue-800 rounded-full w-8 h-8 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>

                        @if($phone->inventory && $phone->inventory->quantity > 0)
                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <form action="{{ route('cart.add', $phone->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-3 rounded-lg transition duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>

                            <form action="{{ route('cart.add', $phone->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="buy_now" value="1">
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-3 rounded-lg transition duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Buy Now
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="mt-4">
                            <span class="block w-full bg-gray-200 text-gray-600 text-sm font-medium py-2 px-3 rounded-lg text-center">Out of Stock</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $phones->withQueryString()->links() }}
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm p-10 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-600 text-lg mb-4">No phones found matching your criteria.</p>
                <a href="{{ route('shop.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">Clear all filters</a>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection