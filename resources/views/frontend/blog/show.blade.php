@extends('frontend.layouts.app')

@section('title', $post->title)

@section('content')
    @include('frontend.partials.flash')

    <nav class="mx-auto max-w-7xl px-4 lg:px-8 pt-6 text-xs text-muted-fg">
        <a href="{{ route('frontend.home') }}" class="hover:text-wine">Home</a> /
        <a href="{{ route('frontend.blog.index') }}" class="hover:text-wine">Blog</a> /
        <span class="text-wine">{{ $post->title }}</span>
    </nav>

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-8 grid lg:grid-cols-[1fr_320px] gap-10">
        <article>
            <div class="aspect-[16/9] rounded-3xl overflow-hidden bg-muted shadow-luxe mb-8">
                @if($post->featured_image)
                    <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                @endif
            </div>
            <p class="text-xs text-muted-fg mb-3">{{ $post->category?->name }} · {{ optional($post->published_at)->format('d M, Y') }}</p>
            <h1 class="font-display text-4xl md:text-5xl mb-6">{{ $post->title }}</h1>
            <div class="prose prose-neutral max-w-none text-muted-fg leading-relaxed">{!! nl2br(e($post->content)) !!}</div>
        </article>

        <aside class="bg-white rounded-2xl border border-border p-6 shadow-soft h-fit lg:sticky lg:top-24">
            <h2 class="font-display text-xl mb-4">Related Posts</h2>
            <div class="space-y-3">
                @forelse($related as $r)
                    <a href="{{ route('frontend.blog.show', $r->slug) }}" class="block rounded-xl border border-border p-4 hover:border-wine transition-colors">
                        <div class="font-medium text-sm">{{ $r->title }}</div>
                        <div class="text-xs text-muted-fg mt-1">{{ optional($r->published_at)->format('d M, Y') }}</div>
                    </a>
                @empty
                    <p class="text-sm text-muted-fg">No related posts.</p>
                @endforelse
            </div>
        </aside>
    </section>
@endsection
