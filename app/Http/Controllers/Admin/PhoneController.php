<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhoneController extends Controller
{
    /**
     * Display a listing of the phones.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $phones = Product::where('category_id', function($query) {
            $query->select('id')
                  ->from('product_categories')
                  ->where('name', 'Phones');
        })->with(['inventory', 'images'])->paginate(10);

        // Ensure each phone has a valid description
        foreach ($phones as $phone) {
            if (!is_string($phone->description)) {
                $phone->description = json_encode(['brand' => 'N/A', 'specs' => []]);
            }
        }

        return view('admin.phones.index', compact('phones'));
    }

    /**
     * Show the form for creating a new phone.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.phones.create');
    }

    /**
     * Store a newly created phone in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'specs.processor' => 'required|string',
            'specs.memory' => 'required|string',
            'specs.display' => 'required|string',
            'specs.battery' => 'required|string',
            'specs.camera' => 'required|string',
            'specs.os' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Collect specs from form fields
        $specs = [];
        if ($request->has('specs')) {
            $specsInput = $request->input('specs');
            $specs = [
                'processor' => $specsInput['processor'] ?? '',
                'memory' => $specsInput['memory'] ?? '',
                'display' => $specsInput['display'] ?? '',
                'battery' => $specsInput['battery'] ?? '',
                'camera' => $specsInput['camera'] ?? '',
                'os' => $specsInput['os'] ?? ''
            ];
        }

        // Get or create the Phones category
        $category = ProductCategory::firstOrCreate(
            ['name' => 'Phones'],
            ['description' => 'Mobile phones and smartphones']
        );

        // Generate a unique slug for the phone product
        $baseSlug = Str::slug($validated['brand'] . '-' . $validated['name']);
        $slug = $this->generateUniqueSlug($baseSlug);

        // Create the phone product
        $phone = Product::create([
            'name' => $validated['name'],
            'description' => json_encode([
                'brand' => $validated['brand'],
                'specs' => $specs
            ]),
            'price' => $validated['price'],
            'category_id' => $category->id,
            'sku' => 'PHN-' . Str::random(8),
            'slug' => $slug,
            'brand' => $validated['brand'],
            'processor' => $specs['processor'],
            'memory' => $specs['memory'],
            'display' => $specs['display'],
            'battery' => $specs['battery'],
            'camera' => $specs['camera'],
            'os' => $specs['os'],
            'is_active' => true,
        ]);

        // Create inventory record
        Inventory::create([
            'product_id' => $phone->id,
            'quantity' => $validated['stock'],
            'low_stock_threshold' => 5,
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('phones', 'public');
                $phone->images()->create([
                    'image_path' => $path,
                    'is_primary' => ($index === 0), // First image is primary
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('admin.phones.index')
            ->with('success', 'Phone added successfully.');
    }

    /**
     * Display the specified phone.
     *
     * @param  \App\Models\Product  $phone
     * @return \Illuminate\View\View
     */
    public function show(Product $phone)
    {
        // Ensure the phone has a valid description
        if (!is_string($phone->description)) {
            $phone->description = json_encode(['brand' => 'N/A', 'specs' => []]);
        }

        // Load related data
        $phone->load(['inventory', 'images']);

        return view('admin.phones.show', compact('phone'));
    }

    /**
     * Show the form for editing the specified phone.
     *
     * @param  \App\Models\Product  $phone
     * @return \Illuminate\View\View
     */
    public function edit(Product $phone)
    {
        // Load related data
        $phone->load(['inventory', 'images']);

        return view('admin.phones.edit', compact('phone'));
    }

    /**
     * Update the specified phone in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $phone
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $phone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'specs.processor' => 'required|string',
            'specs.memory' => 'required|string',
            'specs.display' => 'required|string',
            'specs.battery' => 'required|string',
            'specs.camera' => 'required|string',
            'specs.os' => 'required|string',
            'price' => 'required|numeric|min:0',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Collect specs from form fields
        $specs = [];
        if ($request->has('specs')) {
            $specsInput = $request->input('specs');
            $specs = [
                'processor' => $specsInput['processor'] ?? '',
                'memory' => $specsInput['memory'] ?? '',
                'display' => $specsInput['display'] ?? '',
                'battery' => $specsInput['battery'] ?? '',
                'camera' => $specsInput['camera'] ?? '',
                'os' => $specsInput['os'] ?? ''
            ];
        }

        // Generate a unique slug for the phone product if it's different from current
        $baseSlug = Str::slug($validated['brand'] . '-' . $validated['name']);
        $slug = ($baseSlug !== $phone->slug) ? $this->generateUniqueSlug($baseSlug) : $phone->slug;

        // Update the phone
        $phone->update([
            'name' => $validated['name'],
            'description' => json_encode([
                'brand' => $validated['brand'],
                'specs' => $specs
            ]),
            'price' => $validated['price'],
            'slug' => $slug,
            'brand' => $validated['brand'],
            'processor' => $specs['processor'],
            'memory' => $specs['memory'],
            'display' => $specs['display'],
            'battery' => $specs['battery'],
            'camera' => $specs['camera'],
            'os' => $specs['os'],
            'is_active' => true,
        ]);

        // Handle multiple image uploads if provided
        if ($request->hasFile('images')) {
            // Delete old images if they exist
            if ($phone->images()->exists()) {
                foreach ($phone->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            // Upload new images
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('phones', 'public');
                $phone->images()->create([
                    'image_path' => $path,
                    'is_primary' => ($index === 0), // First image is primary
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('admin.phones.index')
            ->with('success', 'Phone updated successfully.');
    }

    /**
     * Remove the specified phone from storage.
     *
     * @param  \App\Models\Product  $phone
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $phone)
    {
        // Delete associated images
        foreach ($phone->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete inventory record
        $phone->inventory()->delete();

        // Delete the phone
        $phone->delete();

        return redirect()->route('admin.phones.index')
            ->with('success', 'Phone deleted successfully.');
    }

    /**
     * Generate a unique slug for a product.
     *
     * @param string $baseSlug
     * @return string
     */
    private function generateUniqueSlug(string $baseSlug): string
    {
        $originalSlug = $baseSlug;
        $count = 1;

        // Check if the slug already exists
        while (Product::where('slug', $baseSlug)->exists()) {
            $baseSlug = $originalSlug . '-' . $count++;
        }

        return $baseSlug;
    }
}