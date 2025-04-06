<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BulkPricingTier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BulkPricingController extends Controller
{
    /**
     * Display a listing of bulk pricing tiers for a product.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $bulkPricingTiers = BulkPricingTier::where('product_id', $productId)
            ->orderBy('min_quantity', 'asc')
            ->get();

        return view('admin.bulk-pricing.index', compact('product', 'bulkPricingTiers'));
    }

    /**
     * Show the form for creating a new bulk pricing tier.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        return view('admin.bulk-pricing.create', compact('product'));
    }

    /**
     * Store a newly created bulk pricing tier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'min_quantity' => 'required|integer|min:2',
            'max_quantity' => 'nullable|integer|gt:min_quantity',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        BulkPricingTier::create($data);

        return redirect()->route('admin.bulk-pricing.index', $request->product_id)
            ->with('success', 'Bulk pricing tier created successfully.');
    }

    /**
     * Show the form for editing the specified bulk pricing tier.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bulkPricingTier = BulkPricingTier::findOrFail($id);
        $product = Product::findOrFail($bulkPricingTier->product_id);

        return view('admin.bulk-pricing.edit', compact('bulkPricingTier', 'product'));
    }

    /**
     * Update the specified bulk pricing tier in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bulkPricingTier = BulkPricingTier::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'min_quantity' => 'required|integer|min:2',
            'max_quantity' => 'nullable|integer|gt:min_quantity',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $bulkPricingTier->update($data);

        return redirect()->route('admin.bulk-pricing.index', $request->product_id)
            ->with('success', 'Bulk pricing tier updated successfully.');
    }

    /**
     * Remove the specified bulk pricing tier from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bulkPricingTier = BulkPricingTier::findOrFail($id);
        $productId = $bulkPricingTier->product_id;
        
        $bulkPricingTier->delete();

        return redirect()->route('admin.bulk-pricing.index', $productId)
            ->with('success', 'Bulk pricing tier deleted successfully.');
    }

    /**
     * Toggle the active status of the specified bulk pricing tier.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id)
    {
        $bulkPricingTier = BulkPricingTier::findOrFail($id);
        $bulkPricingTier->is_active = !$bulkPricingTier->is_active;
        $bulkPricingTier->save();

        $status = $bulkPricingTier->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.bulk-pricing.index', $bulkPricingTier->product_id)
            ->with('success', "Bulk pricing tier {$status} successfully.");
    }
}