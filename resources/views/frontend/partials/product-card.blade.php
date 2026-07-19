@php
    $image = !empty($product->image_path)
        ? asset('storage/'.$product->image_path)
        : asset('frontend/images/cat-silk.jpg');
    $comparePrice = (float) ($product->compare_price ?? 0);
    $price = (float) $product->price;
    $discount = $comparePrice > $price ? round((($comparePrice - $price) / $comparePrice) * 100) : 0;
    $avgRating = round((float) ($product->avg_rating ?? 0), 1);
    $reviewCount = (int) ($product->review_count ?? 0);
    if ($reviewCount === 0 && $avgRating <= 0) {
        $avgRating = min(5, 4.5 + ($product->id % 5) * 0.1);
        $reviewCount = max(1, (int) ($product->views ?: 50));
    }
    $filledStars = (int) round($avgRating);
    $badge = $badge ?? null;
@endphp

<div class="group relative">
    <div class="hover-zoom relative aspect-[3/4] rounded-2xl bg-muted overflow-hidden shadow-soft">
        <a href="{{ route('frontend.products.show', $product->slug) }}">
            <img src="{{ $image }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover">
        </a>
        @if($badge || $discount > 0)
            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                @if($badge)
                    <span class="bg-wine text-cream text-[10px] tracking-wider uppercase font-semibold px-2.5 py-1 rounded-full">{{ $badge }}</span>
                @endif
                @if($discount > 0)
                    <span class="bg-gold text-charcoal text-[10px] font-semibold px-2.5 py-1 rounded-full">-{{ $discount }}%</span>
                @endif
            </div>
        @endif
        <form method="POST" action="{{ route('frontend.wishlist.toggle') }}" class="absolute top-3 right-3">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="w-9 h-9 rounded-full glass grid place-items-center hover:bg-wine hover:text-cream transition-all" aria-label="Wishlist">
                @include('frontend.partials.icon', ['name' => 'heart', 'class' => 'w-4 h-4'])
            </button>
        </form>
        <div class="absolute inset-x-3 bottom-3 flex gap-2 translate-y-3 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
            <a href="{{ route('frontend.products.show', $product->slug) }}" class="flex-1 glass text-foreground rounded-full py-2.5 text-xs font-semibold flex items-center justify-center gap-1.5 hover:bg-card transition-colors">
                @include('frontend.partials.icon', ['name' => 'eye', 'class' => 'w-3.5 h-3.5'])
                Quick View
            </a>
            <form method="POST" action="{{ route('frontend.cart.add') }}" class="flex-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full bg-wine text-cream rounded-full py-2.5 text-xs font-semibold flex items-center justify-center gap-1.5 hover:bg-wine-deep transition-colors" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    @include('frontend.partials.icon', ['name' => 'shopping-bag', 'class' => 'w-3.5 h-3.5'])
                    Add
                </button>
            </form>
        </div>
    </div>
    <div class="mt-4 px-1">
        <p class="text-[11px] tracking-[0.2em] uppercase text-muted-fg">{{ $product->category?->name ?? 'Saree' }}</p>
        <a href="{{ route('frontend.products.show', $product->slug) }}">
            <h3 class="font-display text-lg mt-1 leading-snug hover:text-wine transition-colors">{{ $product->name }}</h3>
        </a>
        <div class="mt-1.5 flex items-center gap-1.5 text-xs">
            <div class="flex items-center gap-0.5 text-gold">
                @for($i = 1; $i <= 5; $i++)
                    @include('frontend.partials.icon', ['name' => 'star', 'class' => 'w-3 h-3', 'filled' => $i <= $filledStars])
                @endfor
            </div>
            <span class="text-muted-fg">({{ $reviewCount }})</span>
        </div>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="font-display text-xl font-semibold text-wine">&#8377;{{ number_format($price, 0) }}</span>
            @if($comparePrice > $price)
                <span class="text-xs text-muted-fg line-through">&#8377;{{ number_format($comparePrice, 0) }}</span>
            @endif
        </div>
    </div>
</div>
