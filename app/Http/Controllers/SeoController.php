<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    private const PUBLIC_STATUSES = ['published', 'out_of_stock'];

    /**
     * Landing page for one business sector, e.g. /sectors/fashion-apparel.
     */
    public function sector(string $slug)
    {
        $sector = config("seo.sectors.$slug");
        abort_unless($sector, 404);

        $terms = $sector['match'] ?? [];

        $products = Product::query()
            ->whereIn('status', self::PUBLIC_STATUSES)
            ->with(['images', 'company', 'category'])
            ->withCount('reviews')
            ->where(function ($q) use ($terms) {
                // Match terms only at the start of a word ("hoe" must not match "shoe").
                foreach ($terms as $term) {
                    $term = strtolower(trim($term));
                    $starts = $term.'%';
                    $word = '% '.$term.'%';
                    $q->orWhereRaw('LOWER(name) LIKE ?', [$starts])
                        ->orWhereRaw('LOWER(name) LIKE ?', [$word])
                        ->orWhereHas('category', fn ($c) => $c->where(fn ($cc) => $cc
                            ->whereRaw('LOWER(name) LIKE ?', [$starts])
                            ->orWhereRaw('LOWER(name) LIKE ?', [$word])));
                }
            })
            ->latest()
            ->paginate(12);

        $categories = Category::where('is_active', true)->with('children')->get();

        $otherSectors = collect(config('seo.sectors'))->except($slug);

        return view('cms.sector', compact('slug', 'sector', 'products', 'categories', 'otherSectors'));
    }

    /**
     * XML sitemap of every public page so search engines can discover them.
     */
    public function sitemap()
    {
        $xml = Cache::remember('seo.sitemap', now()->addHours(6), function () {
            $urls = [
                ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
                ['loc' => route('shop'), 'priority' => '0.9', 'changefreq' => 'daily'],
                ['loc' => route('manufacturers'), 'priority' => '0.8', 'changefreq' => 'weekly'],
                ['loc' => route('about'), 'priority' => '0.5', 'changefreq' => 'monthly'],
                ['loc' => route('contact'), 'priority' => '0.5', 'changefreq' => 'monthly'],
                ['loc' => route('help'), 'priority' => '0.4', 'changefreq' => 'monthly'],
            ];

            foreach (array_keys(config('seo.sectors', [])) as $slug) {
                $urls[] = ['loc' => route('sector', $slug), 'priority' => '0.9', 'changefreq' => 'weekly'];
            }

            Category::where('is_active', true)->get(['id', 'updated_at'])->each(function ($category) use (&$urls) {
                $urls[] = [
                    'loc' => route('shop', ['category' => $category->id]),
                    'lastmod' => optional($category->updated_at)->toAtomString(),
                    'priority' => '0.7',
                    'changefreq' => 'weekly',
                ];
            });

            Product::whereIn('status', self::PUBLIC_STATUSES)
                ->whereNotNull('slug')
                ->orderByDesc('updated_at')
                ->limit(45000)
                ->get(['slug', 'updated_at'])
                ->each(function ($product) use (&$urls) {
                    $urls[] = [
                        'loc' => route('product.detail', $product->slug),
                        'lastmod' => optional($product->updated_at)->toAtomString(),
                        'priority' => '0.8',
                        'changefreq' => 'weekly',
                    ];
                });

            Company::where('status', 'active')->get(['id', 'updated_at'])->each(function ($company) use (&$urls) {
                $urls[] = [
                    'loc' => route('shop', ['manufacturer' => $company->id]),
                    'lastmod' => optional($company->updated_at)->toAtomString(),
                    'priority' => '0.6',
                    'changefreq' => 'weekly',
                ];
            });

            $out = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
            $out .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
            foreach ($urls as $url) {
                $out .= '  <url><loc>'.e($url['loc']).'</loc>';
                if (! empty($url['lastmod'])) {
                    $out .= '<lastmod>'.$url['lastmod'].'</lastmod>';
                }
                $out .= '<changefreq>'.$url['changefreq'].'</changefreq><priority>'.$url['priority'].'</priority></url>'."\n";
            }

            return $out.'</urlset>';
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /**
     * robots.txt generated from APP_URL so the sitemap link is always correct.
     */
    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            // Admin, account and template demo pages should not appear in Google.
            'Disallow: /main-dashboard',
            'Disallow: /dashboard',
            'Disallow: /cart',
            'Disallow: /checkout',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /forgot-password',
            'Disallow: /reset-password',
            'Disallow: /verify-email',
            'Disallow: /confirm-password',
            'Disallow: /trans/',
            'Disallow: /users',
            'Disallow: /user-details',
            'Disallow: /add-user',
            'Disallow: /profile',
            'Disallow: /charts',
            'Disallow: /tables',
            'Disallow: /forms',
            'Disallow: /components',
            'Disallow: /alerts',
            'Disallow: /edit-form',
            'Disallow: /settings',
            'Disallow: /blank',
            'Disallow: /404',
            'Disallow: /500',
            'Disallow: /brands',
            'Disallow: /categories',
            'Disallow: /colors',
            'Disallow: /sizes',
            'Disallow: /companies',
            'Disallow: /products',
            'Disallow: /roles',
            'Disallow: /subscriptions',
            'Disallow: /subscription-packages',
            'Disallow: /api/',
            '',
            'Sitemap: '.url('sitemap.xml'),
        ];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
