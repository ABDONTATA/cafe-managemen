@extends('layouts.app')

@section('content')
    <h1>Liste des factures</h1>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <a href="{{ route('factures.create') }}">Ajouter une nouvelle facture</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Commande</th>
                <th>Total</th>
                <th>Date Paiement</th>
                <th>Mode Paiement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factures as $facture)
                <tr>
                    <td>{{ $facture->id }}</td>
                    <td>{{ $facture->commande->id }}</td>
                    <td>{{ $facture->total }}</td>
                    <td>{{ $facture->date_paiement }}</td>
                    <td>{{ $facture->mode_paiement }}</td>
                    <td>
                        <a href="{{ route('factures.show', $facture->id) }}">Voir</a> |
                        <a href="{{ route('factures.edit', $facture->id) }}">Modifier</a> |
                        <form action="{{ route('factures.destroy', $facture->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
