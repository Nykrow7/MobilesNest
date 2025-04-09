<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <img src="{{ $product->image_url ?? asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" class="w-full h-48 object-contain">
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
        <p class="text-gray-600 mt-1">{{ Str::limit($product->description, 100) }}</p>
        <div class="mt-2 flex items-center justify-between">
            <span class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
            <span class="text-sm text-gray-500">{{ $product->stock_quantity }} in stock</span>
        </div>
        <div class="mt-4 flex space-x-2">
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Add to Cart
                </button>
            </form>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="buy_now" value="1">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Buy Now
                </button>
            </form>
        </div>
    </div>
</div>
