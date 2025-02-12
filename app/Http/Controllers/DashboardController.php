<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $customers = Customer::all();
        $topProducts = Product::orderBy('units_sold', 'desc')->take(5)->get();
        $topProductsLabels = $topProducts->pluck('name'); // Extract product names
        $topProductsData = $topProducts->pluck('units_sold'); // Extract units sold
        $totalSales = Transactions::whereNotNull('payment_method')->sum('total_price');
        $lastMonthSales = Transactions::whereMonth('transaction_time', Carbon::now()->subMonth()->month)
            ->sum('total_price');
        $salesGrowth = $lastMonthSales > 0 ? (($totalSales - $lastMonthSales) / $lastMonthSales) * 100 : 0;
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        $totalCustomers = Customer::count();
        $newCustomers = Customer::whereMonth('created_at', Carbon::now()->month)->count();

        $averageOrderValue = Transactions::whereDate('transaction_time', '>=', Carbon::now()->subDays(30))
            ->avg('total_price');

        // Count total products
        $totalProducts = Product::count();

        // Recent transactions (No customer relation)
        $recentTransactions = Transactions::orderBy('transaction_time', 'desc')
            ->take(5)
            ->get();

        // Sales Chart (Last 7 Days)
        $salesChartLabels = [];
        $salesChartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesChartLabels[] = $date->format('M d');
            $salesChartData[] = Transactions::whereDate('transaction_time', $date)->sum('total_price');
        }

        return view('dashboard', compact(
            'totalSales',
            'topProductsLabels', 
            'topProductsData',
            'users',
            'customers',
            'salesGrowth',
            'totalCustomers',
            'newCustomers',
            'averageOrderValue',
            'totalProducts',
            'recentTransactions',
            'salesChartLabels',
            'salesChartData'
        ));
    }
}
