@extends('layouts.app')

@section('content')
    <h1>Modifier la facture #{{ $facture->id }}</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('factures.update', $facture->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Commande :</label>
        <select name="commande_id" required>
            @foreach ($commandes as $commande)
                <option value="{{ $commande->id }}" {{ $facture->commande_id == $commande->id ? 'selected' : '' }}>
                    {{ $commande->id }} - {{ $commande->statut }}
                </option>
            @endforeach
        </select>

        <br><br>

        <label>Total :</label>
        <input type="text" name="total" value="{{ old('total', $facture->total) }}" required>

        <br><br>

        <label>Date de paiement :</label>
        <input type="date" name="date_paiement" value="{{ old('date_paiement', $facture->date_paiement) }}" required>

        <br><br>

        <label>Mode de paiement :</label>
        <input type="text" name="mode_paiement" value="{{ old('mode_paiement', $facture->mode_paiement) }}" required>

        <br><br>

        <button type="submit">Mettre à jour</button>
    </form>
@endsection
