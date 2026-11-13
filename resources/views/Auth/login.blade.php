@extends('layouts.app')

@section('title', 'Studio sign in | Bloomie Flowers')
@section('body-class', 'login-body')

@section('content')
    <main class="login-page">
        <a class="brand-lockup login-brand" href="{{ url('/') }}"><x-brand-mark /></a>
        <section class="login-panel" aria-labelledby="login-title">
            <h1 id="login-title">Welcome back.</h1>
            <p class="login-intro">Sign in to care for your collection.</p>

            @if(session('error'))
                <div class="notice notice-error" role="alert">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="notice notice-error" role="alert">{{ $errors->first() }}</div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="login-form">
                @csrf
                <div class="field-group">
                    <label class="field-label" for="email">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" placeholder="you@example.com" required autofocus>
                </div>
                <div class="field-group">
                    <label class="field-label" for="password">Password</label>
                    <input id="password" type="password" name="password" autocomplete="current-password" placeholder="Enter your password" required>
                </div>
                <button class="button login-submit" type="submit">Sign in <span aria-hidden="true">→</span></button>
            </form>
            <a class="back-link login-back" href="{{ url('/') }}">← Return to the shop</a>
        </section>
        <p class="login-tagline">Where every bloom becomes a beautiful memory.</p>
    </main>
@endsection
