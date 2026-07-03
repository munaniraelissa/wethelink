<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HomepageFeature;
use App\Models\HomepageHeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomepageFeatureController extends Controller
{
    public function index()
    {
        $features = HomepageFeature::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $heroSlides = HomepageHeroSlide::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($features->isEmpty()) {
            $defaultFeatures = [
                [
                    'title' => 'Quality Product',
                    'icon_class' => 'fa fa-check',
                    'description' => 'Premium products with reliable quality standards.',
                    'sort_order' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => 'Free Shipping',
                    'icon_class' => 'fa fa-shipping-fast',
                    'description' => 'Fast delivery across the country for every order.',
                    'sort_order' => 2,
                    'is_active' => true,
                ],
                [
                    'title' => '14-Day Return',
                    'icon_class' => 'fas fa-exchange-alt',
                    'description' => 'Easy returns within two weeks if plans change.',
                    'sort_order' => 3,
                    'is_active' => true,
                ],
                [
                    'title' => '24/7 Support',
                    'icon_class' => 'fa fa-phone-volume',
                    'description' => 'Reach our team anytime for order help and guidance.',
                    'sort_order' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($defaultFeatures as $feature) {
                HomepageFeature::create($feature);
            }

            $features = HomepageFeature::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        }

        if ($heroSlides->isEmpty()) {
            $defaultSlides = [
                [
                    'title' => 'Welcome to We Thelink',
                    'subtitle' => 'Discover quality products and trusted suppliers.',
                    'button_text' => 'Join now',
                    'button_url' => '/register',
                    'image_path' => 'cms/img/carousel-1.jpg',
                    'sort_order' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => 'New arrivals every week',
                    'subtitle' => 'Explore fresh collections from verified manufacturers.',
                    'button_text' => 'Shop now',
                    'button_url' => '/shop',
                    'image_path' => 'cms/img/carousel-2.jpg',
                    'sort_order' => 2,
                    'is_active' => true,
                ],
            ];

            foreach ($defaultSlides as $slide) {
                HomepageHeroSlide::create($slide);
            }

            $heroSlides = HomepageHeroSlide::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        }

        return view('dashboard.homepage-features.index', compact('features', 'heroSlides'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'features' => ['nullable', 'array'],
            'features.*.title' => ['nullable', 'string', 'max:255'],
            'features.*.icon_class' => ['nullable', 'string', 'max:255'],
            'features.*.description' => ['nullable', 'string'],
            'features.*.sort_order' => ['nullable', 'integer'],
            'features.*.is_active' => ['nullable', 'boolean'],
            'hero_slides' => ['nullable', 'array'],
            'hero_slides.*.title' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.subtitle' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.button_text' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.button_url' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.image_path' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.sort_order' => ['nullable', 'integer'],
            'hero_slides.*.is_active' => ['nullable', 'boolean'],
        ]);

        foreach ($request->input('features', []) as $payload) {
            $feature = HomepageFeature::find($payload['id'] ?? null);

            if (! $feature) {
                continue;
            }

            $feature->update([
                'title' => $payload['title'],
                'icon_class' => $payload['icon_class'] ?? null,
                'description' => $payload['description'] ?? null,
                'sort_order' => $payload['sort_order'] ?? 0,
                'is_active' => (bool) ($payload['is_active'] ?? false),
            ]);
        }

        foreach ($request->input('hero_slides', []) as $index => $payload) {
            $slide = HomepageHeroSlide::find($payload['id'] ?? null);

            if (! $slide) {
                continue;
            }

            $imagePath = $payload['image_path'] ?? null;
            $uploadedImage = $request->file('hero_images.' . $index);

            if ($uploadedImage) {
                $fileName = Str::slug(pathinfo($uploadedImage->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $uploadedImage->getClientOriginalExtension();
                $uploadedImage->storeAs('homepage-hero', $fileName, 'public');
                $imagePath = 'storage/homepage-hero/' . $fileName;
            }

            $slide->update([
                'title' => $payload['title'],
                'subtitle' => $payload['subtitle'] ?? null,
                'button_text' => $payload['button_text'] ?? null,
                'button_url' => $payload['button_url'] ?? null,
                'image_path' => $imagePath,
                'sort_order' => $payload['sort_order'] ?? 0,
                'is_active' => (bool) ($payload['is_active'] ?? false),
            ]);
        }

        return redirect()->back()->with('success', 'Homepage features updated successfully.');
    }
}
