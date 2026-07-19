@extends('frontend.layouts.app')

@section('title', 'SareeInfo — Luxury Indian Sarees, Banarasi, Silk & Bridal')

@section('content')
    @include('frontend.partials.flash')

    @php
        $categories = [
            ['name' => 'Banarasi Sarees', 'img' => 'cat-banarasi.jpg', 'count' => 248],
            ['name' => 'Silk Sarees', 'img' => 'cat-silk.jpg', 'count' => 312],
            ['name' => 'Cotton Sarees', 'img' => 'cat-cotton.jpg', 'count' => 186],
            ['name' => 'Bridal Sarees', 'img' => 'cat-bridal.jpg', 'count' => 94],
            ['name' => 'Party Wear', 'img' => 'cat-party.jpg', 'count' => 220],
            ['name' => 'Designer Collection', 'img' => 'cat-designer.jpg', 'count' => 158],
        ];
        $instagramItems = array_merge($categories, array_slice($categories, 0, 2));
        $instagramItems = array_slice($instagramItems, 0, 8);
        $patronReviews = [
            ['name' => 'Aanya Mehra', 'city' => 'Mumbai', 'initials' => 'AM', 'message' => 'The Banarasi I ordered for my engagement was beyond stunning. The gold zari work is breathtaking — true artisan craft.'],
            ['name' => 'Priya Iyer', 'city' => 'Bengaluru', 'initials' => 'PI', 'message' => 'Wore the Kanjivaram for my wedding. Every guest asked where it was from. Saaheli has my heart forever.'],
            ['name' => 'Riya Kapoor', 'city' => 'Delhi', 'initials' => 'RK', 'message' => 'Finally a saree house that respects the weave and the wearer. Delivery, packaging, fabric — flawless.'],
        ];
    @endphp

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-blush" aria-hidden="true"></div>
        <div class="mx-auto max-w-7xl px-4 lg:px-8 py-12 lg:py-20 grid lg:grid-cols-2 gap-10 items-center relative">
            <div class="space-y-7 animate-fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass shadow-soft">
                    @include('frontend.partials.icon', ['name' => 'sparkles', 'class' => 'w-3.5 h-3.5 text-gold'])
                    <span class="text-xs tracking-[0.2em] uppercase font-medium">Festive Edit {{ date('Y') }}</span>
                </span>
                <h1 class="font-display text-5xl md:text-6xl lg:text-7xl leading-[1.05] font-semibold">
                    Drape the<span class="block italic font-accent text-gradient-luxe"> poetry of silk.</span>
                </h1>
                <p class="text-lg text-muted-fg max-w-md leading-relaxed">
                    Heritage Banarasi weaves, Kanjivaram brocades and modern designer sarees — meticulously crafted by master artisans across India.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('frontend.products.index') }}" class="btn-primary group">
                        Shop Now
                        @include('frontend.partials.icon', ['name' => 'arrow-right', 'class' => 'w-4 h-4 group-hover:translate-x-1 transition-transform'])
                    </a>
                    <a href="{{ route('frontend.products.index') }}" class="btn-outline">Explore Collection</a>
                </div>
                <div class="flex items-center gap-6 pt-4">
                    <div><div class="font-display text-2xl text-wine font-semibold">25k+</div><div class="text-xs text-muted-fg tracking-wider uppercase">Happy Brides</div></div>
                    <div><div class="font-display text-2xl text-wine font-semibold">500+</div><div class="text-xs text-muted-fg tracking-wider uppercase">Master Artisans</div></div>
                    <div><div class="font-display text-2xl text-wine font-semibold">4.9&#9733;</div><div class="text-xs text-muted-fg tracking-wider uppercase">Customer Rating</div></div>
                </div>
            </div>
            <div class="relative animate-scale-in">
                <div class="absolute -inset-6 bg-gradient-gold opacity-20 blur-3xl rounded-full" aria-hidden="true"></div>
                <div class="relative aspect-[3/4] rounded-3xl overflow-hidden shadow-luxe">
                    @php
                        $heroImage = (!empty($banners) && $banners->first()?->image_path)
                            ? asset('storage/'.$banners->first()->image_path)
                            : asset('frontend/images/hero-saree.jpg');
                    @endphp
                    <img src="{{ $heroImage }}" alt="Model wearing a maroon Banarasi silk saree" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-hero-overlay" aria-hidden="true"></div>
                    <div class="absolute bottom-6 left-6 right-6 glass rounded-2xl p-4 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-gold grid place-items-center shrink-0">
                            @include('frontend.partials.icon', ['name' => 'award', 'class' => 'w-6 h-6 text-charcoal'])
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-muted-fg">Featured</p>
                            <p class="font-display text-base">
                                @if(!empty($featured) && $featured->first())
                                    {{ $featured->first()->name }} &middot; &#8377;{{ number_format((float) $featured->first()->price, 0) }}
                                @else
                                    Maharani Banarasi &middot; &#8377;18,999
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TRUST --}}
    <section class="border-y border-border bg-card">
        <div class="mx-auto max-w-7xl px-4 lg:px-8 py-6 grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([
                ['icon' => 'truck', 'title' => 'Free Shipping', 'subtitle' => 'On orders above &#8377;2,999'],
                ['icon' => 'shield-check', 'title' => 'Authentic Weaves', 'subtitle' => 'Direct from artisans'],
                ['icon' => 'refresh-cw', 'title' => 'Easy Returns', 'subtitle' => '7-day hassle-free'],
                ['icon' => 'award', 'title' => 'Premium Quality', 'subtitle' => 'Handpicked, certified'],
            ] as $item)
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-secondary text-wine grid place-items-center shrink-0">
                        @include('frontend.partials.icon', ['name' => $item['icon'], 'class' => 'w-5 h-5'])
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ $item['title'] }}</p>
                        <p class="text-xs text-muted-fg">{!! $item['subtitle'] !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CATEGORIES --}}
    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-20">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-xs tracking-[0.3em] uppercase text-gold mb-2">Shop by Weave</p>
                <h2 class="font-display text-4xl md:text-5xl">Curated Categories</h2>
            </div>
            <a href="{{ route('frontend.products.index') }}" class="hidden sm:flex items-center gap-1 text-sm font-medium story-link">
                View All
                @include('frontend.partials.icon', ['name' => 'arrow-right', 'class' => 'w-4 h-4'])
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
            @foreach($categories as $category)
                <a href="{{ route('frontend.products.index') }}" class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-soft hover:shadow-luxe transition-all">
                    <img src="{{ asset('frontend/images/'.$category['img']) }}" alt="{{ $category['name'] }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 cat-overlay"></div>
                    <div class="absolute inset-x-5 bottom-5 text-cream">
                        <p class="text-[10px] tracking-[0.3em] uppercase text-gold-soft">{{ $category['count'] }} pieces</p>
                        <h3 class="font-display text-2xl mt-1">{{ $category['name'] }}</h3>
                        <div class="mt-2 inline-flex items-center gap-1 text-sm opacity-0 group-hover:opacity-100 transition-opacity">
                            Shop
                            @include('frontend.partials.icon', ['name' => 'arrow-right', 'class' => 'w-3.5 h-3.5'])
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- THE HERITAGE EDIT --}}
    <section class="bg-gradient-blush py-20">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-xs tracking-[0.3em] uppercase text-gold mb-2">Bestsellers</p>
                <h2 class="font-display text-4xl md:text-5xl">The Heritage Edit</h2>
                <div class="gold-divider w-32 mx-auto mt-5"></div>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @php
                    $heritageBadges = [
                        0 => 'Bestseller',
                        1 => 'New',
                        3 => 'Premium',
                        5 => 'Limited',
                    ];
                @endphp
                @forelse($featured ?? [] as $index => $product)
                    @include('frontend.partials.product-card', [
                        'product' => $product,
                        'badge' => $heritageBadges[$index] ?? null,
                    ])
                @empty
                    @for($i = 0; $i < 8; $i++)
                        <div class="rounded-2xl border border-border bg-card/60 aspect-[3/4] animate-pulse"></div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    {{-- TRENDING BANNERS --}}
    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-20 grid md:grid-cols-2 gap-6">
        <div class="group relative h-[420px] rounded-3xl overflow-hidden shadow-luxe">
            <img src="{{ asset('frontend/images/banner-festive.jpg') }}" alt="Diwali Drapes" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" loading="lazy">
            <div class="absolute inset-0 banner-overlay-wine"></div>
            <div class="relative h-full flex flex-col justify-end p-8 text-cream">
                <p class="text-[11px] tracking-[0.3em] uppercase text-gold-soft">Festive Edit</p>
                <h3 class="font-display text-4xl md:text-5xl mt-2 max-w-xs">Diwali Drapes</h3>
                <p class="font-accent italic text-lg mt-2 text-cream/85">Light up the season</p>
                <a href="{{ route('frontend.products.index') }}" class="mt-5 inline-flex items-center gap-2 w-fit bg-cream text-charcoal px-6 py-3 rounded-full text-sm font-semibold hover:bg-gold transition-colors">
                    Explore
                    @include('frontend.partials.icon', ['name' => 'arrow-right', 'class' => 'w-4 h-4'])
                </a>
            </div>
        </div>
        <div class="group relative h-[420px] rounded-3xl overflow-hidden shadow-luxe">
            <img src="{{ asset('frontend/images/banner-wedding.jpg') }}" alt="The Wedding Vault" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" loading="lazy">
            <div class="absolute inset-0 banner-overlay-charcoal"></div>
            <div class="relative h-full flex flex-col justify-end p-8 text-cream">
                <p class="text-[11px] tracking-[0.3em] uppercase text-gold-soft">Bridal Couture</p>
                <h3 class="font-display text-4xl md:text-5xl mt-2 max-w-xs">The Wedding Vault</h3>
                <p class="font-accent italic text-lg mt-2 text-cream/85">For your forever day</p>
                <a href="{{ route('frontend.products.index') }}" class="mt-5 inline-flex items-center gap-2 w-fit bg-cream text-charcoal px-6 py-3 rounded-full text-sm font-semibold hover:bg-gold transition-colors">
                    Explore
                    @include('frontend.partials.icon', ['name' => 'arrow-right', 'class' => 'w-4 h-4'])
                </a>
            </div>
        </div>
    </section>

    {{-- LIMITED OFFER --}}
    <section class="bg-gradient-wine text-cream py-12">
        <div class="mx-auto max-w-7xl px-4 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div>
                <p class="text-xs tracking-[0.3em] uppercase text-gold-soft">Limited Time</p>
                <h3 class="font-display text-3xl md:text-4xl mt-1">Up to 30% off the Festive Edit</h3>
            </div>
            <div class="flex gap-3" id="festive-countdown">
                @foreach(['days' => 'Days', 'hours' => 'Hrs', 'minutes' => 'Min', 'seconds' => 'Sec'] as $unit => $label)
                    <div class="glass-dark rounded-xl px-4 py-3 min-w-16 text-center">
                        <div class="font-display text-2xl text-gold" data-countdown="{{ $unit }}">00</div>
                        <div class="text-[10px] uppercase tracking-wider text-cream/70">{{ $label }}</div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('frontend.products.index') }}" class="btn-gold shrink-0">Shop Sale</a>
        </div>
    </section>

    {{-- FROM OUR PATRONS --}}
    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-20">
        <div class="text-center mb-12">
            <p class="text-xs tracking-[0.3em] uppercase text-gold mb-2">Love Letters</p>
            <h2 class="font-display text-4xl md:text-5xl">From Our Patrons</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @if(!empty($testimonials) && $testimonials->count())
                @foreach($testimonials->take(3) as $t)
                    <div class="glass rounded-3xl p-7 shadow-soft hover:shadow-luxe transition-shadow">
                        <div class="flex gap-0.5 text-gold mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <span>&#9733;</span>
                            @endfor
                        </div>
                        <p class="font-accent italic text-lg leading-relaxed text-foreground/90">"{{ $t->message }}"</p>
                        <div class="mt-6 flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full bg-gradient-luxe text-cream grid place-items-center font-semibold">{{ strtoupper(substr($t->name, 0, 2)) }}</div>
                            <div>
                                <p class="font-medium text-sm">{{ $t->name }}</p>
                                <p class="text-xs text-muted-fg">{{ $t->designation ?? 'Customer' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @foreach($patronReviews as $review)
                    <div class="glass rounded-3xl p-7 shadow-soft hover:shadow-luxe transition-shadow">
                        <div class="flex gap-0.5 text-gold mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <span>&#9733;</span>
                            @endfor
                        </div>
                        <p class="font-accent italic text-lg leading-relaxed text-foreground/90">"{{ $review['message'] }}"</p>
                        <div class="mt-6 flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full bg-gradient-luxe text-cream grid place-items-center font-semibold">{{ $review['initials'] }}</div>
                            <div>
                                <p class="font-medium text-sm">{{ $review['name'] }}</p>
                                <p class="text-xs text-muted-fg">{{ $review['city'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    {{-- INSTAGRAM --}}
    <section class="mx-auto max-w-7xl px-4 lg:px-8 pb-20">
        <div class="text-center mb-10">
            <p class="text-xs tracking-[0.3em] uppercase text-gold mb-2">@saaheli.couture</p>
            <h2 class="font-display text-4xl md:text-5xl">Styled by You</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2 md:gap-3">
            @foreach($instagramItems as $item)
                <a href="#" class="group relative aspect-square rounded-xl overflow-hidden hover-zoom">
                    <img src="{{ asset('frontend/images/'.$item['img']) }}" alt="Instagram post" loading="lazy" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-charcoal/0 group-hover:bg-charcoal/40 transition-colors grid place-items-center">
                        <span class="text-cream opacity-0 group-hover:opacity-100 transition-opacity text-2xl">&#9825;</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- NEWSLETTER --}}
    <section class="mx-auto max-w-7xl px-4 lg:px-8 pb-20">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-luxe text-cream p-10 md:p-16 text-center shadow-luxe">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-gold/20 blur-3xl rounded-full" aria-hidden="true"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-blush/20 blur-3xl rounded-full" aria-hidden="true"></div>
            <div class="relative max-w-2xl mx-auto">
                <p class="text-xs tracking-[0.3em] uppercase text-gold-soft mb-3">Join the atelier</p>
                <h2 class="font-display text-4xl md:text-5xl">Be first to see our new drops</h2>
                <p class="mt-3 text-cream/80">Subscribe for early access to festive editions, bridal collections and private sales.</p>
                <form method="POST" action="{{ route('frontend.newsletter.subscribe') }}" class="mt-7 flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    @csrf
                    <input type="email" name="email" placeholder="your@email.com" required class="flex-1 px-5 py-3.5 rounded-full bg-cream/95 text-charcoal placeholder:text-muted-fg outline-none focus:ring-2 focus:ring-gold">
                    <button type="submit" class="btn-gold">Subscribe</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countdownRoot = document.getElementById('festive-countdown');
        if (!countdownRoot) return;

        const target = new Date();
        target.setMonth(target.getMonth() + 1, 0);
        target.setHours(23, 59, 59, 999);

        const pad = (value) => String(value).padStart(2, '0');

        const tick = () => {
            const diff = Math.max(0, target - Date.now());
            const days = Math.floor(diff / 86400000);
            const hours = Math.floor((diff % 86400000) / 3600000);
            const minutes = Math.floor((diff % 3600000) / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);

            const map = { days, hours, minutes, seconds };
            countdownRoot.querySelectorAll('[data-countdown]').forEach((el) => {
                const unit = el.getAttribute('data-countdown');
                if (map[unit] !== undefined) {
                    el.textContent = pad(map[unit]);
                }
            });
        };

        tick();
        setInterval(tick, 1000);
    });
</script>
@endpush
