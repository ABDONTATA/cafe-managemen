<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Commande;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with('commande')->get();
        return view('factures.index', compact('factures'));
    }

    public function create()
    {
        $commandes = Commande::all();
        return view('factures.create', compact('commandes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'total' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|string|max:255',
        ]);

        Facture::create($request->all());

        return redirect()->route('factures.index')->with('success', 'Facture ajoutée avec succès');
    }

    public function show(Facture $facture)
    {
        return view('factures.show', compact('facture'));
    }

    public function edit(Facture $facture)
    {
        $commandes = Commande::all();
        return view('factures.edit', compact('facture', 'commandes'));
    }

    public function update(Request $request, Facture $facture)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'total' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|string|max:255',
        ]);

        $facture->update($request->all());

        return redirect()->route('factures.index')->with('success', 'Facture mise à jour avec succès');
    }

    public function destroy(Facture $facture)
    {
        $facture->delete();
        return redirect()->route('factures.index')->with('success', 'Facture supprimée avec succès');
    }
}
