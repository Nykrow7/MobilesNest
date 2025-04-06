<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with(['category', 'primaryImage']);
        
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
        
        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = ProductCategory::all();
        
        return view('admin.products.index', compact('products', 'categories'));
    }
    
    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = ProductCategory::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }
    
    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'brand' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'ram' => 'required|string|max:50',
            'storage' => 'required|string|max:50',
            'processor' => 'nullable|string|max:255',
            'camera' => 'nullable|string|max:255',
            'battery' => 'nullable|string|max:255',
            'display' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'is_5g' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Create product
        $product = new Product([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'category_id' => $request->category_id,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'ram' => $request->ram,
            'storage' => $request->storage,
            'processor' => $request->processor,
            'camera' => $request->camera,
            'battery' => $request->battery,
            'display' => $request->display,
            'os' => $request->os,
            'is_5g' => $request->has('is_5g'),
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'additional_specs' => $request->additional_specs ? json_decode($request->additional_specs, true) : null,
        ]);
        
        $product->save();
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            $isPrimary = true; // First image is primary
            
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $isPrimary,
                    'sort_order' => $index,
                ]);
                
                $isPrimary = false; // Only first image is primary
            }
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }
    
    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::where('is_active', true)->get();
        $product->load('images');
        
        return view('admin.products.edit', compact('product', 'categories'));
    }
    
    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'brand' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'ram' => 'required|string|max:50',
            'storage' => 'required|string|max:50',
            'processor' => 'nullable|string|max:255',
            'camera' => 'nullable|string|max:255',
            'battery' => 'nullable|string|max:255',
            'display' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'is_5g' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Update product
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'ram' => $request->ram,
            'storage' => $request->storage,
            'processor' => $request->processor,
            'camera' => $request->camera,
            'battery' => $request->battery,
            'display' => $request->display,
            'os' => $request->os,
            'is_5g' => $request->has('is_5g'),
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'additional_specs' => $request->additional_specs ? json_decode($request->additional_specs, true) : null,
        ]);
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            $currentImageCount = $product->images->count();
            
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => ($currentImageCount === 0 && $index === 0), // Set as primary if no images exist
                    'sort_order' => $currentImageCount + $index,
                ]);
            }
        }
        
        // Handle primary image selection
        if ($request->has('primary_image_id')) {
            // Reset all images to non-primary
            ProductImage::where('product_id', $product->id)
                ->update(['is_primary' => false]);
                
            // Set selected image as primary
            ProductImage::where('id', $request->primary_image_id)
                ->update(['is_primary' => true]);
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }
    
    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete product images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
