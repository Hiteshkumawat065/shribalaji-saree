@extends('frontend.layouts.app')

@section('title', $product->name)

@section('content')
    @include('frontend.partials.flash')

    <nav class="mx-auto max-w-7xl px-4 lg:px-8 pt-6 text-xs text-muted-fg">
        <a href="{{ route('frontend.home') }}" class="hover:text-wine">Home</a> /
        <a href="{{ route('frontend.products.index') }}" class="hover:text-wine">Sarees</a> /
        <span class="text-wine">{{ $product->name }}</span>
    </nav>

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-8 grid lg:grid-cols-2 gap-10">
        <div>
            @php
                $mainImage = !empty($product->image_path)
                    ? asset('storage/'.$product->image_path)
                    : asset('frontend/images/cat-banarasi.jpg');
            @endphp
            <div class="aspect-[3/4] rounded-3xl overflow-hidden shadow-luxe bg-blush">
                <img id="product-main-image" src="{{ $mainImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>
        </div>

        <div>
            <p class="text-xs tracking-[0.3em] uppercase text-gold">{{ $product->category?->name ?? 'Saree' }}</p>
            <h1 class="font-display text-4xl md:text-5xl mt-2">{{ $product->name }}</h1>

            @php
                $approvedCount = $product->reviews->where('is_approved', true)->count();
                $avgRating = $product->reviews->where('is_approved', true)->avg('rating') ?? 0;
                $comparePrice = (float) ($product->compare_price ?? 0);
                $price = (float) $product->price;
                $discount = $comparePrice > $price ? round((($comparePrice - $price) / $comparePrice) * 100) : 0;
            @endphp

            @if($approvedCount > 0)
                <div class="flex items-center gap-3 mt-3 text-sm">
                    <span class="text-gold">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= round($avgRating) ? '&#9733;' : '&#9734;' }}
                        @endfor
                    </span>
                    <span class="text-muted-fg">{{ number_format((float)$avgRating, 1) }} ({{ $approvedCount }} reviews)</span>
                </div>
            @endif

            <div class="flex items-baseline gap-3 mt-5">
                <span class="font-display text-4xl text-wine">&#8377;{{ number_format($price, 0) }}</span>
                @if($discount > 0)
                    <span class="line-through text-muted-fg">&#8377;{{ number_format($comparePrice, 0) }}</span>
                    <span class="text-sm bg-blush text-wine px-2 py-1 rounded-full font-semibold">-{{ $discount }}%</span>
                @endif
            </div>

            @if(!empty($product->short_description))
                <p class="mt-5 text-muted-fg leading-relaxed">{{ $product->short_description }}</p>
            @endif

            <div class="mt-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-muted text-muted-fg' }}">
                    {{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}
                </span>
            </div>

            <form method="POST" action="{{ route('frontend.cart.add') }}" class="mt-8 flex flex-wrap gap-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="flex items-center border border-border rounded-full">
                    <label for="quantity" class="sr-only">Quantity</label>
                    <input id="quantity" name="quantity" type="number" min="1" value="1" class="w-20 px-4 py-3 bg-transparent outline-none text-sm text-center">
                </div>
                <button type="submit" class="btn-primary flex-1 justify-center" {{ $product->stock <= 0 ? 'disabled' : '' }}>Add to Cart</button>
            </form>

            <form method="POST" action="{{ route('frontend.wishlist.toggle') }}" class="mt-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn-outline w-full justify-center">
                    <i class="fa-regular fa-heart"></i> Add to Wishlist
                </button>
            </form>

            @if(!empty($product->description))
                <div class="mt-8 p-5 rounded-2xl bg-blush/40 border border-border">
                    <h2 class="font-display text-xl mb-3">Description</h2>
                    <div class="text-muted-fg leading-relaxed">{!! nl2br(e($product->description)) !!}</div>
                </div>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-12 grid lg:grid-cols-[1fr_380px] gap-8">
        <div>
            <h2 class="font-display text-3xl mb-6">Customer Reviews</h2>

            @if(isset($reviews) && $reviews->count())
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="glass rounded-2xl p-6 shadow-soft">
                            <div class="flex items-center justify-between gap-4">
                                <div class="font-medium">{{ $review->user?->name ?? 'Customer' }}</div>
                                <div class="text-gold text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= (int)$review->rating ? '&#9733;' : '&#9734;' }}
                                    @endfor
                                </div>
                            </div>
                            @if(!empty($review->comment))
                                <p class="text-muted-fg mt-3">{{ $review->comment }}</p>
                            @endif
                            <p class="text-xs text-muted-fg mt-2">{{ optional($review->created_at)->format('d M, Y') }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $reviews->links() }}</div>
            @else
                <div class="rounded-2xl border border-border bg-muted p-8 text-center text-muted-fg">No reviews yet. Be the first to review!</div>
            @endif
        </div>

        <aside class="bg-white rounded-2xl border border-border p-7 shadow-soft h-fit lg:sticky lg:top-24">
            <h3 class="font-display text-2xl mb-5">Write a Review</h3>
            <form method="POST" action="{{ route('frontend.reviews.store', $product->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Rating</label>
                    <select name="rating" class="w-full px-4 py-2.5 rounded-xl border border-border bg-white outline-none text-sm" required>
                        <option value="">Select</option>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Comment</label>
                    <textarea name="comment" rows="4" class="w-full px-4 py-3 rounded-xl border border-border bg-white outline-none text-sm" placeholder="Share your experience...">{{ old('comment') }}</textarea>
                </div>
                <button type="submit" class="btn-primary w-full justify-center">Submit review</button>
                <p class="text-xs text-muted-fg">Reviews are published after admin approval.</p>
            </form>
        </aside>
    </section>

    @if(!empty($relatedProducts) && $relatedProducts->count())
        <section class="mx-auto max-w-7xl px-4 lg:px-8 pb-20">
            <div class="flex items-end justify-between mb-8">
                <h2 class="font-display text-3xl">Related Sarees</h2>
                <a href="{{ route('frontend.products.index') }}" class="text-sm font-medium story-link">View all &rarr;</a>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rp)
                    @include('frontend.partials.product-card', ['product' => $rp])
                @endforeach
            </div>
        </section>
    @endif
@endsection
