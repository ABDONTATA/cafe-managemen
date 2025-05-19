<?php

namespace App\Http\Controllers;

use App\Models\LigneCommande;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;

class LigneCommandeController extends Controller
{
    public function index()
    {
        $ligneCommandes = LigneCommande::with(['commande', 'produit'])->get();
        return view('ligne_commandes.index', compact('ligneCommandes'));
    }

    public function create()
    {
        $commandes = Commande::all();
        $produits = Produit::all();
        return view('ligne_commandes.create', compact('commandes', 'produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        LigneCommande::create($request->all());

        return redirect()->route('ligne_commandes.index')->with('success', 'Ligne commande créée avec succès.');
    }

    public function show(LigneCommande $ligneCommande)
    {
        return view('ligne_commandes.show', compact('ligneCommande'));
    }

    public function edit(LigneCommande $ligneCommande)
    {
        $commandes = Commande::all();
        $produits = Produit::all();
        return view('ligne_commandes.edit', compact('ligneCommande', 'commandes', 'produits'));
    }

    public function update(Request $request, LigneCommande $ligneCommande)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        $ligneCommande->update($request->all());

        return redirect()->route('ligne_commandes.index')->with('success', 'Ligne commande mise à jour avec succès.');
    }

    public function destroy(LigneCommande $ligneCommande)
    {
        $ligneCommande->delete();

        return redirect()->route('ligne_commandes.index')->with('success', 'Ligne commande supprimée.');
    }
}
