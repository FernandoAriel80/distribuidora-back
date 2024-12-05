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
        $topBestProductsLastMonth = OrderItem::select('name', 'unit_price', DB::raw('SUM(quantity) as total_quantity'))
        ->whereMonth('created_at',$lastMonth)
        ->groupBy('name', 'unit_price')
        ->orderByDesc('total_quantity')
        ->limit(5)
        ->get();

          // LOS 5 PRODUCTOS MAS COMPRADOS DE ESTE MES 
        $topBestProductsCurrentMonth = OrderItem::select('name', 'unit_price', DB::raw('SUM(quantity) as total_quantity'))
        ->whereMonth('created_at',$currentMonth)
        ->groupBy('name', 'unit_price')
        ->orderByDesc('total_quantity')
        ->limit(5)
        ->get();

        //Ranking: Productos Menos Vendidos
        // LOS 5 PRODUCTOS MENOS COMPRADOS DE EL MES PASADO
        $topWorstProductsCurrentMonth = OrderItem::select('name', 'unit_price', DB::raw('SUM(quantity) as total_quantity'))
        ->whereMonth('created_at',$lastMonth)
        ->groupBy('name', 'unit_price')
        ->orderByRaw('total_quantity')
        ->limit(5)
        ->get();
          // LOS 5 PRODUCTOS MENOS COMPRADOS DE ESTE MES 
        $topWorstProductsLastMonth = OrderItem::select('name', 'unit_price', DB::raw('SUM(quantity) as total_quantity'))
        ->whereMonth('created_at',$currentMonth)
        ->groupBy('name', 'unit_price')
        ->orderByRaw('total_quantity')
        ->limit(5)
        ->get();
    
       // Ganancias mes actual y mes anterior
        $earningsLastMonth = Order::whereMonth('created_at', $lastMonth)
            ->where('status', 'Pagado')
            ->sum('total');

        $earningsCurrentMonth = Order::whereMonth('created_at', $currentMonth)
            ->where('status', 'Pagado')
            ->sum('total'); 

        return response()->json([
            'currentMonth' => $earningsCurrentMonth,
            'lastMonth' => $earningsLastMonth,        
            'topBestProductsCurrentMonth' => $topBestProductsCurrentMonth,
            'topBestProductsLastMonth' => $topBestProductsLastMonth,
            'topWorstProductsCurrentMonth' => $topWorstProductsCurrentMonth,
            'topWorstProductsLastMonth' => $topWorstProductsLastMonth,
            'topProductsAllYear' => $topProductsAllYear, 
            'topProductsYear' => $topProductsYear, 
        ]);
    }
}
