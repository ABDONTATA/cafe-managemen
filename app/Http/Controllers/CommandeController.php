<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['table', 'user'])->paginate(10);
        return view('commandes.index', compact('commandes'));
    }

    public function create()
    {
        $tables = Table::where('statut', 'libre')->get();
        $users = User::where('role', 'serveur')->get();
        return view('commandes.create', compact('tables', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'user_id' => 'required|exists:users,id',
            'statut' => 'required|in:en_attente,en_cours,termine',
        ]);

        $table = Table::find($request->table_id);
        $table->statut = 'occupée';
        $table->save();

        Commande::create($request->only('table_id', 'user_id', 'statut'));

        return redirect()->route('commandes.index')->with('success', 'تم إضافة الطلب بنجاح');
    }

    public function show($id)
    {
        $commande = Commande::with(['table', 'user', 'ligneCommandes'])->findOrFail($id);
        return view('commandes.show', compact('commande'));
    }

    public function edit($id)
    {
        $commande = Commande::findOrFail($id);
        $tables = Table::all();
        $users = User::all();
        return view('commandes.edit', compact('commande', 'tables', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'user_id' => 'required|exists:users,id',
            'statut' => 'required|in:en_attente,en_cours,termine',
        ]);

        $commande = Commande::findOrFail($id);

        if ($commande->table_id != $request->table_id) {
            $oldTable = Table::find($commande->table_id);
            $oldTable->statut = 'libre';
            $oldTable->save();

            $newTable = Table::find($request->table_id);
            $newTable->statut = 'occupée';
            $newTable->save();
        }

        $commande->update($request->only('table_id', 'user_id', 'statut'));

        return redirect()->route('commandes.index')->with('success', 'تم تعديل الطلب بنجاح');
    }

    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);

        $table = Table::find($commande->table_id);
        $table->statut = 'libre';
        $table->save();

        $commande->delete();

        return redirect()->route('commandes.index')->with('success', 'تم حذف الطلب بنجاح');
    }
}
