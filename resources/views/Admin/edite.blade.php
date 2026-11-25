@extends('layouts.admin')

@section('title', 'Edit product | Bloomie Flowers')

@section('content')
    <main class="admin-main page-shell form-page">
        <a class="back-link" href="{{ url('/admin') }}">← Back to products</a>
        <div class="admin-page-heading form-heading">
            <div>
                <p class="section-kicker">Bloomie Flowers · Studio</p>
                <h1>Edit your creation.</h1>
                <p class="admin-subtitle">Update the details for {{ $product->title }}.</p>
            </div>
        </div>
        <x-product-form :action="url('/admin/update/' . $product->id)" :product="$product" method="PUT" submit-label="Save changes" />
    </main>
@endsection
