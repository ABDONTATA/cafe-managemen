<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get today's statistics
        $today = Carbon::today();
        
        $dailyStats = [
            'sales' => Commande::whereDate('created_at', $today)->count(),
            'income' => Commande::whereDate('created_at', $today)
                ->join('ligne_commandes', 'commandes.id', '=', 'ligne_commandes.commande_id')
                ->sum(DB::raw('ligne_commandes.quantity * ligne_commandes.price')),
            'pending_orders' => Commande::where('statut', 'en_attente')->count(),
            'total_products' => Produit::count(),
        ];

        // Get weekly revenue data for chart
        $weeklyRevenue = Commande::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(ligne_commandes.quantity * ligne_commandes.price) as total')
        )
        ->join('ligne_commandes', 'commandes.id', '=', 'ligne_commandes.commande_id')
        ->whereBetween('commandes.created_at', [Carbon::now()->subDays(7), Carbon::now()])
        ->groupBy('date')
        ->get();

        // Get product categories distribution for pie chart
        $categoryDistribution = Produit::select('categories.name', DB::raw('count(*) as total'))
            ->join('categories', 'produits.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // Get recent orders
        $recentOrders = Commande::with(['user', 'table'])
            ->latest()
            ->take(10)
            ->get();

        // Get low stock products (less than 10 items)
        $lowStockProducts = Produit::where('quantity', '<', 10)->get();

        return view('admin.dashboard', compact(
            'dailyStats',
            'weeklyRevenue',
            'categoryDistribution',
            'recentOrders',
            'lowStockProducts'
        ));
    }
} 