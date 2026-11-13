@extends('layouts.app')

@section('body-class', 'admin-body')

@section('header')
    <header class="admin-header">
        <div class="page-shell admin-header-inner">
            <a class="brand-lockup" href="{{ url('/admin') }}" aria-label="Bloomie Flowers dashboard"><x-brand-mark /></a>
            <nav class="admin-navigation" aria-label="Admin navigation">
                <a href="{{ url('/admin') }}" @if(request()->is('admin') || request()->is('admin/*')) aria-current="page" @endif>Products</a>
                <a href="{{ url('/') }}" target="_blank" rel="noopener">View storefront <span aria-hidden="true">↗</span></a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="admin-signout" type="submit">Sign out</button>
                </form>
            </nav>
        </div>
    </header>
@endsection

@section('footer')
    <footer class="admin-footer page-shell">Bloomie Flowers · Product management</footer>
@endsection
