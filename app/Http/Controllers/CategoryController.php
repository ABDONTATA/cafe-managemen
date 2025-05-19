<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'description' => 'nullable'
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nom' => 'required',
            'description' => 'nullable'
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Catégorie modifiée avec succès');
    }

    
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès');
    }
}
