@php
  /** Active nav helper: supports patterns like admin.products* */
  $navActive = fn (string ...$patterns): string => request()->routeIs(...$patterns) ? 'active' : '';
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="{{ route('admin.dashboard') }}" class="brand-link">
    <img src="{{ asset('backend/images/site-logo.png') }}" alt="{{ config('app.name') }}" class="brand-image img-circle elevation-3" style="opacity: .92">
    <span class="brand-text font-weight-light">Saree Info</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2 pb-3">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="navigation" data-accordion="false">

        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $navActive('admin.dashboard') }}">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.users') }}" class="nav-link {{ $navActive('admin.users', 'admin.users.*') }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Users</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.products') }}" class="nav-link {{ $navActive('admin.products', 'admin.products.*') }}">
            <i class="nav-icon fas fa-boxes"></i>
            <p>Products</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.roles') }}" class="nav-link {{ $navActive('admin.roles', 'admin.roles.*') }}">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>Roles &amp; permissions</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.orders') }}" class="nav-link {{ $navActive('admin.orders', 'admin.orders.*') }}">
            <i class="nav-icon fas fa-shopping-bag"></i>
            <p>Orders</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.reviews') }}" class="nav-link {{ $navActive('admin.reviews', 'admin.reviews.*') }}">
            <i class="nav-icon fas fa-star"></i>
            <p>Reviews</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.inventory') }}" class="nav-link {{ $navActive('admin.inventory', 'admin.inventory.*') }}">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>Inventory</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.returns') }}" class="nav-link {{ $navActive('admin.returns', 'admin.returns.*') }}">
            <i class="nav-icon fas fa-undo-alt"></i>
            <p>Returns</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.notifications') }}" class="nav-link {{ $navActive('admin.notifications', 'admin.notifications.*') }}">
            <i class="nav-icon fas fa-bell"></i>
            <p>Notifications</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.seo.products') }}" class="nav-link {{ $navActive('admin.seo.*') }}">
            <i class="nav-icon fas fa-search-plus"></i>
            <p>SEO</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.blog.posts') }}" class="nav-link {{ $navActive('admin.blog.*') }}">
            <i class="nav-icon fas fa-blog"></i>
            <p>Blog</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.contact.inquiries') }}" class="nav-link {{ $navActive('admin.contact.inquiries', 'admin.contact.inquiries.*') }}">
            <i class="nav-icon fas fa-headset"></i>
            <p>Contact inquiries</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.newsletter') }}" class="nav-link {{ $navActive('admin.newsletter', 'admin.newsletter.*') }}">
            <i class="nav-icon fas fa-envelope-open-text"></i>
            <p>Newsletter</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.banners') }}" class="nav-link {{ $navActive('admin.banners', 'admin.banners.*') }}">
            <i class="nav-icon fas fa-images"></i>
            <p>Banners</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.testimonials') }}" class="nav-link {{ $navActive('admin.testimonials', 'admin.testimonials.*') }}">
            <i class="nav-icon fas fa-quote-right"></i>
            <p>Testimonials</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.homepage.sections') }}" class="nav-link {{ $navActive('admin.homepage.sections', 'admin.homepage.sections.*') }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>Homepage sections</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.shipping') }}" class="nav-link {{ $navActive('admin.shipping', 'admin.shipping.*') }}">
            <i class="nav-icon fas fa-truck"></i>
            <p>Shipping</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.tax') }}" class="nav-link {{ $navActive('admin.tax', 'admin.tax.*') }}">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
            <p>Tax</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
