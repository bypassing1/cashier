@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="relative">
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:50px_50px]"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-cyan-400 mb-8">Cashier Dashboard</h1>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @include('components.summary-card', [
                    'title' => 'Total Sales',
                    'value' => 'Rp. ' . number_format($totalSales, 2),
                    'subtext' => "+{$salesGrowth}% from last month"
                ])
                @include('components.summary-card', [
                    'title' => 'Total Customers',
                    'value' => number_format($totalCustomers),
                    'subtext' => "+{$newCustomers} new this month"
                ])
                @include('components.summary-card', [
                    'title' => 'Average Order Value',
                    'value' => 'Rp. ' . number_format($averageOrderValue, 2),
                    'subtext' => 'Based on last 30 days'
                ])
                @include('components.summary-card', [
                    'title' => 'Total Products',
                    'value' => number_format($totalProducts),
                    'subtext' => "Total products"
                ])
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-800 bg-opacity-50 backdrop-blur-md rounded-lg shadow-lg p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-300 mb-4">Sales Over Time</h3>
                    <canvas id="salesChart"></canvas>
                </div>
                <div class="bg-gray-800 bg-opacity-50 backdrop-blur-md rounded-lg shadow-lg p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-300 mb-4">Top Selling Products</h3>
                    <canvas id="productsChart"></canvas>
                </div>
            </div>

            <!-- Tables -->
            <div class="space-y-8">
                @include('components.data-table', [
                    'title' => 'Recent Transactions',
                    'data' => $recentTransactions,
                    'columns' => [
                        ['header' => 'ID', 'accessor' => 'id'],
                        ['header' => 'Amount', 'accessor' => 'total_price', 'format' => 'currency'],
                        ['header' => 'Metode Pembayaran', 'accessor' => 'payment_method'],
                        ['header' => 'Tanggal', 'accessor' => 'transaction_time', 'format' => 'date'],
                    ],
                    'link' => ['text' => 'View all transactions', 'route' => 'transactions.index']
                ])

                @include('components.data-table', [
                    'title' => 'Cashier Users',
                    'data' => $users,
                    'columns' => [
                        ['header' => 'ID', 'accessor' => 'id'],
                        ['header' => 'Name', 'accessor' => 'username'],
                        ['header' => 'Email', 'accessor' => 'email'],
                        ['header' => 'Account Created', 'accessor' => 'created_at', 'format' => 'datetime'],
                    ],
                    'link' => ['text' => 'Manage users', 'route' => 'users.index']
                ])

@include('components.data-table', [
    'title' => 'Customers',
    'data' => $customers,
    'columns' => [
        ['header' => 'ID', 'accessor' => 'id'],
        ['header' => 'Name', 'accessor' => 'name'],
        ['header' => 'Email', 'accessor' => 'email'],
        ['header' => 'Account Created', 'accessor' => 'created_at', 'format' => 'datetime'],
    ],
    'link' => ['text' => 'View all customers', 'route' => 'customers.index']
])
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesChartLabels),
            datasets: [{
                label: 'Sales',
                data: @json($salesChartData),
                borderColor: 'rgba(56, 189, 248, 1)',
                backgroundColor: 'rgba(56, 189, 248, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            }
        }
    });

    // Top Products Chart
    var ctx = document.getElementById('productsChart').getContext('2d');
    var productsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($topProductsLabels),
            datasets: [{
                label: 'Units Sold',
                data: @json($topProductsData),
                backgroundColor: [
                    'rgba(56, 189, 248, 0.8)',
                    'rgba(251, 146, 60, 0.8)',
                    'rgba(52, 211, 153, 0.8)',
                    'rgba(167, 139, 250, 0.8)',
                    'rgba(248, 113, 113, 0.8)'
                ],
                borderColor: [
                    'rgba(56, 189, 248, 1)',
                    'rgba(251, 146, 60, 1)',
                    'rgba(52, 211, 153, 1)',
                    'rgba(167, 139, 250, 1)',
                    'rgba(248, 113, 113, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            }
        }
    });
</script>
@endpush