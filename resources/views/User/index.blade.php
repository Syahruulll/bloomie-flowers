@extends('layouts.app')

@section('title', 'Bloomie Flowers | Every bloom tells a story')
@section('description', 'Discover thoughtfully arranged bouquets and handmade gifts from Bloomie Flowers in Karimun.')

@section('header')
    <header class="site-header">
        <div class="page-shell header-inner">
            <a class="brand-lockup" href="{{ url('/') }}" aria-label="Bloomie Flowers home">
                <x-brand-mark />
            </a>

            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation" data-menu-toggle>
                <span class="menu-toggle-label">Menu</span>
                <span class="menu-toggle-icon" aria-hidden="true"></span>
            </button>

            <nav class="site-navigation" id="site-navigation" data-site-navigation aria-label="Main navigation">
                <a href="#collections">Collections</a>
                <a href="#story">Our approach</a>
                <a href="#visit">Visit us</a>
                <a class="button button-small" href="https://wa.me/6285692591642" target="_blank" rel="noopener">Order on WhatsApp</a>
            </nav>
        </div>
    </header>
@endsection

@section('content')
    <main>
        <section class="hero page-shell" aria-labelledby="hero-title">
            <div class="hero-copy" data-reveal-group>
                <h1 id="hero-title" data-reveal>Every bloom tells a beautiful story.</h1>
                <p class="hero-description" data-reveal>Thoughtful floral arrangements and keepsakes, made with care in Karimun for all of life’s lovely occasions.</p>
                <a class="button" href="#collections" data-reveal>Explore the collection <span aria-hidden="true">↗</span></a>
                <p class="hero-note" data-reveal>Bloomie Flowers <span aria-hidden="true">·</span> Where every bloom becomes a beautiful memory.</p>
            </div>

            <div class="hero-specimens" aria-label="A selection of Bloomie creations" data-reveal>
                @forelse($admins->take(4) as $index => $admin)
                    <a class="hero-specimen specimen-{{ $index + 1 }}" data-category="{{ $admin->category }}" href="#{{ $admin->category }}-section" aria-label="Explore {{ $admin->title }}">
                        <img src="{{ asset('uploads/' . $admin->photo) }}" alt="{{ $admin->title }}" @if($index > 1) loading="lazy" @endif>
                    </a>
                @empty
                    <div class="hero-empty" aria-hidden="true"><x-brand-mark /></div>
                @endforelse
                <span class="hero-caption">A little something for every feeling</span>
            </div>
        </section>

        <section class="collection-section page-shell" id="collections" aria-labelledby="collections-title">
            <div class="section-heading">
                <div data-reveal><h2 id="collections-title">Find your kind of beautiful.</h2></div>
                <p class="section-intro" data-reveal>From fresh bouquets to personal keepsakes, browse creations made to make someone feel remembered.</p>
            </div>

            @if($categories->isNotEmpty())
                <nav class="category-navigation" aria-label="Browse product collections" data-reveal>
                    @foreach($categories as $category)
                        <a href="#{{ $category }}-section">{{ ucfirst($category) }} <span aria-hidden="true">↘</span></a>
                    @endforeach
                </nav>
            @endif

            <div class="catalogue" id="collections-content">
                @forelse($categories as $category)
                    <section class="catalogue-section" data-section-category="{{ $category }}" id="{{ $category }}-section" aria-labelledby="heading-{{ $category }}" data-reveal>
                        <div class="catalogue-heading">
                            <h3 id="heading-{{ $category }}">{{ ucfirst($category) }}</h3>
                            <span>{{ $admins->where('category', $category)->count() }} {{ $admins->where('category', $category)->count() === 1 ? 'creation' : 'creations' }}</span>
                        </div>

                        <div class="catalogue-grid">
                            @foreach($admins->where('category', $category) as $admin)
                                <article class="product-specimen" data-reveal>
                                    <a class="product-image" href="https://wa.me/6285692591642?text={{ rawurlencode('Hello Bloomie Flowers, I would love to order ' . $admin->title . '.') }}" target="_blank" rel="noopener" aria-label="Ask about {{ $admin->title }}">
                                        @if($admin->photo)
                                            <img src="{{ asset('uploads/' . $admin->photo) }}" alt="{{ $admin->title }}" loading="lazy">
                                        @else
                                            <span class="image-fallback" aria-hidden="true"><x-brand-mark /></span>
                                        @endif
                                        <span class="image-action" aria-hidden="true">↗</span>
                                    </a>
                                    <div class="product-details">
                                        <div class="product-title-line">
                                            <h4>{{ $admin->title }}</h4>
                                            <p class="product-price">Rp {{ number_format($admin->price, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="product-description">{{ $admin->description }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @empty
                    <div class="empty-catalogue">
                        <h3>Something lovely is taking shape.</h3>
                        <p>Our collection is being prepared. Send us a note and we will help you find the right arrangement.</p>
                        <a class="button" href="https://wa.me/6285692591642" target="_blank" rel="noopener">Talk with Bloomie</a>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="story-section" id="story" aria-labelledby="story-title">
            <div class="page-shell story-layout">
                <div class="story-title" data-reveal>
                    <h2 id="story-title">Made for the moments that stay with you.</h2>
                </div>
                <div class="story-copy" data-reveal>
                    <p>Some moments deserve more than words. Bloomie Flowers brings flowers and thoughtful handmade details together, so the feeling you want to share has something beautiful to hold onto.</p>
                    <p>Choose a piece that feels right, then message us to make it yours.</p>
                    <a class="text-link" href="https://wa.me/6285692591642" target="_blank" rel="noopener">Tell us what you have in mind <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </section>

        <section class="visit-section page-shell" id="visit" aria-labelledby="visit-title">
            <div class="visit-copy" data-reveal>
                <h2 id="visit-title">A little flower shop, close to home.</h2>
                <p>Find Bloomie Flowers in Teluk Air, Karimun. For orders and questions, we are just a WhatsApp message away.</p>
                <a class="button" href="https://wa.me/6285692591642" target="_blank" rel="noopener">Get in touch <span aria-hidden="true">↗</span></a>
            </div>
            <div class="map-frame" data-reveal>
                <iframe title="Map showing Teluk Air, Karimun" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Teluk+Air,+Karimun,+Karimun+Regency,+Riau+Islands&output=embed"></iframe>
            </div>
        </section>
    </main>
@endsection

@section('footer')
    <footer class="site-footer">
        <div class="page-shell footer-main">
            <div class="footer-brand">
                <a class="brand-lockup" href="{{ url('/') }}" aria-label="Bloomie Flowers home"><x-brand-mark /></a>
                <p>Where every bloom becomes a beautiful memory.</p>
            </div>
            <div class="footer-links">
                <p>Find us in Karimun</p>
                <a href="https://wa.me/6285692591642" target="_blank" rel="noopener">+62 856 9259 1642</a>
                <a href="https://www.instagram.com/miya.creative/?hl=id" target="_blank" rel="noopener">Instagram</a>
            </div>
        </div>
        <div class="page-shell footer-bottom"><span>© {{ date('Y') }} Bloomie Flowers</span><span>Made with care in Karimun</span></div>
    </footer>
@endsection
