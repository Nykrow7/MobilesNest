@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Breadcrumbs -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Shop
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $phone->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="md:flex">
            <!-- Product Images -->
            <div class="md:w-1/2 p-6">
                @if($phone->images->isNotEmpty())
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img id="mainImage" src="{{ asset('storage/' . $phone->images->where('is_primary', true)->first()->image_path ?? $phone->images->first()->image_path) }}"
                            alt="{{ $phone->name }}"
                            class="w-full h-auto object-cover rounded-xl hover:scale-105 transition-transform duration-500">
                    </div>

                    @if($phone->images->count() > 1)
                    <div class="grid grid-cols-5 gap-2">
                        @foreach($phone->images as $image)
                        <div class="cursor-pointer rounded-lg overflow-hidden border-2 hover:border-blue-500 transition-colors duration-200 thumbnail-image"
                             data-image="{{ asset('storage/' . $image->image_path) }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                alt="{{ $phone->name }}"
                                class="w-full h-16 object-cover">
                        </div>
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="w-full h-80 bg-gray-200 flex items-center justify-center rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 p-6 md:p-8 flex flex-col">
                <div class="mb-2">
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">{{ $phone->brand }}</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $phone->name }}</h1>

                <div class="mb-6 flex items-center">
                    <span class="text-3xl font-bold text-blue-600">@peso($phone->price)</span>
                    @if($phone->inventory && $phone->inventory->quantity > 0)
                        <span class="ml-3 bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded-full flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            In Stock ({{ $phone->inventory->quantity }})
                        </span>
                    @else
                        <span class="ml-3 bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded-full flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Out of Stock
                        </span>
                    @endif
                </div>

                @if($phone->inventory && $phone->inventory->quantity > 0)
                <form action="{{ route('cart.add', $phone->id) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="flex items-center mb-4">
                        <label for="quantity" class="mr-3 text-gray-700 font-medium">Quantity:</label>
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="button" class="decrement-btn px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-l-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $phone->inventory->quantity }}" class="w-12 text-center border-0 focus:ring-0">
                            <button type="button" class="increment-btn px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-r-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>
                        <button type="submit" name="buy_now" value="1" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Buy Now
                        </button>
                    </div>
                </form>
                @endif

                <!-- Specifications -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Specifications</h2>
                    @php
                        $specs = json_decode($phone->description, true);
                        $specs = $specs['specs'] ?? [];
                    @endphp

                    @if(!empty($specs))
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($specs as $key => $value)
                        <div class="flex border-b border-gray-200 py-2">
                            <span class="font-medium w-1/3">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                            <span class="w-2/3">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-600">No specifications available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedPhones->isNotEmpty())
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Related Phones</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($relatedPhones as $relatedPhone)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                <a href="{{ route('shop.show', $relatedPhone->slug) }}">
                    @if($relatedPhone->primaryImage)
                    <img src="{{ asset('storage/' . $relatedPhone->primaryImage->image_path) }}" alt="{{ $relatedPhone->name }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No image</span>
                    </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $relatedPhone->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ $relatedPhone->brand }}</p>
                        <span class="text-blue-600 font-bold">${{ number_format($relatedPhone->price, 2) }}</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection