@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Shop
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('shop.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600 md:ml-2">Shop</a>
                    </div>
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

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="md:flex">
            <!-- Product Images -->
            <div class="md:w-1/2 p-6 flex flex-col justify-center items-center">
                @if($phone->images->isNotEmpty())
                    <div class="mb-6 overflow-hidden rounded-xl w-full max-w-md mx-auto">
                        <img id="mainImage" src="{{ asset('storage/' . ($phone->images->where('is_primary', true)->first()->image_path ?? $phone->images->first()->image_path)) }}"
                            alt="{{ $phone->name }}"
                            class="w-full h-auto object-contain rounded-xl transition-transform duration-500 max-h-[400px]">
                    </div>

                    @if($phone->images->count() > 1)
                    <div class="grid grid-cols-5 gap-3 w-full max-w-md mx-auto">
                        @foreach($phone->images as $image)
                        <div class="cursor-pointer rounded-lg overflow-hidden border-2 {{ $loop->first ? 'border-indigo-500' : 'border-gray-200' }} hover:border-indigo-500 transition-colors duration-200 thumbnail-image"
                             data-image="{{ asset('storage/' . $image->image_path) }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                alt="{{ $phone->name }}"
                                class="w-full h-16 object-cover">
                        </div>
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="w-full h-80 bg-gray-100 flex items-center justify-center rounded-xl border border-gray-200">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500">No image available</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 p-6 md:p-8 flex flex-col bg-gray-50 border-l border-gray-200">
                <div class="mb-3">
                    <span class="inline-block bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-md">{{ $phone->brand }}</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $phone->name }}</h1>

                <div class="mb-6 flex items-center">
                    <span class="text-3xl font-bold text-indigo-600">@peso($phone->price)</span>
                    @if($phone->inventory && $phone->inventory->quantity > 0)
                        <span class="ml-3 bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            In Stock ({{ $phone->inventory->quantity }})
                        </span>
                    @else
                        <span class="ml-3 bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Out of Stock
                        </span>
                    @endif
                </div>

                <!-- Quick Specs Summary -->
                @php
                    $specs = json_decode($phone->description, true);
                    $specs = $specs['specs'] ?? [];
                @endphp
                @if(!empty($specs))
                <div class="mb-6 bg-white p-4 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Key Features</h3>
                    <ul class="space-y-2 text-sm">
                        @if(isset($specs['processor']))
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-indigo-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><span class="font-medium">Processor:</span> {{ $specs['processor'] }}</span>
                            </li>
                        @endif
                        @if(isset($specs['memory']))
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-indigo-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><span class="font-medium">Memory:</span> {{ $specs['memory'] }}</span>
                            </li>
                        @endif
                        @if(isset($specs['display']))
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-indigo-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><span class="font-medium">Display:</span> {{ $specs['display'] }}</span>
                            </li>
                        @endif
                        @if(isset($specs['camera']))
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-indigo-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span><span class="font-medium">Camera:</span> {{ $specs['camera'] }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
                @endif

                @if($phone->inventory && $phone->inventory->quantity > 0)
                <form action="{{ route('cart.add', $phone->id) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="flex items-center mb-5">
                        <label for="quantity" class="mr-3 text-gray-700 font-medium">Quantity:</label>
                        <div class="flex items-center border border-gray-300 rounded-lg shadow-sm">
                            <button type="button" class="decrement-btn px-3 py-2 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-l-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $phone->inventory->quantity }}" class="w-14 text-center border-0 focus:ring-0 bg-white">
                            <button type="button" class="increment-btn px-3 py-2 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-r-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>
                        <button type="submit" name="buy_now" value="1" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center shadow-sm">
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
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Full Specifications</h2>
                    @if(!empty($specs))
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            @foreach($specs as $key => $value)
                            <div class="flex py-3 px-4 hover:bg-gray-50">
                                <span class="font-medium text-gray-700 w-1/3">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                <span class="w-2/3 text-gray-600">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <p class="text-gray-600 bg-white p-4 rounded-lg border border-gray-200">No specifications available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedPhones->isNotEmpty())
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Related Phones</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($relatedPhones as $relatedPhone)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition duration-200 border border-gray-200 group">
                <a href="{{ route('shop.show', $relatedPhone->slug) }}" class="block h-full">
                    <div class="relative overflow-hidden">
                        @if($relatedPhone->primaryImage)
                        <img src="{{ asset('storage/' . $relatedPhone->primaryImage->image_path) }}"
                            alt="{{ $relatedPhone->name }}"
                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-1 rounded-md">{{ $relatedPhone->brand }}</span>
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2 text-gray-800 group-hover:text-indigo-600 transition-colors duration-200">{{ $relatedPhone->name }}</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-indigo-600 font-bold">@peso($relatedPhone->price)</span>
                            <span class="inline-flex items-center justify-center bg-indigo-50 text-indigo-700 rounded-full w-7 h-7 group-hover:bg-indigo-100 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image gallery functionality
        const thumbnails = document.querySelectorAll('.thumbnail-image');
        const mainImage = document.getElementById('mainImage');

        if (thumbnails.length > 0 && mainImage) {
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    // Update main image
                    const imageUrl = this.getAttribute('data-image');
                    mainImage.src = imageUrl;

                    // Update active thumbnail
                    thumbnails.forEach(thumb => {
                        thumb.classList.remove('border-indigo-500');
                        thumb.classList.add('border-gray-200');
                    });
                    this.classList.remove('border-gray-200');
                    this.classList.add('border-indigo-500');
                });
            });
        }

        // Quantity increment/decrement functionality
        const quantityInput = document.getElementById('quantity');
        const incrementBtn = document.querySelector('.increment-btn');
        const decrementBtn = document.querySelector('.decrement-btn');

        if (quantityInput && incrementBtn && decrementBtn) {
            const maxQuantity = parseInt(quantityInput.getAttribute('max'));

            incrementBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < maxQuantity) {
                    quantityInput.value = currentValue + 1;
                }
            });

            decrementBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            // Ensure quantity is within valid range when manually entered
            quantityInput.addEventListener('change', function() {
                let currentValue = parseInt(this.value);
                if (isNaN(currentValue) || currentValue < 1) {
                    this.value = 1;
                } else if (currentValue > maxQuantity) {
                    this.value = maxQuantity;
                }
            });
        }
    });
</script>
@endpush

@endsection