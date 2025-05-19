@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des commandes</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('commandes.create') }}" class="btn btn-primary mb-3">Ajouter une commande</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Table</th>
                <th>Serveur</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($commandes as $commande)
                <tr>
                    <td>{{ $commande->id }}</td>
                    <td>{{ $commande->table->numero }}</td>
                    <td>{{ $commande->user->name }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</td>
                    <td>
                        <a href="{{ route('commandes.edit', $commande) }}" class="btn btn-warning btn-sm">Modifier</a>

                        <form action="{{ route('commandes.destroy', $commande) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucune commande trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $commandes->links() }}
</div>
@endsection
