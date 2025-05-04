<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    /**
     * Display a listing of phones in the shop.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get the phones category
        $phonesCategory = ProductCategory::where('name', 'Phones')->first();

        // Query for phones
        $query = Product::query()
            ->with(['primaryImage', 'inventory'])
            ->where('category_id', $phonesCategory->id ?? 0)
            ->where('is_active', true);

        // Apply filters
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Search in multiple fields that exist in the database
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");

                // Search in specific product specs if they exist in the database
                if (Schema::hasColumn('products', 'processor')) {
                    $q->orWhere('processor', 'like', "%{$search}%");
                }
                if (Schema::hasColumn('products', 'display')) {
                    $q->orWhere('display', 'like', "%{$search}%");
                }
                if (Schema::hasColumn('products', 'camera')) {
                    $q->orWhere('camera', 'like', "%{$search}%");
                }
                if (Schema::hasColumn('products', 'battery')) {
                    $q->orWhere('battery', 'like', "%{$search}%");
                }
                if (Schema::hasColumn('products', 'os')) {
                    $q->orWhere('os', 'like', "%{$search}%");
                }
                if (Schema::hasColumn('products', 'ram')) {
                    $q->orWhere('ram', 'like', "%{$search}%");
                }
                if (Schema::hasColumn('products', 'storage')) {
                    $q->orWhere('storage', 'like', "%{$search}%");
                }

                // Also search in words separately for better matching
                $searchTerms = explode(' ', $search);
                foreach ($searchTerms as $term) {
                    if (strlen($term) >= 3) { // Only search for terms with at least 3 characters
                        $q->orWhere('name', 'like', "%{$term}%")
                          ->orWhere('brand', 'like', "%{$term}%")
                          ->orWhere('description', 'like', "%{$term}%");
                    }
                }
            });

            // Log the search query for debugging
            Log::info("Search query: {$search}");
            Log::info("SQL: {$query->toSql()}");
        }

        // Get phones
        $phones = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get unique brands for filter
        $brands = Product::where('category_id', $phonesCategory->id ?? 0)
            ->select('brand')
            ->distinct()
            ->pluck('brand');

        return view('shop.index', compact('phones', 'brands'));
    }

    /**
     * Display the specified phone.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug)
    {
        // Find the phone by slug
        $phone = Product::with(['category', 'images', 'inventory', 'bulkPricingTiers'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related phones from the same category
        $relatedPhones = Product::with('primaryImage')
            ->where('category_id', $phone->category_id)
            ->where('id', '!=', $phone->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('shop.show', compact('phone', 'relatedPhones'));
    }
}