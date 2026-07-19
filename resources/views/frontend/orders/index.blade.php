@extends('frontend.layouts.app')

@section('title', 'My Orders')

@section('content')
    @include('frontend.partials.flash')

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-display text-4xl">My Orders</h1>
            <a href="{{ route('frontend.products.index') }}" class="btn-outline">Shop</a>
        </div>

        <div class="bg-white rounded-2xl border border-border shadow-soft overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-muted text-muted-fg">
                        <tr>
                            <th class="text-left px-6 py-4 font-medium">Order #</th>
                            <th class="text-left px-6 py-4 font-medium">Date</th>
                            <th class="text-left px-6 py-4 font-medium">Status</th>
                            <th class="text-right px-6 py-4 font-medium">Total</th>
                            <th class="text-right px-6 py-4 font-medium"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="border-t border-border">
                                <td class="px-6 py-4 font-medium">{{ $order->order_number ?? $order->order_no ?? ('#'.$order->id) }}</td>
                                <td class="px-6 py-4 text-muted-fg">{{ optional($order->created_at)->format('d M, Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs bg-blush text-wine">
                                        {{ $order->status ?? $order->order_status ?? 'pending' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-wine">
                                    &#8377;{{ number_format((float)($order->total ?? $order->grand_total ?? 0), 0) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('frontend.orders.show', $order->id) }}" class="btn-outline !py-2 !px-4 text-xs">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-muted-fg">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">{{ $orders->links() }}</div>
    </section>
@endsection
