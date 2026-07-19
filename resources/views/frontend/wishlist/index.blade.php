@extends('frontend.layouts.app')

@section('title', 'Wishlist')

@section('content')
    @include('frontend.partials.flash')

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-display text-4xl">Wishlist</h1>
            <a href="{{ route('frontend.products.index') }}" class="btn-outline">Shop</a>
        </div>

        @if($wishlists->isEmpty())
            <div class="rounded-2xl border border-border bg-muted p-10 text-center text-muted-fg">
                Your wishlist is empty.
            </div>
        @else
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($wishlists as $wish)
                    <div class="bg-white rounded-2xl border border-border overflow-hidden shadow-soft">
                        <a href="{{ route('frontend.products.show', $wish->product->slug) }}" class="block aspect-[3/4] bg-muted overflow-hidden">
                            @if(!empty($wish->product->image_path))
                                <img src="{{ asset('storage/'.$wish->product->image_path) }}" alt="{{ $wish->product->name }}" class="w-full h-full object-cover">
                            @endif
                        </a>
                        <div class="p-4 space-y-3">
                            <div>
                                <p class="text-[11px] tracking-[0.2em] uppercase text-muted-fg">{{ $wish->product->category?->name }}</p>
                                <h3 class="font-display text-lg">{{ $wish->product->name }}</h3>
                                <p class="text-wine font-semibold mt-1">&#8377;{{ number_format((float)$wish->product->price, 0) }}</p>
                            </div>
                            <form method="POST" action="{{ route('frontend.cart.add') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $wish->product_id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button class="btn-primary w-full justify-center" type="submit">Add to cart</button>
                            </form>
                            <form method="POST" action="{{ route('frontend.wishlist.remove', $wish->id) }}">
                                @csrf
                                <button class="btn-outline w-full justify-center" type="submit">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">{{ $wishlists->links() }}</div>
        @endif
    </section>
@endsection
