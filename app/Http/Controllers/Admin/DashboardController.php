<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get counts for dashboard stats
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('final_amount');

        // Get low stock products
        $lowStockProducts = Product::whereHas('inventory', function ($query) {
                $query->whereRaw('quantity < low_stock_threshold');
            })
            ->where('is_active', true)
            ->with(['category', 'inventory'])
            ->limit(5)
            ->get();

        // Get recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent transactions
        $recentTransactions = \App\Models\Transaction::with(['order.user'])
            ->whereHas('order.user') // Ensure the transaction has an order with a user
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get sales by category
        $salesByCategory = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select('product_categories.name', DB::raw('SUM(order_items.subtotal) as total'))
            ->groupBy('product_categories.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Get top selling products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // Format the total revenue
        $formattedTotalRevenue = app(\App\Helpers\CurrencyHelper::class)->formatPeso($totalRevenue);

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'formattedTotalRevenue',
            'lowStockProducts',
            'recentOrders',
            'recentTransactions',
            'salesByCategory',
            'topProducts'
        ));
    }
}
