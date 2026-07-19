<header class="sticky top-0 z-50 glass border-b border-border-60">
    <div class="bg-gradient-wine text-cream text-[11px] tracking-[0.25em] uppercase py-2 text-center font-medium">
        Free shipping on orders above &#8377;2,999 &middot; Festive collection now live
    </div>

    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-6">
            <a href="{{ route('frontend.home') }}" class="flex items-baseline gap-1">
                <span class="font-display text-3xl font-bold text-wine">SareeInfo</span>
                <span class="font-accent italic text-gold text-lg">.</span>
            </a>

            <nav class="hidden lg:flex items-center gap-7">
                <a href="{{ route('frontend.home') }}" class="story-link text-sm font-medium text-foreground/80 hover:text-wine transition-colors">Home</a>
                <a href="{{ route('frontend.products.index') }}" class="story-link text-sm font-medium text-foreground/80 hover:text-wine transition-colors">Sarees</a>
                <a href="{{ route('frontend.products.index', ['category_id' => request('category_id')]) }}" class="story-link text-sm font-medium text-foreground/80 hover:text-wine transition-colors">Bridal</a>
                <a href="{{ route('frontend.products.index') }}" class="story-link text-sm font-medium text-foreground/80 hover:text-wine transition-colors">Silk</a>
                <a href="{{ route('frontend.blog.index') }}" class="story-link text-sm font-medium text-foreground/80 hover:text-wine transition-colors">Journal</a>
                <a href="{{ route('frontend.orders.index') }}" class="story-link text-sm font-medium text-foreground/80 hover:text-wine transition-colors">Track Order</a>
                <a href="{{ route('frontend.contact.index') }}" class="story-link text-sm font-medium text-foreground/80 hover:text-wine transition-colors">Contact</a>
            </nav>

            <div class="flex items-center gap-1.5 sm:gap-3">
                <form action="{{ route('frontend.products.index') }}" method="GET" class="hidden md:flex items-center bg-muted rounded-full px-4 py-2 w-56 lg:w-64">
                    <i class="fa-solid fa-magnifying-glass text-muted-fg text-sm"></i>
                    <input name="q" value="{{ request('q') }}" class="bg-transparent outline-none text-sm ml-2 w-full placeholder:text-muted-fg" placeholder="Search sarees, silks…">
                </form>

                <a href="{{ route('frontend.wishlist.index') }}" class="p-2 hover:text-wine relative" aria-label="Wishlist">
                    <i class="fa-regular fa-heart"></i>
                    @if(($wishlistCount ?? 0) > 0)
                        <span class="absolute -top-0.5 -right-0.5 bg-gold text-charcoal text-[10px] rounded-full w-4 h-4 grid place-items-center font-semibold">{{ $wishlistCount }}</span>
                    @endif
                </a>

                <a href="{{ route('frontend.cart.index') }}" class="p-2 hover:text-wine relative" aria-label="Cart">
                    <i class="fa-solid fa-bag-shopping"></i>
                    @if(($cartCount ?? 0) > 0)
                        <span class="absolute -top-0.5 -right-0.5 bg-wine text-cream text-[10px] rounded-full w-4 h-4 grid place-items-center font-semibold">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <a href="{{ route('frontend.orders.index') }}" class="p-2 hover:text-wine hidden sm:block" aria-label="Account">
                        <i class="fa-regular fa-user"></i>
                    </a>
                @else
                    <a href="{{ route('auth.showLoginForm') }}" class="p-2 hover:text-wine hidden sm:block" aria-label="Sign In">
                        <i class="fa-regular fa-user"></i>
                    </a>
                @endauth

                <button type="button" id="mobile-menu-btn" class="lg:hidden p-2" aria-label="Menu">
                    <i class="fa-solid fa-bars" id="mobile-menu-icon-open"></i>
                    <i class="fa-solid fa-xmark hidden" id="mobile-menu-icon-close"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="lg:hidden hidden border-t border-border bg-card">
        <nav class="px-4 py-4 flex flex-col gap-1">
            <a href="{{ route('frontend.home') }}" class="px-3 py-2.5 rounded-md hover:bg-muted text-sm font-medium">Home</a>
            <a href="{{ route('frontend.products.index') }}" class="px-3 py-2.5 rounded-md hover:bg-muted text-sm font-medium">Sarees</a>
            <a href="{{ route('frontend.blog.index') }}" class="px-3 py-2.5 rounded-md hover:bg-muted text-sm font-medium">Journal</a>
            <a href="{{ route('frontend.orders.index') }}" class="px-3 py-2.5 rounded-md hover:bg-muted text-sm font-medium">Track Order</a>
            <a href="{{ route('frontend.contact.index') }}" class="px-3 py-2.5 rounded-md hover:bg-muted text-sm font-medium">Contact</a>
            <a href="{{ route('frontend.wishlist.index') }}" class="px-3 py-2.5 rounded-md hover:bg-muted text-sm font-medium">Wishlist</a>
            <a href="{{ route('frontend.cart.index') }}" class="px-3 py-2.5 rounded-md hover:bg-muted text-sm font-medium">Cart</a>
        </nav>
    </div>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('mobile-menu-icon-open');
        const iconClose = document.getElementById('mobile-menu-icon-close');

        if (!btn || !menu) return;

        btn.addEventListener('click', function () {
            const isOpen = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden', isOpen);
            iconOpen.classList.toggle('hidden', !isOpen);
            iconClose.classList.toggle('hidden', isOpen);
        });
    });
</script>
@endpush
