@extends('frontend.layouts.app')

@section('title', 'Fashion Journal')

@section('content')
    @include('frontend.partials.flash')

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-10">
        <p class="text-xs tracking-[0.3em] uppercase text-gold mb-2">Journal</p>
        <h1 class="font-display text-4xl md:text-5xl">Fashion Journal</h1>
        <p class="text-sm text-muted-fg mt-2">Trends, styling tips, and saree stories.</p>
    </section>

    <section class="mx-auto max-w-7xl px-4 lg:px-8 pb-20">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('frontend.blog.index') }}" class="px-4 py-2 rounded-full text-sm {{ request('category') ? 'border border-border' : 'bg-wine text-cream' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('frontend.blog.index', ['category' => $cat->slug]) }}"
                       class="px-4 py-2 rounded-full text-sm {{ request('category') === $cat->slug ? 'bg-wine text-cream' : 'border border-border' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
            <form method="GET" action="{{ route('frontend.blog.index') }}" class="flex gap-2">
                <input name="q" value="{{ request('q') }}" class="px-4 py-2.5 rounded-full border border-border bg-white outline-none text-sm w-64" placeholder="Search articles...">
                <button class="btn-outline !py-2.5 !px-5" type="submit">Search</button>
            </form>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($posts as $post)
                <article class="bg-white rounded-2xl border border-border overflow-hidden shadow-soft hover:shadow-luxe transition-shadow">
                    <a href="{{ route('frontend.blog.show', $post->slug) }}" class="block aspect-[16/10] bg-muted overflow-hidden">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                        @endif
                    </a>
                    <div class="p-6">
                        <p class="text-xs text-muted-fg mb-2">{{ $post->category?->name }} · {{ optional($post->published_at)->format('d M, Y') }}</p>
                        <a href="{{ route('frontend.blog.show', $post->slug) }}">
                            <h2 class="font-display text-xl hover:text-wine transition-colors">{{ $post->title }}</h2>
                        </a>
                        <p class="text-sm text-muted-fg mt-3">{{ $post->excerpt }}</p>
                        <a href="{{ route('frontend.blog.show', $post->slug) }}" class="inline-block mt-4 text-sm text-wine story-link">Read more &rarr;</a>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-border bg-muted p-10 text-center text-muted-fg">No posts found.</div>
            @endforelse
        </div>

        <div class="mt-8">{{ $posts->links() }}</div>
    </section>
@endsection
