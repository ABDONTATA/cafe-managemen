@extends('layouts.app')

@section('title', $produit->nom)

@section('page-title', 'Product Details')
@section('page-subtitle', 'View product information')

@section('page-actions')
@if(auth()->user()->role === 'admin')
<div class="d-flex gap-2">
    <a href="{{ route('produits.edit', $produit->id) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> Edit Product
    </a>
    <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
            <i class="fas fa-trash"></i> Delete Product
        </button>
    </form>
</div>
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <!-- Product Image -->
        <div class="card">
            <div class="card-body">
                <img src="{{ $produit->image ? asset('storage/' . $produit->image) : asset('assets/images/products/default.png') }}" 
                     alt="{{ $produit->nom }}" 
                     class="img-fluid rounded">
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mt-4">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded p-3 me-3">
                                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="d-block text-sm">Stock</span>
                                <h4 class="counter">{{ $produit->quantity }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded p-3 me-3">
                                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.7161 16.2234H8.49609" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M15.7161 12.0369H8.49609" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M11.2521 7.86011H8.49707" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.909 2.74976C15.909 2.74976 8.23198 2.75376 8.21998 2.75376C5.45998 2.77076 3.75098 4.58676 3.75098 7.35676V16.5528C3.75098 19.3368 5.47298 21.1598 8.25698 21.1598C8.25698 21.1598 15.933 21.1568 15.946 21.1568C18.706 21.1398 20.416 19.3228 20.416 16.5528V7.35676C20.416 4.57276 18.693 2.74976 15.909 2.74976Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="d-block text-sm">Price</span>
                                <h4 class="counter">${{ number_format($produit->prix, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Product Information -->
        <div class="card">
            <div class="card-header">
                <div class="header-title">
                    <h4 class="card-title">Product Information</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th style="width: 150px;">Name</th>
                                <td>{{ $produit->nom }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $produit->category->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $produit->description ?? 'No description available' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($produit->quantity > 10)
                                        <span class="badge bg-success">In Stock</span>
                                    @elseif($produit->quantity > 0)
                                        <span class="badge bg-warning">Low Stock</span>
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $produit->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $produit->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sales History -->
        <div class="card mt-4">
            <div class="card-header">
                <div class="header-title">
                    <h4 class="card-title">Sales History</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produit->ligneCommandes as $ligne)
                            <tr>
                                <td>
                                    <a href="{{ route('commandes.show', $ligne->commande_id) }}">#{{ $ligne->commande_id }}</a>
                                </td>
                                <td>{{ $ligne->created_at->format('M d, Y') }}</td>
                                <td>{{ $ligne->quantite }}</td>
                                <td>${{ number_format($ligne->prix_unitaire, 2) }}</td>
                                <td>${{ number_format($ligne->quantite * $ligne->prix_unitaire, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No sales history available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 