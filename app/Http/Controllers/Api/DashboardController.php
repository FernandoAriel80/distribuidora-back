<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getDashboardData()
    {
        // Fecha actual y cálculos para meses
        $currentMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        // Top 5 productos más vendidos en el último mes
        $topProductsLastMonth = DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_product.quantity) as total_sold'))
            ->whereMonth('order_product.created_at', $lastMonth)
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Ganancias mes actual y mes anterior
        $earningsLastMonth = Order::whereMonth('created_at', $lastMonth)
            ->where('status', 'paid')
            ->sum('total_price');

        $earningsCurrentMonth = Order::whereMonth('created_at', $currentMonth)
            ->where('status', 'paid')
            ->sum('total_price');

        // Productos más vendidos en el año
        $topProductsYear = DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_product.quantity) as total_sold'))
            ->whereYear('order_product.created_at', Carbon::now()->year)
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->get();

        return response()->json([
            'topProductsLastMonth' => $topProductsLastMonth,
            'earningsComparison' => [
                'currentMonth' => $earningsCurrentMonth,
                'lastMonth' => $earningsLastMonth,
            ],
            'topProductsYear' => $topProductsYear,
        ]);
    }
}
