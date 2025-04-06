<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the inventory items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Inventory::with('product');
        
        // Apply filters
        if ($request->has('low_stock')) {
            $query->whereRaw('quantity <= low_stock_threshold');
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }
        
        $inventory = $query->orderBy('updated_at', 'desc')->paginate(15);
        
        return view('admin.inventory.index', compact('inventory'));
    }

    /**
     * Show the form for editing the specified inventory item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory = Inventory::with('product')->findOrFail($id);
        return view('admin.inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified inventory item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $inventory->update([
            'quantity' => $request->quantity,
            'low_stock_threshold' => $request->low_stock_threshold,
        ]);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory updated successfully.');
    }

    /**
     * Adjust inventory quantity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adjustQuantity(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'adjustment' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $adjustment = $request->adjustment;
        $newQuantity = $inventory->quantity + $adjustment;
        
        if ($newQuantity < 0) {
            return redirect()->back()
                ->withErrors(['adjustment' => 'Cannot reduce inventory below zero.'])
                ->withInput();
        }
        
        $inventory->quantity = $newQuantity;
        $inventory->save();
        
        // Here you could also log the inventory adjustment with the reason
        // in a separate inventory_logs table if needed

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory quantity adjusted successfully.');
    }

    /**
     * Show low stock inventory items.
     *
     * @return \Illuminate\Http\Response
     */
    public function lowStock()
    {
        $lowStockItems = Inventory::with('product')
            ->whereRaw('quantity <= low_stock_threshold')
            ->orderBy('quantity', 'asc')
            ->paginate(15);
        
        return view('admin.inventory.low_stock', compact('lowStockItems'));
    }

    /**
     * Export inventory data to CSV.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inventory-export-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['ID', 'Product Name', 'Brand', 'Quantity', 'Low Stock Threshold', 'Status', 'Last Updated']);
            
            // Add inventory data
            Inventory::with('product')->chunk(100, function($inventoryItems) use($file) {
                foreach ($inventoryItems as $item) {
                    $status = $item->quantity <= $item->low_stock_threshold ? 'Low Stock' : 'In Stock';
                    
                    fputcsv($file, [
                        $item->id,
                        $item->product->name,
                        $item->product->brand,
                        $item->quantity,
                        $item->low_stock_threshold,
                        $status,
                        $item->updated_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}