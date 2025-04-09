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
        
        // Get recent orders with pagination
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        // Get top selling products
        $topProducts = Product::select('products.*')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->paginate(5);
        
        // Get low stock products
        $lowStockProducts = Product::select('products.*', 'inventories.quantity')
            ->join('inventories', 'products.id', '=', 'inventories.product_id')
            ->whereRaw('inventories.quantity <= inventories.low_stock_threshold')
            ->paginate(5);
        
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