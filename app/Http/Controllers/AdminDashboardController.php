<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        // Daily and Monthly Statistics
        $dailyStats = [
            'sales' => Commande::whereDate('commandes.created_at', $today)->count(),
            'income' => Commande::whereDate('commandes.created_at', $today)
                ->join('ligne_commandes', 'commandes.id', '=', 'ligne_commandes.commande_id')
                ->sum(DB::raw('ligne_commandes.quantite * ligne_commandes.prix_unitaire')),
            'pending_orders' => Commande::where('statut', 'en_attente')->count(),
            'total_products' => Produit::count(),
        ];

        $monthlyStats = [
            'sales' => Commande::whereMonth('created_at', now()->month)->count(),
            'income' => Commande::whereMonth('commandes.created_at', now()->month)
                ->join('ligne_commandes', 'commandes.id', '=', 'ligne_commandes.commande_id')
                ->sum(DB::raw('ligne_commandes.quantite * ligne_commandes.prix_unitaire')),
            'average_order_value' => Commande::whereMonth('commandes.created_at', now()->month)
                ->join('ligne_commandes', 'commandes.id', '=', 'ligne_commandes.commande_id')
                ->select(DB::raw('ROUND(AVG(ligne_commandes.quantite * ligne_commandes.prix_unitaire), 2) as avg_value'))
                ->first()->avg_value ?? 0,
        ];

        // Get weekly revenue data for chart
        $weeklyRevenue = Commande::select(
            DB::raw('DATE(commandes.created_at) as date'),
            DB::raw('SUM(ligne_commandes.quantite * ligne_commandes.prix_unitaire) as total'),
            DB::raw('COUNT(*) as orders_count')
        )
        ->join('ligne_commandes', 'commandes.id', '=', 'ligne_commandes.commande_id')
        ->whereBetween('commandes.created_at', [Carbon::now()->subDays(7), Carbon::now()])
        ->groupBy('date')
        ->get();

        // Get product categories distribution for pie chart
        $categoryDistribution = Category::withCount(['produits', 'produits as total_value' => function($query) {
            $query->select(DB::raw('SUM(prix * quantity)'));
        }])
        ->get()
        ->map(function ($category) {
            return [
                'name' => $category->name,
                'total' => $category->produits_count,
                'value' => $category->total_value ?? 0
            ];
        });

        // Get recent orders with more details
        $recentOrders = Commande::with(['user', 'table', 'ligneCommandes.produit'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'table' => $order->table->name,
                    'waiter' => $order->user->name,
                    'status' => $order->statut,
                    'total' => $order->ligneCommandes->sum(function($ligne) {
                        return $ligne->quantite * $ligne->prix_unitaire;
                    }),
                    'items_count' => $order->ligneCommandes->sum('quantite'),
                    'created_at' => $order->created_at
                ];
            });

        // Get low stock products with more details
        $lowStockProducts = Produit::with('category')
            ->where('quantity', '<', 10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->nom,
                    'category' => $product->category->name,
                    'quantity' => $product->quantity,
                    'price' => $product->prix,
                    'total_value' => $product->quantity * $product->prix
                ];
            });

        // Get top selling products
        $topProducts = DB::table('produits')
            ->join('ligne_commandes', 'produits.id', '=', 'ligne_commandes.produit_id')
            ->select(
                'produits.id',
                'produits.nom as name',
                DB::raw('SUM(ligne_commandes.quantite) as total_sold'),
                DB::raw('SUM(ligne_commandes.quantite * ligne_commandes.prix_unitaire) as total_revenue')
            )
            ->groupBy('produits.id', 'produits.nom')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Get staff performance
        $staffPerformance = User::whereHas('commandes')
            ->withCount('commandes')
            ->withSum(['commandes' => function($query) {
                $query->join('ligne_commandes', 'commandes.id', '=', 'ligne_commandes.commande_id')
                    ->select(DB::raw('SUM(ligne_commandes.quantite * ligne_commandes.prix_unitaire)'));
            }], 'total')
            ->orderByDesc('commandes_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'dailyStats',
            'monthlyStats',
            'weeklyRevenue',
            'categoryDistribution',
            'recentOrders',
            'lowStockProducts',
            'topProducts',
            'staffPerformance'
        ));
    }
} 