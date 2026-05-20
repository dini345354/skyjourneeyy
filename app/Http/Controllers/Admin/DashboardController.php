<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers     = User::where('role', 'user')->count();
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalRevenue   = Order::where('status_pesanan', '!=', 'dibatalkan')->sum('total_pembayaran');
        $recentOrders   = Order::with(['user', 'orderItems.product'])->latest()->take(5)->get();
        $lowStockProducts = Product::where('stok_kursi', '<', 10)->take(5)->get();

        $orderStats = [
            'pending'    => Order::where('status_pesanan', 'pending')->count(),
            'dibayar'    => Order::where('status_pesanan', 'dibayar')->count(),
            'selesai'    => Order::where('status_pesanan', 'selesai')->count(),
            'dibatalkan' => Order::where('status_pesanan', 'dibatalkan')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'lowStockProducts',
            'orderStats'
        ));
    }
}
