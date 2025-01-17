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

            if ($startDate == $endDate) {
                $orders = Order::whereDate('created_at', $startDate)->get();
            } else {
                $orders = Order::whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->get();
            }
        } elseif ($type == 'monthly') {
            $month = $request->input('month');
            $year = $request->input('year');
            $month = date('m', strtotime($month));

            $orders = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        } else {
            $year = $request->input('year_only');
            $orders = Order::whereYear('created_at', $year)->get();
        }

        // Generate PDF
        $pdf = PDF::loadView('pages.report.pdf', compact('orders'));
        return $pdf->download('report.pdf');
        // return view('pages.report.result', compact('orders'));
    }
}
