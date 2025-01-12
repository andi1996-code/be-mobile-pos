<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    //index
    public function index()
    {
        $orders = \App\Models\Order::with('kasir')->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.orders.index', compact('orders'));
    }

    //view
    public function show($id)
    {
        $order = \App\Models\Order::with('kasir')->findOrFail($id);

        //get order items by order id
        $orderItems = \App\Models\OrderItem::with('product')->where('order_id', $id)->get();


        return view('pages.orders.view', compact('order', 'orderItems'));
    }

    //daily report
    public function dailyReport()
    {
        $today = Carbon::today();
        $orders = \App\Models\Order::with('kasir')
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.reports.daily', compact('orders'));
    }

    //monthly report
    public function monthlyReport()
    {
        $currentMonth = Carbon::now()->month;
        $orders = \App\Models\Order::with('kasir')
            ->whereMonth('created_at', $currentMonth)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.reports.monthly', compact('orders'));
    }

    //filter by date range
    public function filterByDate(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $orders = \App\Models\Order::with('kasir')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.orders.index', compact('orders'));
    }
}
