@extends('layouts.app')

@section('content')
    <h1>Détails de la facture #{{ $facture->id }}</h1>

    <p><strong>Commande ID :</strong> {{ $facture->commande->id }}</p>
    <p><strong>Total :</strong> {{ $facture->total }}</p>
    <p><strong>Date de paiement :</strong> {{ $facture->date_paiement }}</p>
    <p><strong>Mode de paiement :</strong> {{ $facture->mode_paiement }}</p>

    <a href="{{ route('factures.index') }}">Retour à la liste</a>
@endsection
