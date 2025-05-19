@extends('layouts.app')

@section('content')
    <h1>Détails de la ligne commande #{{ $ligneCommande->id }}</h1>

    <p><strong>Commande ID :</strong> {{ $ligneCommande->commande->id }}</p>
    <p><strong>Produit :</strong> {{ $ligneCommande->produit->nom }}</p>
    <p><strong>Quantité :</strong> {{ $ligneCommande->quantite }}</p>
    <p><strong>Prix Unitaire :</strong> {{ $ligneCommande->prix_unitaire }}</p>

    <a href="{{ route('ligne_commandes.index') }}">Retour à la liste</a>
@endsection
