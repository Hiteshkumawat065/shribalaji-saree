<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\HomepageSection;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\TaxRate;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedHomepageSections();
        $this->seedCategoriesAndProducts();
        $this->seedCoupons();
        $this->seedBanners();
        $this->seedTestimonials();
        $this->seedBlog();
        $this->seedShippingAndTax();
    }

    private function seedHomepageSections(): void
    {
        $defaults = [
            ['key' => 'trending', 'title' => 'Trending Sarees', 'subtitle' => 'Best sellers and most loved picks', 'sort_order' => 10],
            ['key' => 'new_arrivals', 'title' => 'New Arrivals', 'subtitle' => 'Fresh drops, limited pieces', 'sort_order' => 20],
            ['key' => 'testimonials', 'title' => 'What Customers Say', 'subtitle' => 'Real reviews from real shoppers', 'sort_order' => 30],
        ];

        foreach ($defaults as $row) {
            HomepageSection::firstOrCreate(
                ['key' => $row['key']],
                ['title' => $row['title'], 'subtitle' => $row['subtitle'], 'is_active' => true, 'sort_order' => $row['sort_order']]
            );
        }
    }

    private function seedCategoriesAndProducts(): void
    {
        $cats = [
            ['name' => 'Banarasi Sarees', 'slug' => 'banarasi-sarees', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Silk Sarees', 'slug' => 'silk-sarees', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Cotton Sarees', 'slug' => 'cotton-sarees', 'is_active' => true, 'sort_order' => 3],
            ['name' => 'Bridal Sarees', 'slug' => 'bridal-sarees', 'is_active' => true, 'sort_order' => 4],
            ['name' => 'Party Wear', 'slug' => 'party-wear', 'is_active' => true, 'sort_order' => 5],
            ['name' => 'Designer Collection', 'slug' => 'designer-collection', 'is_active' => true, 'sort_order' => 6],
        ];

        foreach ($cats as $c) {
            Category::updateOrCreate(
                ['slug' => $c['slug']],
                ['name' => $c['name'], 'is_active' => $c['is_active'], 'sort_order' => $c['sort_order']]
            );
        }

        Category::whereNotIn('slug', collect($cats)->pluck('slug'))->update(['is_active' => false]);

        if (Product::count() < 12) {
            $categories = Category::where('is_active', true)->get();
            $names = [
                'Royal Banarasi Zari Saree',
                'Kanjivaram Silk Wedding Saree',
                'Pastel Chiffon Party Saree',
                'Classic Cotton Dailywear Saree',
                'Festive Red & Gold Saree',
                'Elegant Floral Print Saree',
                'Temple Border Silk Saree',
                'Handloom Heritage Saree',
                'Minimalist Solid Saree',
                'Designer Sequin Saree',
                'Traditional Checks Saree',
                'Premium Bridal Collection Saree',
            ];

            foreach ($names as $i => $name) {
                $cat = $categories[$i % max(1, $categories->count())] ?? null;
                Product::create([
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . ($i + 1),
                    'description' => 'Premium saree crafted for modern elegance. Perfect for festivals, weddings, and celebrations.',
                    'short_description' => 'Premium fabric · Elegant finish · Limited stock',
                    'sku' => 'SR' . str_pad((string)($i + 1), 4, '0', STR_PAD_LEFT),
                    'price' => rand(1499, 7999),
                    'compare_price' => rand(0, 1) ? rand(7999, 12999) : null,
                    'stock' => rand(5, 60),
                    'category_id' => $cat?->id,
                    'is_active' => true,
                    'is_featured' => $i < 8,
                    'views' => rand(0, 200),
                ]);
            }
        }
    }

    private function seedCoupons(): void
    {
        $coupons = [
            ['code' => 'WELCOME10', 'discount_value' => 10, 'discount_type' => 'percentage', 'min_order_amount' => 999, 'max_uses' => 100, 'is_active' => true],
            ['code' => 'FESTIVE200', 'discount_value' => 200, 'discount_type' => 'fixed', 'min_order_amount' => 1999, 'max_uses' => 50, 'is_active' => true],
        ];

        foreach ($coupons as $c) {
            Coupon::firstOrCreate(['code' => $c['code']], $c + ['current_uses' => 0, 'expires_at' => Carbon::now()->addMonths(2)]);
        }
    }

    private function seedBanners(): void
    {
        if (Banner::count() > 0) {
            return;
        }

        Banner::create([
            'title' => 'Premium Sarees Collection',
            'subtitle' => 'Handpicked styles for weddings & festivals',
            'position' => 'home_hero',
            'is_active' => true,
            'sort_order' => 1,
            'link_url' => '/products',
        ]);

        Banner::create([
            'title' => 'Festival Offers',
            'subtitle' => 'Limited-time discounts on best sellers',
            'position' => 'home_offer',
            'is_active' => true,
            'sort_order' => 1,
            'link_url' => '/products',
        ]);
    }

    private function seedTestimonials(): void
    {
        if (Testimonial::count() > 0) {
            return;
        }

        $rows = [
            ['name' => 'Ananya Sharma', 'designation' => 'Jaipur', 'rating' => 5, 'message' => 'Beautiful fabric and premium finish. Loved the packaging too!', 'sort_order' => 1],
            ['name' => 'Meera Patel', 'designation' => 'Ahmedabad', 'rating' => 5, 'message' => 'Fast delivery and the saree looks even better in person.', 'sort_order' => 2],
            ['name' => 'Kavya Singh', 'designation' => 'Delhi', 'rating' => 4, 'message' => 'Great quality and color. Perfect for festivals.', 'sort_order' => 3],
        ];

        foreach ($rows as $r) {
            Testimonial::create($r + ['is_active' => true]);
        }
    }

    private function seedBlog(): void
    {
        if (BlogCategory::count() === 0) {
            BlogCategory::create(['name' => 'Styling Tips', 'slug' => 'styling-tips', 'is_active' => true, 'sort_order' => 1]);
            BlogCategory::create(['name' => 'Festival Edit', 'slug' => 'festival-edit', 'is_active' => true, 'sort_order' => 2]);
        }

        if (BlogPost::count() === 0) {
            $cat = BlogCategory::first();
            BlogPost::create([
                'blog_category_id' => $cat?->id,
                'title' => 'How to Style a Saree for a Wedding',
                'slug' => 'how-to-style-a-saree-for-a-wedding',
                'excerpt' => 'Simple, elegant styling tips for wedding saree looks.',
                'content' => 'Choose the right drape, balance jewelry, and pick a complementary blouse for a premium look.',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
                'views' => 10,
            ]);
        }
    }

    private function seedShippingAndTax(): void
    {
        if (ShippingMethod::count() === 0) {
            ShippingMethod::create(['name' => 'Standard Delivery', 'cost' => 99, 'min_order_amount' => 1999, 'is_active' => true, 'sort_order' => 1]);
            ShippingMethod::create(['name' => 'Express Delivery', 'cost' => 199, 'min_order_amount' => null, 'is_active' => true, 'sort_order' => 2]);
        }

        if (TaxRate::count() === 0) {
            TaxRate::create(['name' => 'GST', 'rate_percent' => 8, 'is_active' => true, 'sort_order' => 1]);
        }
    }
}

