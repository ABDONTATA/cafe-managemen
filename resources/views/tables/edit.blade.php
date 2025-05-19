@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Modifier la Table #{{ $table->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle-fill me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <form action="{{ route('tables.update', $table->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="numero" class="form-label fw-semibold">Numéro de la Table</label>
                <input type="text" name="numero" id="numero" class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero', $table->numero) }}" required>
                @error('numero')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="capacite" class="form-label fw-semibold">Capacité</label>
                <input type="number" min="1" max="50" name="capacite" id="capacite" class="form-control @error('capacite') is-invalid @enderror" value="{{ old('capacite', $table->capacite) }}" required>
                @error('capacite')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="statut" class="form-label fw-semibold">Statut</label>
                <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror" required>
                    <option value="libre" {{ old('statut', $table->statut) == 'libre' ? 'selected' : '' }}>Libre</option>
                    <option value="occupée" {{ old('statut', $table->statut) == 'occupée' ? 'selected' : '' }}>Occupée</option>
                    <option value="réservée" {{ old('statut', $table->statut) == 'réservée' ? 'selected' : '' }}>Réservée</option>
                </select>
                @error('statut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('tables.index') }}" class="btn btn-outline-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary shadow-sm">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
