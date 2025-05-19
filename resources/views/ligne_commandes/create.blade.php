@extends('layouts.app')

@section('content')
    <h1>Ajouter une ligne commande</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ligne_commandes.store') }}" method="POST">
        @csrf

        <label>Commande</label>
        <select name="commande_id" required>
            <option value="">Sélectionnez une commande</option>
            @foreach($commandes as $commande)
                <option value="{{ $commande->id }}">{{ $commande->id }} - {{ $commande->statut }}</option>
            @endforeach
        </select>

        <br><br>

        <label>Produit</label>
        <select name="produit_id" required>
            <option value="">Sélectionnez un produit</option>
            @foreach($produits as $produit)
                <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
            @endforeach
        </select>

        <br><br>

        <label>Quantité</label>
        <input type="number" name="quantite" min="1" value="{{ old('quantite') }}" required>

        <br><br>

        <label>Prix Unitaire</label>
        <input type="text" name="prix_unitaire" value="{{ old('prix_unitaire') }}" required>

        <br><br>

        <button type="submit">Ajouter</button>
    </form>
@endsection
