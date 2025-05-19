@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 600px;">

    <h2 class="mb-4 text-primary fw-bold">Modifier le produit</h2>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Erreur(s) :</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('produits.update', $produit->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
            <input 
                type="text" 
                class="form-control @error('nom') is-invalid @enderror" 
                name="nom" id="nom" 
                value="{{ old('nom', $produit->nom) }}" 
                required 
                autofocus
            >
            @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix (DH) <span class="text-danger">*</span></label>
            <input 
                type="number" step="0.01" 
                class="form-control @error('prix') is-invalid @enderror" 
                name="prix" id="prix" 
                value="{{ old('prix', $produit->prix) }}" 
                required
            >
            @error('prix')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="categorie_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
            <select 
                name="categorie_id" 
                id="categorie_id" 
                class="form-select @error('categorie_id') is-invalid @enderror" 
                required
            >
                <option value="">-- Choisir une catégorie --</option>
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('categorie_id', $produit->categorie_id) == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
            @error('categorie_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="form-label">Description (optionnel)</label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                name="description" id="description" rows="4"
            >{{ old('description', $produit->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>

</div>
@endsection
