@extends('layouts.admin')

@section('title', 'Products | Bloomie Flowers')

@section('content')
    <main class="admin-main page-shell">
        <div class="admin-page-heading">
            <div>
                <p class="section-kicker">Bloomie Flowers · Studio</p>
                <h1>Your creations.</h1>
                <p class="admin-subtitle">Manage the pieces your customers can discover.</p>
            </div>
            <a class="button" href="{{ url('/admin/create') }}"><span aria-hidden="true">＋</span> Add a product</a>
        </div>

        @if(session('success'))
            <div class="notice notice-success" role="status">{{ session('success') }}</div>
        @endif

        <div class="admin-list-heading">
            <h2>Product catalogue <span>{{ $admins->count() }}</span></h2>
            <a class="text-link" href="{{ url('/') }}" target="_blank" rel="noopener">View storefront <span aria-hidden="true">↗</span></a>
        </div>

        @forelse($admins as $admin)
            @if($loop->first)<div class="admin-product-list">@endif
                <article class="admin-product-row">
                    <div class="admin-product-image">
                        @if($admin->photo)<img src="{{ asset('uploads/' . $admin->photo) }}" alt="{{ $admin->title }}" loading="lazy">@endif
                    </div>
                    <div class="admin-product-info">
                        <p class="admin-product-category">{{ ucfirst($admin->category) }} <span>·</span> {{ ucfirst($admin->menu) }}</p>
                        <h3>{{ $admin->title }}</h3>
                        <p>{{ $admin->description }}</p>
                    </div>
                    <p class="admin-product-price">Rp {{ number_format($admin->price, 0, ',', '.') }}</p>
                    <div class="admin-product-actions">
                        <a class="button button-quiet button-small" href="{{ url('/admin/edit/' . $admin->id) }}">Edit</a>
                        <form action="{{ url('/admin/delete/' . $admin->id) }}" method="POST" onsubmit="return confirm('Remove this product from the catalogue?')">
                            @csrf
                            @method('DELETE')
                            <button class="button button-danger button-small" type="submit">Delete</button>
                        </form>
                    </div>
                </article>
            @if($loop->last)</div>@endif
        @empty
            <section class="empty-admin">
                <h2>Your catalogue is ready to bloom.</h2>
                <p>Add a product to share your first creation with customers.</p>
                <a class="button" href="{{ url('/admin/create') }}">Add your first product</a>
            </section>
        @endforelse
    </main>
@endsection
