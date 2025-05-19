@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Liste des Tables</h1>
        <a href="{{ route('tables.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Ajouter une Table
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark text-white text-center">
                    <tr>
                        <th>#</th>
                        <th>Numéro</th>
                        <th>Capacité</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($tables as $table)
                        <tr>
                            <td>{{ $table->id }}</td>
                            <td>{{ $table->numero }}</td>
                            <td>{{ $table->capacite }}</td>
                            <td>
                                @php
                                    $statusClass = match($table->statut) {
                                        'libre' => 'badge bg-success',
                                        'occupée' => 'badge bg-danger',
                                        'réservée' => 'badge bg-warning text-dark',
                                        default => 'badge bg-secondary',
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ ucfirst($table->statut) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('tables.edit', $table->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression de cette table ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted fst-italic">Aucune table disponible.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-center">
            {{ $tables->links() }}
        </div>
    </div>
</div>
@endsection
