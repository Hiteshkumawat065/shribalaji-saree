@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    @include('frontend.partials.flash')

    @php
        $isDbCart = $cart instanceof \App\Models\Cart;
        $items = $isDbCart ? ($cart->items ?? collect()) : $cart;
        $subtotal = $isDbCart ? (float)$cart->subtotal : (float)collect($items)->sum('subtotal');
        $appliedCoupon = session('applied_coupon');
        $discount = !empty($appliedCoupon['discount']) ? (float)$appliedCoupon['discount'] : 0;
        $tax = $isDbCart ? (float)$cart->tax : ($subtotal * 0.08);
        $total = $isDbCart ? (float)$cart->total : ($subtotal + $tax - $discount);
    @endphp

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-12 grid lg:grid-cols-[1fr_380px] gap-10">
        <div>
            <h1 class="font-display text-4xl mb-8">
                Your Cart
                <span class="text-muted-fg text-lg">({{ $items->count() }} {{ Str::plural('item', $items->count()) }})</span>
            </h1>

            @if($items->isEmpty())
                <div class="rounded-2xl border border-border bg-muted p-10 text-center text-muted-fg">
                    Your cart is empty.
                    <div class="mt-4">
                        <a href="{{ route('frontend.products.index') }}" class="btn-primary">Start Shopping</a>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($items as $item)
                        @php
                            $product = $isDbCart ? $item->product : $item->product;
                            $removeId = $isDbCart ? $item->id : ($item->id ?? null);
                            $image = ($product && !empty($product->image_path))
                                ? asset('storage/'.$product->image_path)
                                : asset('frontend/images/cat-silk.jpg');
                        @endphp
                        <div class="flex gap-4 p-5 bg-white rounded-2xl border border-border shadow-soft">
                            <img src="{{ $image }}" alt="{{ $product?->name }}" class="w-24 h-32 rounded-xl object-cover">
                            <div class="flex-1">
                                <p class="text-xs text-gold uppercase tracking-wider">{{ $product?->category?->name }}</p>
                                <h3 class="font-display text-lg">{{ $product?->name }}</h3>
                                <div class="flex items-center justify-between mt-4 flex-wrap gap-3">
                                    @if($isDbCart)
                                        <form method="POST" action="{{ route('frontend.cart.quantity', $item->id) }}" class="flex items-center border border-border rounded-full">
                                            @csrf
                                            <input type="number" name="quantity" min="1" value="{{ $item->quantity }}" class="w-16 px-3 py-2 bg-transparent outline-none text-sm text-center">
                                            <button type="submit" class="px-3 py-2 text-xs text-wine">Update</button>
                                        </form>
                                    @else
                                        <span class="text-sm text-muted-fg">Qty: {{ $item->quantity }}</span>
                                    @endif
                                    <p class="font-display text-xl text-wine">&#8377;{{ number_format((float)$item->subtotal, 0) }}</p>
                                </div>
                                <form method="POST" action="{{ route('frontend.cart.remove', $removeId) }}" class="mt-3">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-600 hover:underline">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('frontend.products.index') }}" class="text-sm text-wine story-link">&larr; Continue shopping</a>
                    <form method="POST" action="{{ route('frontend.cart.clear') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">Clear cart</button>
                    </form>
                </div>
            @endif
        </div>

        @if(!$items->isEmpty())
            <aside class="bg-white rounded-2xl border border-border p-7 shadow-soft h-fit lg:sticky lg:top-24">
                <h2 class="font-display text-2xl mb-5">Order Summary</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-muted-fg">Subtotal</span><span>&#8377;{{ number_format($subtotal, 0) }}</span></div>
                    <div class="flex justify-between"><span class="text-muted-fg">Tax (8%)</span><span>&#8377;{{ number_format($tax, 0) }}</span></div>
                    <div class="flex justify-between"><span class="text-muted-fg">Discount</span><span>- &#8377;{{ number_format($discount, 0) }}</span></div>
                </div>
                <div class="my-4 gold-divider"></div>
                <div class="flex justify-between font-display text-2xl"><span>Total</span><span class="text-wine">&#8377;{{ number_format($total, 0) }}</span></div>

                <div class="mt-5">
                    @if(!empty($appliedCoupon))
                        <div class="flex items-center justify-between border border-border rounded-xl px-4 py-3 text-sm">
                            <div>
                                <div class="text-muted-fg text-xs">Applied</div>
                                <div class="font-semibold">{{ $appliedCoupon['code'] }}</div>
                            </div>
                            <form method="POST" action="{{ route('frontend.coupon.remove') }}">
                                @csrf
                                <button type="submit" class="text-xs text-red-600">Remove</button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('frontend.coupon.apply') }}" class="flex gap-2">
                            @csrf
                            <input name="code" class="flex-1 px-4 py-2.5 rounded-full border border-border bg-white outline-none text-sm" placeholder="Coupon code">
                            <button type="submit" class="btn-outline !py-2.5 !px-5">Apply</button>
                        </form>
                    @endif
                </div>

                <a href="{{ route('frontend.checkout.index') }}" class="btn-primary w-full justify-center mt-6">Proceed to Checkout</a>
                <p class="text-[11px] text-muted-fg mt-3 text-center">Secure checkout · Easy 7-day returns</p>
            </aside>
        @endif
    </section>
@endsection
