@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <div class="flex items-center text-sm text-gray-600 mb-6">
        <a href="{{ route('welcome') }}" class="hover:text-blue-600">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-blue-600">Products</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
            <!-- Product Images -->
            <div>
                @if($product->images->isNotEmpty())
                <div class="mb-4">
                    <div id="mainImage" class="w-full h-80 bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                    </div>
                </div>

                @if($product->images->count() > 1)
                <div class="grid grid-cols-5 gap-2">
                    @foreach($product->images as $image)
                    <div class="cursor-pointer border-2 {{ $image->is_primary ? 'border-blue-500' : 'border-transparent' }} rounded-md overflow-hidden hover:border-blue-300 transition duration-200"
                         onclick="showImage('{{ Storage::url($image->image_path) }}', this)">
                        <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}" class="w-full h-16 object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
                @else
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center rounded-lg">
                    <span class="text-gray-500">No image available</span>
                </div>
                @endif
            </div>

            <!-- Product Details -->
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                <p class="text-xl text-gray-600 mb-4">{{ $product->brand }}</p>

                <div class="mb-6">
                    <span class="text-2xl font-bold text-blue-600">{{ $product->formatted_price }}</span>
                    @if($product->stock_quantity > 0)
                    <span class="ml-3 bg-green-100 text-green-800 text-sm font-semibold px-2 py-1 rounded">In Stock ({{ $product->stock_quantity }})</span>
                    @else
                    <span class="ml-3 bg-red-100 text-red-800 text-sm font-semibold px-2 py-1 rounded">Out of Stock</span>
                    @endif
                </div>

                <!-- Bulk Pricing -->
                @php
                    $activeTiers = $product->bulkPricingTiers->where('is_active', true)->sortBy('min_quantity');
                @endphp
                @if($activeTiers->isNotEmpty())
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Bulk Pricing</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Quantity</th>
                                    <th class="text-right py-2">Price Per Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2">1-{{ $activeTiers->first()->min_quantity - 1 }}</td>
                                    <td class="text-right py-2">{{ $product->formatted_price }}</td>
                                </tr>
                                @foreach($activeTiers as $tier)
                                <tr class="border-b">
                                    <td class="py-2">
                                        @if($loop->last)
                                        {{ $tier->min_quantity }}+
                                        @else
                                        @php
                                            $nextTier = $activeTiers->where('min_quantity', '>', $tier->min_quantity)->first();
                                            $maxDisplay = $nextTier ? $nextTier->min_quantity - 1 : null;
                                        @endphp
                                        {{ $tier->min_quantity }}{{ $maxDisplay ? '-'.$maxDisplay : '+' }}
                                        @endif
                                    </td>
                                    <td class="text-right py-2">${{ number_format($tier->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Add to Cart Form -->
                @if($product->stock_quantity > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-6">
                    @csrf
                    <div class="flex items-center mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mr-4">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition duration-200">
                        Add to Cart
                    </button>
                </form>
                @endif

                <!-- Key Specifications -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">RAM</p>
                            <p class="font-medium">{{ $product->ram }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Storage</p>
                            <p class="font-medium">{{ $product->storage }}</p>
                        </div>
                    </div>
                    @if($product->processor)
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Processor</p>
                            <p class="font-medium">{{ $product->processor }}</p>
                        </div>
                    </div>
                    @endif
                    @if($product->camera)
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Camera</p>
                            <p class="font-medium">{{ $product->camera }}</p>
                        </div>
                    </div>
                    @endif
                    @if($product->is_5g)
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Network</p>
                            <p class="font-medium">5G Compatible</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Description and Specifications -->
        <div class="p-6 border-t">
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Description</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-4">Specifications</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Basic Information</h3>
                        <table class="w-full">
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2 text-gray-600">Brand</td>
                                    <td class="py-2 font-medium">{{ $product->brand }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 text-gray-600">RAM</td>
                                    <td class="py-2 font-medium">{{ $product->ram }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 text-gray-600">Storage</td>
                                    <td class="py-2 font-medium">{{ $product->storage }}</td>
                                </tr>
                                @if($product->os)
                                <tr class="border-b">
                                    <td class="py-2 text-gray-600">Operating System</td>
                                    <td class="py-2 font-medium">{{ $product->os }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="py-2 text-gray-600">5G Compatible</td>
                                    <td class="py-2 font-medium">{{ $product->is_5g ? 'Yes' : 'No' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Technical Specifications</h3>
                        <table class="w-full">
                            <tbody>
                                @if($product->processor)
                                <tr class="border-b">
                                    <td class="py-2 text-gray-600">Processor</td>
                                    <td class="py-2 font-medium">{{ $product->processor }}</td>
                                </tr>
                                @endif
                                @if($product->camera)
                                <tr class="border-b">
                                    <td class="py-2 text-gray-600">Camera</td>
                                    <td class="py-2 font-medium">{{ $product->camera }}</td>
                                </tr>
                                @endif
                                @if($product->battery)
                                <tr class="border-b">
                                    <td class="py-2 text-gray-600">Battery</td>
                                    <td class="py-2 font-medium">{{ $product->battery }}</td>
                                </tr>
                                @endif
                                @if($product->display)
                                <tr>
                                    <td class="py-2 text-gray-600">Display</td>
                                    <td class="py-2 font-medium">{{ $product->display }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if($product->additional_specs)
                    <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                        <h3 class="font-semibold mb-2">Additional Specifications</h3>
                        <table class="w-full">
                            <tbody>
                                @foreach($product->additional_specs as $key => $value)
                                <tr class="{{ !$loop->last ? 'border-b' : '' }}">
                                    <td class="py-2 text-gray-600">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                    <td class="py-2 font-medium">{{ $value }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Related Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                <a href="{{ $relatedProduct->url }}">
                    @if($relatedProduct->primaryImage)
                    <img src="{{ asset('storage/' . $relatedProduct->primaryImage->image_path) }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No image</span>
                    </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $relatedProduct->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ $relatedProduct->brand }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-600 font-bold">{{ $relatedProduct->formatted_price }}</span>
                            @if($relatedProduct->is_featured)
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">Featured</span>
                            @endif
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
    function showImage(src, element) {
        // Update main image
        document.getElementById('mainImage').querySelector('img').src = src;

        // Update border for thumbnails
        document.querySelectorAll('.cursor-pointer').forEach(el => {
            el.classList.remove('border-blue-500');
            el.classList.add('border-transparent');
        });

        element.classList.remove('border-transparent');
        element.classList.add('border-blue-500');
    }
</script