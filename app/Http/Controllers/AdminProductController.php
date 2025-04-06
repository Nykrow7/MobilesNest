<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Inventory;
use App\Models\BulkPricingTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::with('category', 'inventory')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'sku' => 'required|string|unique:products,sku',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'initial_stock' => 'required|integer|min:0',
            'bulk_pricing' => 'nullable|array',
            'bulk_pricing.*.quantity' => 'required_with:bulk_pricing|integer|min:2',
            'bulk_pricing.*.price' => 'required_with:bulk_pricing|numeric|min:0',
        ]);

        // Create the product
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'sku' => $validated['sku'],
            'slug' => Str::slug($validated['name']),
        ]);

        // Create inventory record
        Inventory::create([
            'product_id' => $product->id,
            'quantity' => $validated['initial_stock'],
            'low_stock_threshold' => $request->input('low_stock_threshold', 5),
        ]);

        // Handle bulk pricing if provided
        if ($request->has('bulk_pricing')) {
            foreach ($request->bulk_pricing as $tier) {
                BulkPricingTier::create([
                    'product_id' => $product->id,
                    'quantity' => $tier['quantity'],
                    'price' => $tier['price'],
                ]);
            }
        }

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        $product->load('category', 'inventory', 'images', 'bulkPricingTiers');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $product->load('category', 'inventory', 'images', 'bulkPricingTiers');
        $categories = ProductCategory::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'bulk_pricing' => 'nullable|array',
            'bulk_pricing.*.id' => 'nullable|exists:bulk_pricing_tiers,id',
            'bulk_pricing.*.quantity' => 'required_with:bulk_pricing|integer|min:2',
            'bulk_pricing.*.price' => 'required_with:bulk_pricing|numeric|min:0',
        ]);

        // Update the product
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'sku' => $validated['sku'],
            'slug' => Str::slug($validated['name']),
        ]);

        // Update inventory settings
        if ($product->inventory) {
            $product->inventory->update([
                'low_stock_threshold' => $request->input('low_stock_threshold', 5),
            ]);
        }

        // Handle bulk pricing
        if ($request->has('bulk_pricing')) {
            // Get existing tier IDs
            $existingTierIds = $product->bulkPricingTiers->pluck('id')->toArray();
            $updatedTierIds = [];

            foreach ($request->bulk_pricing as $tier) {
                if (isset($tier['id'])) {
                    // Update existing tier
                    BulkPricingTier::where('id', $tier['id'])->update([
                        'quantity' => $tier['quantity'],
                        'price' => $tier['price'],
                    ]);
                    $updatedTierIds[] = $tier['id'];
                } else {
                    // Create new tier
                    $newTier = BulkPricingTier::create([
                        'product_id' => $product->id,
                        'quantity' => $tier['quantity'],
                        'price' => $tier['price'],
                    ]);
                    $updatedTierIds[] = $newTier->id;
                }
            }

            // Delete tiers that weren't updated
            $tiersToDelete = array_diff($existingTierIds, $updatedTierIds);
            if (!empty($tiersToDelete)) {
                BulkPricingTier::whereIn('id', $tiersToDelete)->delete();
            }
        } else {
            // Delete all tiers if none provided
            $product->bulkPricingTiers()->delete();
        }

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        // Handle image deletions
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Delete associated images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete the product (will cascade delete related records)
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}