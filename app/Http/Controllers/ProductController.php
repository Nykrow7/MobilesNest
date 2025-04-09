<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with('primaryImage')->active();

        // Apply filters
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Get products
        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get categories for filter
        $categories = ProductCategory::where('is_active', true)->get();

        // Get unique brands for filter
        $brands = Product::select('brand')->distinct()->pluck('brand');

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Display the specified product.
     */
    public function show(string $slug)
    {
        // Find the product by slug
        $product = Product::with(['category', 'images', 'bulkPricingTiers'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Get related products from the same category
        $relatedProducts = Product::with('primaryImage')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

}

