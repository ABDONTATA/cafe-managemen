@extends('layouts.app')

@section('content')
    <h1>Modifier la ligne commande #{{ $ligneCommande->id }}</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ligne_commandes.update', $ligneCommande->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Commande</label>
        <select name="commande_id" required>
            @foreach ($commandes as $commande)
                <option value="{{ $commande->id }}" {{ $ligneCommande->commande_id == $commande->id ? 'selected' : '' }}>
                    {{ $commande->id }} - {{ $commande->statut }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Produit</label>
        <select name="produit_id" required>
            @foreach ($produits as $produit)
                <option value="{{ $produit->id }}" {{ $ligneCommande->produit_id == $produit->id ? 'selected' : '' }}>
                    {{ $produit->nom }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Quantité</label>
        <input type="number" name="quantite" min="1" value="{{ old('quantite', $ligneCommande->quantite) }}" required>

        <br><br>

        <label>Prix Unitaire</label>
        <input type="text" name="prix_unitaire" value="{{ old('prix_unitaire', $ligneCommande->prix_unitaire) }}" required>

        <br><br>

        <button type="submit">Mettre à jour</button>
    </form>
@endsection
