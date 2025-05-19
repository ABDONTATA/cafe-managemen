@extends('layouts.app')

@section('title', 'Products')

@section('page-title', 'Products Management')
@section('page-subtitle', 'Manage your café products')

@section('page-actions')
@if(auth()->user()->role === 'admin')
<a href="{{ route('produits.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Add New Product
</a>
@endif
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Products List</h4>
        </div>
    </div>
    <div class="card-body">
        <!-- Search and Filters -->
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" placeholder="Search products...">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status">
                        <option value="">All Status</option>
                        <option value="in_stock">In Stock</option>
                        <option value="low_stock">Low Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-label d-block">&nbsp;</label>
                    <button type="button" class="btn btn-primary w-100" id="filter">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produits as $produit)
                    <tr>
                        <td>
                            <img src="{{ $produit->image ? asset('storage/' . $produit->image) : asset('assets/images/products/default.png') }}" 
                                 alt="{{ $produit->nom }}" 
                                 class="rounded"
                                 width="50">
                        </td>
                        <td>{{ $produit->nom }}</td>
                        <td>{{ $produit->category->name }}</td>
                        <td>${{ number_format($produit->prix, 2) }}</td>
                        <td>{{ $produit->quantity }}</td>
                        <td>
                            @if($produit->quantity > 10)
                                <span class="badge bg-success">In Stock</span>
                            @elseif($produit->quantity > 0)
                                <span class="badge bg-warning">Low Stock</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('produits.show', $produit->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('produits.edit', $produit->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-end mt-4">
            {{ $produits->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search and filter functionality
    const searchInput = document.getElementById('search');
    const categorySelect = document.getElementById('category');
    const statusSelect = document.getElementById('status');
    const filterButton = document.getElementById('filter');

    filterButton.addEventListener('click', function() {
        const searchQuery = searchInput.value;
        const categoryId = categorySelect.value;
        const status = statusSelect.value;

        let url = new URL(window.location.href);
        url.searchParams.set('search', searchQuery);
        url.searchParams.set('category', categoryId);
        url.searchParams.set('status', status);

        window.location.href = url.toString();
    });

    // Initialize current filter values
    const urlParams = new URLSearchParams(window.location.search);
    searchInput.value = urlParams.get('search') || '';
    categorySelect.value = urlParams.get('category') || '';
    statusSelect.value = urlParams.get('status') || '';
});
</script>
@endsection
