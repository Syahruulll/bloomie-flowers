@extends('layouts.admin')

@section('title', 'Add a product | Bloomie Flowers')

@section('content')
    <main class="admin-main page-shell form-page">
        <a class="back-link" href="{{ url('/admin') }}">← Back to products</a>
        <div class="admin-page-heading form-heading">
            <div>
                <p class="section-kicker">Bloomie Flowers · Studio</p>
                <h1>Add a creation.</h1>
                <p class="admin-subtitle">Give your next lovely thing a place in the collection.</p>
            </div>
        </div>
        <x-product-form action="{{ url('/admin') }}" submit-label="Save product" />
    </main>
@endsection
