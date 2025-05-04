@extends('layouts.app')

@section('content')
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile filter toggle functionality
        const filterToggle = document.getElementById('filterToggle');
        const filterSidebar = document.getElementById('filterSidebar');
        const closeFilters = document.getElementById('closeFilters');

        if (filterToggle && filterSidebar) {
            filterToggle.addEventListener('click', function() {
                filterSidebar.classList.remove('hidden');
                filterSidebar.classList.add('fixed', 'inset-0', 'z-50', 'bg-white', 'p-4', 'overflow-y-auto');
                document.body.classList.add('overflow-hidden');
            });

            if (closeFilters) {
                closeFilters.addEventListener('click', function() {
                    filterSidebar.classList.add('hidden');
                    filterSidebar.classList.remove('fixed', 'inset-0', 'z-50', 'bg-white', 'p-4', 'overflow-y-auto');
                    document.body.classList.remove('overflow-hidden');
                });
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) { // md breakpoint
                    filterSidebar.classList.remove('hidden', 'fixed', 'inset-0', 'z-50', 'bg-white', 'p-4', 'overflow-y-auto');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    if (!filterSidebar.classList.contains('fixed')) {
                        filterSidebar.classList.add('hidden');
                    }
                }
            });
        }
    });
</script>
@endpush
<!-- Success Message -->
@if (session('success'))
<div class="fixed top-20 left-0 right-0 mx-auto max-w-3xl z-50 bg-primary-50 border border-primary-200 text-primary-800 p-4 rounded-lg shadow-lg" role="alert" id="success-message">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="py-1">
                <svg class="w-6 h-6 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="font-medium text-lg">{{ session('success') }}</p>
                @if(session('last_transaction_id'))
                <p class="text-sm mt-1 text-primary-600">
                    Your transaction has been recorded. An administrator will process your order shortly.
                </p>
                @endif
            </div>
        </div>
        <button type="button" class="text-primary-600 hover:text-primary-800" onclick="document.getElementById('success-message').remove()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    // Auto-scroll to phone grid and auto-dismiss success message after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('success-message')) {
            // Scroll to phone grid
            document.getElementById('phone-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                const message = document.getElementById('success-message');
                if (message) {
                    message.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(function() {
                        if (message.parentNode) {
                            message.remove();
                        }
                    }, 500);
                }
            }, 5000);
        }
    });
</script>
@endif

<!-- Hero Section -->
<div class="relative header-gradient border-b border-blue-100 shadow-sm">
    <div class="container mx-auto px-4 py-16 md:py-24">
        <div class="max-w-3xl">
            <div class="inline-block bg-blue-50 px-3 py-1 rounded-full text-blue-700 text-sm font-medium mb-4 shadow-sm">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Premium Quality Smartphones
                </span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900 leading-tight">Discover the Latest Smartphones</h1>
            <p class="text-xl mb-8 text-gray-700 leading-relaxed">Find the perfect device that matches your style and needs with our curated collection of premium smartphones.</p>
            <div class="flex space-x-4">
                <a href="#phone-grid" class="btn-primary px-6 py-3 rounded-md font-semibold transition duration-200 inline-flex items-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                    Browse Phones
                </a>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white to-transparent"></div>
</div>

<div class="container mx-auto px-4 py-12" id="phone-grid">
    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-8 mb-10">
        <!-- Mobile Filter Toggle -->
        <div class="md:hidden mb-4">
            <button id="filterToggle" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md flex items-center justify-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Show Filters
            </button>
        </div>

        <!-- Sidebar Filters -->
        <div id="filterSidebar" class="w-full md:w-1/4 md:block hidden">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 md:sticky md:top-24">
                <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filters
                    </h2>
                    <button type="button" id="closeFilters" class="md:hidden text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('shop.index') }}" method="GET" class="space-y-6">
                    <!-- Brand Filter -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                        <div class="relative">
                            <select id="brand" name="brand" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search by name, brand, specs..." class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                            @if(request('search'))
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="document.getElementById('search').value = ''; this.closest('form').submit();" class="text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Try searching for brand names, features, or specifications</p>
                        @if(request('search'))
                        <div class="mt-2 bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-md inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Showing results for: "{{ request('search') }}"
                        </div>
                        @endif
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-col space-y-3">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-md transition duration-200 flex items-center justify-center shadow-sm text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Apply Filters
                            </button>
                            <a href="{{ route('shop.index') }}" class="w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2.5 px-4 rounded-md transition duration-200 flex items-center justify-center shadow-sm text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                </svg>
                                Clear Filters
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="w-full md:w-3/4">
            <!-- Results Summary -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
                @if(request('search'))
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-1">Search Results for "{{ request('search') }}"</h2>
                        <p class="text-sm text-gray-600">Showing products that match your search criteria</p>
                    </div>
                    <div class="flex items-center mt-3 sm:mt-0">
                        <span class="bg-blue-50 text-blue-700 text-sm font-medium px-3 py-1 rounded-md mr-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $phones->total() }} {{ Str::plural('result', $phones->total()) }}
                        </span>
                        <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-blue-700 text-sm flex items-center bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-md transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear search
                        </a>
                    </div>
                </div>
                @else
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-1">Available Smartphones</h2>
                        <p class="text-sm text-gray-600">Browse our collection of premium smartphones</p>
                    </div>
                    <div class="bg-blue-50 text-blue-700 text-sm font-medium px-3 py-1 rounded-md mt-3 sm:mt-0 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ $phones->total() }} {{ Str::plural('product', $phones->total()) }} found
                    </div>
                </div>
                @endif
            </div>

            <!-- Phones Grid -->
            <div id="phone-grid">
            @if($phones->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($phones as $phone)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden flex flex-col h-full transition-all duration-300 hover:shadow-md">
                    <div class="relative overflow-hidden">
                        <a href="{{ route('shop.show', $phone->slug) }}" class="block">
                            @if($phone->primaryImage)
                            <img src="{{ asset('storage/' . $phone->primaryImage->image_path) }}" alt="{{ $phone->name }}" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-105">
                            @else
                            <div class="w-full h-56 bg-gray-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif

                            @if($phone->is_featured)
                            <div class="absolute top-0 right-0 mt-3 mr-3">
                                <span class="bg-blue-600 text-white text-xs font-medium px-2.5 py-0.5 rounded-md flex items-center shadow-sm">
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
                            <div class="flex items-center mb-2">
                                <span class="text-xs font-medium text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-md">{{ $phone->brand }}</span>
                            </div>
                            <a href="{{ route('shop.show', $phone->slug) }}" class="block">
                                <h3 class="text-lg font-medium text-gray-900 mb-2 hover:text-blue-700 transition-colors duration-200">{{ $phone->name }}</h3>
                            </a>
                            <div class="mt-2 flex items-center">
                                <div class="flex text-yellow-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-500 ml-2">(5.0)</span>
                            </div>
                        </div>

                        <div class="mt-4 border-t border-gray-100 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-900">@peso($phone->price)</span>
                                <a href="{{ route('shop.show', $phone->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>

                        @if($phone->inventory && $phone->inventory->quantity > 0)
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <form action="{{ route('cart.add', $phone->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-3 rounded-md transition-colors duration-200 flex items-center justify-center shadow-sm">
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
                                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium py-2 px-3 rounded-md transition-colors duration-200 flex items-center justify-center shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Buy Now
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="mt-4">
                            <span class="block w-full bg-gray-100 text-gray-700 text-sm font-medium py-2 px-3 rounded-md text-center border border-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Out of Stock
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                {{ $phones->withQueryString()->links() }}
            </div>
            @else
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8 text-center">
                <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                @if(request('search'))
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No phones found matching "{{ request('search') }}"</h3>
                    <p class="text-gray-600 mb-6">Try using different keywords or check your spelling</p>
                @else
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">No phones found matching your criteria.</h3>
                @endif
                <a href="{{ route('shop.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-md transition-colors duration-200 inline-flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Clear all filters
                </a>
            </div>
            @endif
        </div>
        </div>
    </div>
</div>
@endsection