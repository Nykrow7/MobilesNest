<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

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
                  ->orWhere('processor', 'like', "%{$search}%")
                  ->orWhere('display', 'like', "%{$search}%")
                  ->orWhere('camera', 'like', "%{$search}%")
                  ->orWhere('battery', 'like', "%{$search}%")
                  ->orWhere('os', 'like', "%{$search}%")
                  ->orWhere('ram', 'like', "%{$search}%")
                  ->orWhere('storage_capacity', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");

                // Also search in words separately for better matching
                $searchTerms = explode(' ', $search);
                foreach ($searchTerms as $term) {
                    if (strlen($term) >= 3) { // Only search for terms with at least 3 characters
                        $q->orWhere('name', 'like', "%{$term}%")
                          ->orWhere('brand', 'like', "%{$term}%")
                          ->orWhere('processor', 'like', "%{$term}%")
                          ->orWhere('display', 'like', "%{$term}%")
                          ->orWhere('camera', 'like', "%{$term}%")
                          ->orWhere('battery', 'like', "%{$term}%")
                          ->orWhere('os', 'like', "%{$term}%")
                          ->orWhere('ram', 'like', "%{$term}%")
                          ->orWhere('storage_capacity', 'like', "%{$term}%")
                          ->orWhere('color', 'like', "%{$term}%");
                    }
                }
            });
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