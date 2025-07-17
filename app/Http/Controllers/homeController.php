<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class homeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('welcome');
        }

        $totalVentasPorDia = DB::table('ventas')
            ->selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha', 'asc')
            ->get()
            ->toArray();

        $productosStockBajo = DB::table('productos')
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->select('nombre', 'stock')
            ->limit(5)
            ->get();

        return view('panel.index', compact('totalVentasPorDia', 'productosStockBajo'));
    }
}
