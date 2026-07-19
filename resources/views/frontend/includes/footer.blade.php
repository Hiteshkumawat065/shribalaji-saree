<footer class="site-footer bg-charcoal mt-24">
    <div class="mx-auto max-w-7xl px-4 lg:px-8 py-16 grid gap-12 md:grid-cols-2 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <div class="flex items-baseline gap-1">
                <span class="font-display text-3xl font-bold text-gold">SareeInfo</span>
                <span class="font-accent italic text-gold-soft text-lg">.</span>
            </div>
            <p class="mt-4 text-sm leading-relaxed footer-muted max-w-sm">
                Handpicked heritage sarees from the looms of India. Crafted by artisans, worn by queens.
            </p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="#" aria-label="Facebook" class="social-icon-link"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                <a href="#" aria-label="Instagram" class="social-icon-link"><i class="fa-brands fa-instagram text-sm"></i></a>
                <a href="#" aria-label="X" class="social-icon-link"><i class="fa-brands fa-x-twitter text-sm"></i></a>
                <a href="#" aria-label="LinkedIn" class="social-icon-link"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                <a href="#" aria-label="YouTube" class="social-icon-link"><i class="fa-brands fa-youtube text-sm"></i></a>
            </div>
        </div>

        <div>
            <h4 class="font-display text-gold text-lg mb-4">Shop</h4>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('frontend.products.index') }}" class="footer-link">All Sarees</a></li>
                <li><a href="{{ route('frontend.products.index') }}" class="footer-link">Banarasi</a></li>
                <li><a href="{{ route('frontend.products.index') }}" class="footer-link">Kanjivaram</a></li>
                <li><a href="{{ route('frontend.products.index') }}" class="footer-link">Bridal</a></li>
                <li><a href="{{ route('frontend.products.index') }}" class="footer-link">Designer</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-display text-gold text-lg mb-4">Support</h4>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('frontend.contact.index') }}" class="footer-link">Contact Us</a></li>
                <li><a href="#" class="footer-link">Shipping</a></li>
                <li><a href="#" class="footer-link">Returns</a></li>
                <li><a href="#" class="footer-link">Size Guide</a></li>
                <li><a href="#" class="footer-link">FAQ</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-display text-gold text-lg mb-4">Company</h4>
            <ul class="space-y-2.5 text-sm">
                <li><a href="#" class="footer-link">About</a></li>
                <li><a href="#" class="footer-link">Heritage</a></li>
                <li><a href="{{ route('frontend.blog.index') }}" class="footer-link">Blog</a></li>
                <li><a href="#" class="footer-link">Press</a></li>
                <li><a href="#" class="footer-link">Careers</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t footer-divider">
        <div class="mx-auto max-w-7xl px-4 lg:px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs footer-dim">
            <div class="flex flex-wrap gap-x-6 gap-y-2">
                <span>shribalajio782@gmail.com</span>
                <span>+91 98289 99904</span>
                <span>Mansrovar · Jaipur</span>
            </div>
            <!-- <div class="flex items-center gap-3 flex-wrap justify-center">
                <span>Secure payments:</span>
                <span class="px-2 py-1 rounded border footer-border text-[10px] tracking-wider">VISA</span>
                <span class="px-2 py-1 rounded border footer-border text-[10px] tracking-wider">MC</span>
                <span class="px-2 py-1 rounded border footer-border text-[10px] tracking-wider">UPI</span>
                <span class="px-2 py-1 rounded border footer-border text-[10px] tracking-wider">AMEX</span>
                <span class="px-2 py-1 rounded border footer-border text-[10px] tracking-wider">PayPal</span>
            </div> -->
        </div>
        <div class="text-center text-[11px] footer-faint pb-6">&copy; {{ date('Y') }} SareeInfo. All rights reserved.</div>
    </div>
</footer>
