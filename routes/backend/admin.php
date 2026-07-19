<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\InventoryController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\SeoController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BlogPostController;
use App\Http\Controllers\Backend\ContactInquiryController;
use App\Http\Controllers\Backend\NewsletterSubscriberController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\HomepageSectionController;
use App\Http\Controllers\Backend\ShippingMethodController;
use App\Http\Controllers\Backend\TaxRateController;


/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| These routes are for admin panel pages, accessible via /admin prefix.
|
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.showLoginForm');
Route::post('/login-details', [LoginController::class, 'login'])->name('auth.login');

Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::get('/check', function () {

    $user = auth()->user();

    return [
        'roles' => $user->getRoleNames(),
        'hasRole' => $user->hasRole('superAdmin'),
    ];

})->middleware('auth');

Route::get('/check-user', function () {

    return get_class(auth()->user());

})->middleware('auth');

Route::get('/check-role', function () {

    return [
        'roles' => auth()->user()->getRoleNames(),
        'hasRole' => auth()->user()->hasRole('superAdmin'),
    ];

})->middleware('auth');

Route::get('/debug-user', function () {

    return [
        'auth_user_class' => get_class(auth()->user()),
        'auth_user_id' => auth()->id(),
        'auth_user' => auth()->user(),
        'roles' => auth()->user()->getRoleNames(),
    ];

})->middleware('auth');

Route::group(["middleware" => ["auth", "role:superAdmin"]], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

   //===================USER Routes================================
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('users/create', [UserController::class, 'createUser'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'storeUser'])->name('users.store');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{id}/edit', [UserController::class, 'editUser'])->name('users.edit');
    Route::post('users/{id}/update', [UserController::class, 'updateUser'])->name('users.update');
    Route::any('users/{id}/destroy', [UserController::class, 'delete'])->name('users.destroy');


    //===================ORDER ROUTES================================
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('orders/create', [OrderController::class, 'createUser'])->name('orders.create');
    Route::post('/orders/store', [OrderController::class, 'storeUser'])->name('orders.store');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{id}/edit', [OrderController::class, 'editUser'])->name('orders.edit');
    Route::post('orders/{id}/update', [OrderController::class, 'updateUser'])->name('orders.update');
    Route::any('orders/{id}/destroy', [OrderController::class, 'delete'])->name('orders.destroy');



    //===================ROLE ROUTES================================
    Route::get('roles', [RoleController::class, 'index'])->name('roles');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::any('roles/{id}/destroy', [RoleController::class, 'delete'])->name('roles.destroy');


    // Product List — static paths must be registered before /products/{id}/...
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/{id}/status', [ProductController::class, 'toggleStatus'])->name('products.status');
    Route::post('/products/{id}/featured', [ProductController::class, 'toggleFeatured'])->name('products.featured');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/{id}/destroy', [ProductController::class, 'destroy'])->name('products.destroy');

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
    Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/delete', [ReviewController::class, 'destroy'])->name('reviews.delete');

    // Inventory / Stock
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::get('/inventory/adjust', [InventoryController::class, 'adjustForm'])->name('inventory.adjust');
    Route::post('/inventory/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust.store');

    // Returns / Refunds
    Route::get('/returns', [ReturnController::class, 'index'])->name('returns');
    Route::post('/returns/{id}/status', [ReturnController::class, 'updateStatus'])->name('returns.status');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');

    // SEO
    Route::get('/seo/products', [SeoController::class, 'products'])->name('seo.products');
    Route::get('/seo/products/{id}/edit', [SeoController::class, 'editProduct'])->name('seo.products.edit');
    Route::post('/seo/products/{id}/update', [SeoController::class, 'updateProduct'])->name('seo.products.update');

    Route::get('/seo/categories', [SeoController::class, 'categories'])->name('seo.categories');
    Route::get('/seo/categories/{id}/edit', [SeoController::class, 'editCategory'])->name('seo.categories.edit');
    Route::post('/seo/categories/{id}/update', [SeoController::class, 'updateCategory'])->name('seo.categories.update');

    // Blog
    Route::get('/blog/categories', [BlogCategoryController::class, 'index'])->name('blog.categories');
    Route::get('/blog/categories/create', [BlogCategoryController::class, 'create'])->name('blog.categories.create');
    Route::post('/blog/categories/store', [BlogCategoryController::class, 'store'])->name('blog.categories.store');
    Route::get('/blog/categories/{id}/edit', [BlogCategoryController::class, 'edit'])->name('blog.categories.edit');
    Route::post('/blog/categories/{id}/update', [BlogCategoryController::class, 'update'])->name('blog.categories.update');

    Route::get('/blog/posts', [BlogPostController::class, 'index'])->name('blog.posts');
    Route::get('/blog/posts/create', [BlogPostController::class, 'create'])->name('blog.posts.create');
    Route::post('/blog/posts/store', [BlogPostController::class, 'store'])->name('blog.posts.store');
    Route::get('/blog/posts/{id}/edit', [BlogPostController::class, 'edit'])->name('blog.posts.edit');
    Route::post('/blog/posts/{id}/update', [BlogPostController::class, 'update'])->name('blog.posts.update');

    // Contact + Newsletter
    Route::get('/contact-inquiries', [ContactInquiryController::class, 'index'])->name('contact.inquiries');
    Route::post('/contact-inquiries/{id}/status', [ContactInquiryController::class, 'updateStatus'])->name('contact.inquiries.status');

    Route::get('/newsletter-subscribers', [NewsletterSubscriberController::class, 'index'])->name('newsletter');
    Route::post('/newsletter-subscribers/{id}/toggle', [NewsletterSubscriberController::class, 'toggle'])->name('newsletter.toggle');

    // Homepage sections / Banners / Testimonials
    Route::get('/banners', [BannerController::class, 'index'])->name('banners');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners/store', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::post('/banners/{id}/update', [BannerController::class, 'update'])->name('banners.update');

    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials');
    Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('/testimonials/store', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('/testimonials/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::post('/testimonials/{id}/update', [TestimonialController::class, 'update'])->name('testimonials.update');

    Route::get('/homepage-sections', [HomepageSectionController::class, 'index'])->name('homepage.sections');
    Route::post('/homepage-sections/store', [HomepageSectionController::class, 'store'])->name('homepage.sections.store');
    Route::post('/homepage-sections/{id}/update', [HomepageSectionController::class, 'update'])->name('homepage.sections.update');

    // Shipping + Tax
    Route::get('/shipping-methods', [ShippingMethodController::class, 'index'])->name('shipping');
    Route::post('/shipping-methods/store', [ShippingMethodController::class, 'store'])->name('shipping.store');
    Route::post('/shipping-methods/{id}/update', [ShippingMethodController::class, 'update'])->name('shipping.update');

    Route::get('/tax-rates', [TaxRateController::class, 'index'])->name('tax');
    Route::post('/tax-rates/store', [TaxRateController::class, 'store'])->name('tax.store');
    Route::post('/tax-rates/{id}/update', [TaxRateController::class, 'update'])->name('tax.update');





});


