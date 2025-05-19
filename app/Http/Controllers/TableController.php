<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TableController extends Controller
{
    public function index(): View
    {
        $tables = Table::orderBy('numero')->paginate(10);

        return view('tables.index', compact('tables'));
    }

    public function create(): View
    {
        return view('tables.create');
    }

    public function store(TableRequest $request): RedirectResponse
    {
        Table::create($request->validated());

        return redirect()
            ->route('tables.index')
            ->with('success', 'ajouter une table avec succès.');
    }

    public function edit(Table $table): View
    {
        return view('tables.edit', compact('table'));
    }

    public function update(TableRequest $request, Table $table): RedirectResponse
    {
        $table->update($request->validated());

        return redirect()
            ->route('tables.index')
            ->with('success', 'Mes a jour table avec succès.');
    }

    public function destroy(Table $table): RedirectResponse
    {
        $table->delete();

        return redirect()
            ->route('tables.index')
            ->with('success', 'supprimer table avec succès.');
    }
}
