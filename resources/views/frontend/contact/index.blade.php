@extends('frontend.layouts.app')

@section('title', 'Contact Us')

@section('content')
    @include('frontend.partials.flash')

    <section class="mx-auto max-w-7xl px-4 lg:px-8 py-12 grid lg:grid-cols-2 gap-10">
        <div>
            <p class="text-xs tracking-[0.3em] uppercase text-gold mb-2">Get in touch</p>
            <h1 class="font-display text-4xl md:text-5xl mb-3">Contact Us</h1>
            <p class="text-muted-fg mb-8">We'd love to help you with your order, sizing, or any questions.</p>

            <div class="bg-white rounded-2xl border border-border p-7 shadow-soft">
                <form method="POST" action="{{ route('frontend.contact.store') }}" class="space-y-4">
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
                            <input name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold">
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Subject</label>
                            <input name="subject" value="{{ old('subject') }}" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs uppercase tracking-wider text-muted-fg mb-2 block">Message</label>
                            <textarea name="message" rows="5" class="w-full px-4 py-3 rounded-xl border border-border outline-none text-sm focus:ring-2 focus:ring-gold" required>{{ old('message') }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center">Send message</button>
                </form>
            </div>
        </div>

        <aside class="bg-white rounded-2xl border border-border p-7 shadow-soft h-fit">
            <h2 class="font-display text-2xl mb-4">Support</h2>
            <div class="space-y-3 text-sm text-muted-fg">
                <p><i class="fa-regular fa-envelope text-gold mr-2"></i> support@sareeinfo.com</p>
                <p><i class="fa-solid fa-phone text-gold mr-2"></i> +91-00000-00000</p>
                <p><i class="fa-regular fa-clock text-gold mr-2"></i> Mon–Sat, 10:00 AM – 7:00 PM</p>
            </div>
        </aside>
    </section>
@endsection
