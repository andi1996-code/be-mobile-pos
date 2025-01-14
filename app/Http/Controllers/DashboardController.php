<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Show total users in dashboard card.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::count();
        //total products
        $products = Product::count();
        //$totalPrice convert to rupiah
        $totalPrice = 'Rp ' . number_format(Order::sum('total_price'), 0, ',', '.');
        //total order
        $orders = Order::count();

        // all data diagram convert to rupiah
        $todaySales = 'Rp ' . number_format(Order::whereDate('created_at', now()->format('Y-m-d'))->sum('total_price'), 0, ',', '.');
        $weekSales = 'Rp ' . number_format(Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_price'), 0, ',', '.');
        $monthSales = 'Rp ' . number_format(Order::whereMonth('created_at', now()->month)->sum('total_price'), 0, ',', '.');
        $yearSales = 'Rp ' . number_format(Order::whereYear('created_at', now()->year)->sum('total_price'), 0, ',', '.');

        return view('pages.dashboard', compact('users', 'products', 'totalPrice', 'orders', 'todaySales', 'weekSales', 'monthSales', 'yearSales',),);
    }
}
