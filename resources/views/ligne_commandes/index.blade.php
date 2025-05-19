@extends('layouts.app')

@section('content')
    <h1>Liste des lignes commandes</h1>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <a href="{{ route('ligne_commandes.create') }}">Ajouter une ligne commande</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Commande</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ligneCommandes as $ligne)
                <tr>
                    <td>{{ $ligne->id }}</td>
                    <td>{{ $ligne->commande->id }}</td>
                    <td>{{ $ligne->produit->nom }}</td>
                    <td>{{ $ligne->quantite }}</td>
                    <td>{{ $ligne->prix_unitaire }}</td>
                    <td>
                        <a href="{{ route('ligne_commandes.show', $ligne->id) }}">Voir</a> |
                        <a href="{{ route('ligne_commandes.edit', $ligne->id) }}">Modifier</a> |
                        <form action="{{ route('ligne_commandes.destroy', $ligne->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette ligne commande ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
