@extends('layouts.app')

@section('content')
    <h1>Ajouter une facture</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('factures.store') }}" method="POST">
        @csrf

        <label>Commande :</label>
        <select name="commande_id" required>
            <option value="">Choisir une commande</option>
            @foreach ($commandes as $commande)
                <option value="{{ $commande->id }}">{{ $commande->id }} - {{ $commande->statut }}</option>
            @endforeach
        </select>

        <br><br>

        <label>Total :</label>
        <input type="text" name="total" value="{{ old('total') }}" required>

        <br><br>

        <label>Date de paiement :</label>
        <input type="date" name="date_paiement" value="{{ old('date_paiement') }}" required>

        <br><br>

        <label>Mode de paiement :</label>
        <input type="text" name="mode_paiement" value="{{ old('mode_paiement') }}" required>

        <br><br>

        <button type="submit">Ajouter</button>
    </form>
@endsection
