@extends('frontend.layouts.app')

@section('title', 'Order Details')

@section('content')
    @include('frontend.partials.flash')

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-xs text-muted-fg uppercase tracking-wider">Order</p>
                <h1 class="font-display text-3xl">{{ $order->order_number ?? $order->order_no ?? ('#'.$order->id) }}</h1>
            </div>
            <a href="{{ route('frontend.orders.index') }}" class="btn-outline">Back</a>
        </div>

        <div class="grid lg:grid-cols-[1fr_360px] gap-8">
            <div class="bg-white rounded-2xl border border-border shadow-soft overflow-hidden">
                <div class="px-6 py-4 border-b border-border">
                    <h2 class="font-display text-xl">Items</h2>
                </div>

                @php
                    $items = $order->relationLoaded('items') ? $order->items : ($order->items ?? collect());
                    if ($items->isEmpty() && method_exists($order, 'orderDetails')) {
                        $items = $order->orderDetails ?? collect();
                    }
                @endphp

                @if($items->isEmpty())
                    <div class="p-6 text-muted-fg">No items found.</div>
                @else
                    <div class="divide-y divide-border">
                        @foreach($items as $item)
                            <div class="p-6">
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div>
                                        <div class="font-medium">{{ $item->product_name ?? $item->product?->name }}</div>
                                        <div class="text-sm text-muted-fg mt-1">Qty: {{ $item->quantity ?? 1 }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-muted-fg">&#8377;{{ number_format((float)($item->price ?? $item->unit_price ?? 0), 0) }} each</div>
                                        <div class="font-semibold text-wine">&#8377;{{ number_format((float)($item->subtotal ?? $item->total_price ?? 0), 0) }}</div>
                                    </div>
                                </div>

                                <details class="mt-4">
                                    <summary class="text-sm text-wine cursor-pointer">Request return</summary>
                                    <form method="POST" action="{{ route('frontend.returns.store') }}" class="mt-4 grid md:grid-cols-[1fr_1fr_auto] gap-3">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <input type="hidden" name="order_item_id" value="{{ $item->id ?? null }}">
                                        <input name="reason" class="px-4 py-2.5 rounded-xl border border-border text-sm" placeholder="Reason" required>
                                        <input name="details" class="px-4 py-2.5 rounded-xl border border-border text-sm" placeholder="Details (optional)">
                                        <button class="btn-outline !py-2.5" type="submit">Submit</button>
                                    </form>
                                </details>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="bg-white rounded-2xl border border-border p-6 shadow-soft h-fit">
                <h2 class="font-display text-xl mb-4">Summary</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-muted-fg">Status</span><span class="font-medium">{{ $order->status ?? $order->order_status ?? 'pending' }}</span></div>
                    <div class="flex justify-between"><span class="text-muted-fg">Payment</span><span class="font-medium">{{ $order->payment_status ?? 'pending' }}</span></div>
                    <div class="flex justify-between"><span class="text-muted-fg">Total</span><span class="font-display text-xl text-wine">&#8377;{{ number_format((float)($order->total ?? $order->grand_total ?? 0), 0) }}</span></div>
                </div>

                <div class="my-5 gold-divider"></div>

                <div class="space-y-3 text-sm">
                    <div>
                        <div class="text-muted-fg text-xs uppercase tracking-wider mb-1">Shipping address</div>
                        <div>{{ $order->shipping_address ?? '-' }}</div>
                    </div>
                    @if(!empty($order->phone))
                        <div>
                            <div class="text-muted-fg text-xs uppercase tracking-wider mb-1">Phone</div>
                            <div>{{ $order->phone }}</div>
                        </div>
                    @endif
                    @if(!empty($order->email))
                        <div>
                            <div class="text-muted-fg text-xs uppercase tracking-wider mb-1">Email</div>
                            <div>{{ $order->email }}</div>
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </section>
@endsection
