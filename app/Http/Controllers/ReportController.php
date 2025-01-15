<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Product;
use App\Models\User;

class ReportController extends Controller
{
    //index
    public function index()
    {
        return view('pages.report.index');
    }

    public function generate(Request $request)
    {
        $type = $request->input('type');
        if ($type == 'daily') {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        } else if ($type == 'monthly') {
            $month = $request->input('month');
            $year = $request->input('year');
            // Extract the month part from the month input
            $month = date('m', strtotime($month));
            $orders = Order::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
            // Debugging: Log the query result
        } else {
            $year = $request->input('year_only');
            $orders = Order::whereYear('created_at', $year)->get();
        }

        if ($orders->isEmpty()) {
            return back()->with('error', 'Tidak ada pesanan yang ditemukan untuk periode ini.');
        }

        // Generate PDF
        $pdf = PDF::loadView('pages.report.pdf', compact('orders'));
        return $pdf->download('report.pdf');
        // return view('pages.report.result', compact('orders'));
    }
}
