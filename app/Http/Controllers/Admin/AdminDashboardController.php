<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Statistics
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'total_customers' => User::where('is_admin', false)->count(),
            'total_revenue' => Order::paid()->sum('total'),
        ];

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '>', 0)
            ->where('stock', '<', 5)
            ->take(5)
            ->get();

        // Orders by status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Revenue for last 7 days
        $revenueByDay = Order::paid()
            ->where('paid_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(paid_at) as date'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'lowStockProducts',
            'ordersByStatus',
            'revenueByDay'
        ));
    }
}
