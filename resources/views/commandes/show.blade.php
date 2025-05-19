@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la commande #{{ $commande->id }}</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Table :</strong> Table {{ $commande->table->numero }}</p>
            <p><strong>Serveur :</strong> {{ $commande->user->name }}</p>
            <p><strong>Statut :</strong> {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</p>
            <p><strong>Date de création :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Dernière modification :</strong> {{ $commande->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('commandes.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection
