<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Fecha actual y cálculos para meses
        $currentMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;
        $currentYear = Carbon::now()->year;

        // TRAE TODOS EN ORDEN DE CANTDAD DE PRODECTOS COMRPADOS 
        $topProductsAllYear = OrderItem::select('name', 'unit_price', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('name', 'unit_price')
        ->orderBy('total_quantity','desc')
        ->limit(5)
        ->get();

        // LOS PRODUCTOS VENDIDOS EN TODO EL AÑO
        $topProductsYear = OrderItem::select('name', 'unit_price', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('name', 'unit_price')
        ->whereYear('created_at', $currentYear)
        ->orderByDesc('total_quantity')
        ->limit(5)
        ->get();

        // LOS 5 PRODUCTOS MAS COMPRADOS DE EL MES PASADO
        $topProductsLastMonth = OrderItem::select('name', 'unit_price', DB::raw('SUM(quantity) as total_quantity'))
        ->whereMonth('created_at',$lastMonth)
        ->groupBy('name', 'unit_price')
        ->orderByDesc('total_quantity')
        ->limit(5)
        ->get();

          // LOS 5 PRODUCTOS MAS COMPRADOS DE ESTE MES 
        $topProductsMonth = OrderItem::select('name', 'unit_price', DB::raw('SUM(quantity) as total_quantity'))
        ->whereMonth('created_at',$currentMonth)
        ->groupBy('name', 'unit_price')
        ->orderByDesc('total_quantity')
        ->limit(5)
        ->get();

       // Ganancias mes actual y mes anterior
      /*   $earningsLastMonth = Order::whereMonth('created_at', $lastMonth)
            ->where('status', 'paid')
            ->sum('total_price');

        $earningsCurrentMonth = Order::whereMonth('created_at', $currentMonth)
            ->where('status', 'paid')
            ->sum('total_price'); */

        return response()->json([
            //'topProductsAllYear' => $topProductsAllYear, 
            //'topProductsLastMonth' => $topProductsLastMonth,
            //'topProductsMonth' => $topProductsMonth,
            //'topProductsYear' => $topProductsYear, 
            
             /* 'earningsComparison' => [
                'currentMonth' => $earningsCurrentMonth,
                'lastMonth' => $earningsLastMonth,
            ], */
        ]);
    }
}
