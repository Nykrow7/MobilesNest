<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with summary statistics.
     */
    public function index()
    {
        // Get total number of products
        $totalProducts = Product::count();
        
        // Get total number of orders
        $totalOrders = Order::count();
        
        // Get total number of users
        $totalUsers = User::count();
        
        // Get total revenue
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        // Get recent orders (last 5)
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get top selling products
        $topProducts = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $product = Product::find($item->product_id);
                return [
                    'product' => $product,
                    'total_sold' => $item->total_sold
                ];
            });
        
        // Get low stock products
        $lowStockProducts = DB::table('inventory')
            ->join('products', 'inventory.product_id', '=', 'products.id')
            ->select('products.*', 'inventory.quantity')
            ->whereRaw('inventory.quantity <= inventory.low_stock_threshold')
            ->take(5)
            ->get();
        
        // Get order status distribution
        $orderStatusDistribution = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();
        
        return view('dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'recentOrders',
            'topProducts',
            'lowStockProducts',
            'orderStatusDistribution'
        ));
    }
}