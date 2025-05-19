<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Category;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    
   
    public function index()
{
    $produits = Produit::with('category')->paginate(10); 
    return view('produits.index', compact('produits'));
}


    public function create()
    {
        $categories = Category::all();
        return view('produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'categorie_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        Produit::create($request->all());

        return redirect()->route('produits.index')->with('success', 'le produit a été ajouté avec succès');
    }

    public function edit(Produit $produit)
    {
        $categories = Category::all();
        return view('produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'categorie_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $produit->update($request->all());

        return redirect()->route('produits.index')->with('success', 'le produit a été mis à jour avec succès');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'le produit a été supprimé avec succès');
    }
}
