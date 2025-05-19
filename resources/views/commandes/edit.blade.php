@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la commande #{{ $commande->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Attention !</strong> Il y a des erreurs dans votre formulaire.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('commandes.update', $commande) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="table_id" class="form-label">Table</label>
            <select name="table_id" id="table_id" class="form-control" required>
                <option value="">-- Sélectionner une table --</option>
                @foreach ($tables as $table)
                    <option value="{{ $table->id }}" {{ (old('table_id') ?? $commande->table_id) == $table->id ? 'selected' : '' }}>
                        Table {{ $table->numero }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Serveur</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Sélectionner un serveur --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ (old('user_id') ?? $commande->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-control" required>
                <option value="en_attente" {{ (old('statut') ?? $commande->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="en_cours" {{ (old('statut') ?? $commande->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="termine" {{ (old('statut') ?? $commande->statut) == 'termine' ? 'selected' : '' }}>Terminé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
