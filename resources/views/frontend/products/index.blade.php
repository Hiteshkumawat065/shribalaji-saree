@extends('frontend.layouts.app')

@section('title', 'Shop Sarees')

@section('content')
    @include('frontend.partials.flash')

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-10">
        <p class="text-xs tracking-[0.3em] uppercase text-gold mb-2">Shop all</p>
        <h1 class="font-display text-4xl md:text-5xl">Our Saree Boutique</h1>
        <p class="text-sm text-muted-fg mt-2">{{ $products->total() }} weaves &middot; Free shipping above &#8377;2,999</p>
    </section>

    <section class="mx-auto max-w-7xl px-4 lg:px-8 pb-20 grid lg:grid-cols-[260px_1fr] gap-8">
        <aside>
            <div class="rounded-2xl bg-white border border-border shadow-soft overflow-hidden">
                <div class="px-5 py-4 border-b border-border bg-muted/40">
                    <h2 class="font-display text-lg">Filters</h2>
                </div>

                <form method="GET" action="{{ route('frontend.products.index') }}" class="p-5 space-y-5" id="product-filters-form">
                    <div>
                        <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Search</label>
                        <input name="q" value="{{ request('q') }}" class="w-full px-4 py-2.5 rounded-full border border-border bg-white outline-none text-sm focus:ring-2 focus:ring-gold" placeholder="Search sarees...">
                    </div>

                    <div class="border-t border-border pt-5">
                        <h3 class="font-display text-base mb-3">Category</h3>
                        <ul class="space-y-2.5 text-sm max-h-64 overflow-y-auto pr-1">
                            @foreach($categories as $category)
                                <li>
                                    <label class="flex items-center gap-2.5 cursor-pointer group">
                                        <input
                                            type="checkbox"
                                            name="category_id[]"
                                            value="{{ $category->id }}"
                                            @checked(in_array((string) $category->id, $selectedCategories, true))
                                            class="w-4 h-4 rounded border-border text-wine focus:ring-gold accent-[oklch(0.38_0.13_18)]"
                                        >
                                        <span class="flex-1 group-hover:text-wine transition-colors">{{ $category->name }}</span>
                                        <span class="text-muted-fg text-xs">({{ $category->products_count }})</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="border-t border-border pt-5">
                        <h3 class="font-display text-base mb-3">Price</h3>
                        <ul class="space-y-2.5 text-sm">
                            @foreach($priceRanges as $value => $label)
                                <li>
                                    <label class="flex items-center gap-2.5 cursor-pointer group">
                                        <input
                                            type="checkbox"
                                            name="price_range[]"
                                            value="{{ $value }}"
                                            @checked(in_array($value, $selectedPriceRanges, true))
                                            class="w-4 h-4 rounded border-border text-wine focus:ring-gold accent-[oklch(0.38_0.13_18)]"
                                        >
                                        <span class="group-hover:text-wine transition-colors">{!! $label !!}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="border-t border-border pt-5">
                        <h3 class="font-display text-base mb-3">Color</h3>
                        @php
                            $colors = [
                                ['value' => 'maroon', 'class' => 'bg-red-800'],
                                ['value' => 'gold', 'class' => '', 'style' => 'background:oklch(0.78 0.13 85)'],
                                ['value' => 'emerald', 'class' => 'bg-emerald-700'],
                                ['value' => 'pink', 'class' => 'bg-pink-200'],
                                ['value' => 'cream', 'class' => 'bg-stone-100 border border-border'],
                                ['value' => 'black', 'class' => 'bg-black'],
                            ];
                            $selectedColors = (array) request('color', []);
                        @endphp
                        <div class="flex flex-wrap gap-2">
                            @foreach($colors as $color)
                                <label class="cursor-pointer group" title="{{ ucfirst($color['value']) }}">
                                    <input
                                        type="checkbox"
                                        name="color[]"
                                        value="{{ $color['value'] }}"
                                        @checked(in_array($color['value'], $selectedColors, true))
                                        class="sr-only peer"
                                    >
                                    <span
                                        @class([
                                            'block w-7 h-7 rounded-full ring-2 ring-offset-2 ring-transparent transition-all duration-200 ease-out',
                                            'group-hover:scale-110 group-hover:ring-wine/40',
                                            'peer-checked:scale-110 peer-checked:ring-wine',
                                            $color['class'],
                                        ])
                                        @if(!empty($color['style'])) style="{{ $color['style'] }}" @endif
                                    ></span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 border-t border-border pt-5">
                        <button type="submit" class="btn-primary justify-center w-full">Apply Filters</button>
                        <a href="{{ route('frontend.products.index') }}" class="btn-outline justify-center w-full">Reset Filters</a>
                    </div>
                </form>
            </div>
        </aside>

        <div>
            @if(!empty($selectedCategories) || !empty($selectedPriceRanges) || !empty($selectedColors) || request('q'))
                <div class="flex flex-wrap items-center gap-2 mb-6">
                    @if(request('q'))
                        <span class="px-3 py-1.5 rounded-full bg-blush text-wine text-xs">Search: {{ request('q') }}</span>
                    @endif
                    @foreach($categories as $category)
                        @if(in_array((string) $category->id, $selectedCategories, true))
                            <span class="px-3 py-1.5 rounded-full bg-blush text-wine text-xs">{{ $category->name }}</span>
                        @endif
                    @endforeach
                    @foreach($priceRanges as $value => $label)
                        @if(in_array($value, $selectedPriceRanges, true))
                            <span class="px-3 py-1.5 rounded-full bg-blush text-wine text-xs">{!! $label !!}</span>
                        @endif
                    @endforeach
                    @foreach($selectedColors as $color)
                        <span class="px-3 py-1.5 rounded-full bg-blush text-wine text-xs">{{ ucfirst($color) }}</span>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    @include('frontend.partials.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full rounded-2xl border border-border bg-muted p-10 text-center text-muted-fg">
                        No products found.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection
