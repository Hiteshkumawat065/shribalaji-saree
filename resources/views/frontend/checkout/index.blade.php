@extends('frontend.layouts.app')

@section('title', 'Checkout')

@section('content')
    @include('frontend.partials.flash')

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-12 grid lg:grid-cols-[1fr_380px] gap-10">
        <div>
            <h1 class="font-display text-4xl mb-8">Checkout</h1>

            <div class="bg-white rounded-2xl border border-border p-7 shadow-soft">
                <form method="POST" action="{{ route('frontend.checkout.process') }}" class="space-y-4">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Name</label>
                            <input name="name" value="{{ old('name') }}" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Email</label>
                            <input name="email" type="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Phone</label>
                            <input name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Payment method</label>
                            <select name="payment_method" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold" required>
                                <option value="cod" @selected(old('payment_method')==='cod')>Cash on Delivery</option>
                                <option value="stripe" @selected(old('payment_method')==='stripe')>Stripe</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Shipping method</label>
                            <select name="shipping_method_id" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold">
                                <option value="">Default</option>
                                @foreach(($shippingMethods ?? collect()) as $m)
                                    <option value="{{ $m->id }}" @selected(old('shipping_method_id') == $m->id)>
                                        {{ $m->name }} — &#8377;{{ number_format((float)$m->cost, 0) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Shipping address</label>
                            <textarea name="shipping_address" rows="3" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold" required>{{ old('shipping_address') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Billing address</label>
                            <textarea name="billing_address" rows="3" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold" required>{{ old('billing_address') }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center mt-4">Place order</button>
                </form>
            </div>
        </div>

        <aside class="bg-white rounded-2xl border border-border p-7 shadow-soft h-fit lg:sticky lg:top-24">
            <h2 class="font-display text-2xl mb-5">Order Summary</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-muted-fg">Tax</span><span>&#8377;{{ number_format((float)($tax ?? 0), 0) }}</span></div>
                <div class="flex justify-between"><span class="text-muted-fg">Shipping</span><span>&#8377;{{ number_format((float)($shipping ?? 0), 0) }}</span></div>
                <div class="flex justify-between"><span class="text-muted-fg">Discount</span><span>- &#8377;{{ number_format((float)($discount ?? 0), 0) }}</span></div>
            </div>
            <div class="my-4 gold-divider"></div>
            <div class="flex justify-between font-display text-2xl"><span>Total</span><span class="text-wine">&#8377;{{ number_format((float)$total, 0) }}</span></div>
            <a href="{{ route('frontend.cart.index') }}" class="btn-outline w-full justify-center mt-6">Back to cart</a>
        </aside>
    </section>
@endsection
