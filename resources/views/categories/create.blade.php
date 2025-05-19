@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-4 text-success fw-bold">Ajouter une nouvelle catégorie</h2>

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

    <form action="{{ route('categories.store') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
            <input 
                type="text" 
                class="form-control @error('nom') is-invalid @enderror" 
                id="nom" 
                name="nom" 
                value="{{ old('nom') }}" 
                required 
                autofocus
            >
            @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="form-label">Description (optionnelle)</label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                id="description" 
                name="description" 
                rows="3"
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
