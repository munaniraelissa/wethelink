<?php

namespace Tests\Feature;

use App\Models\HomepageFeature;
use App\Models\HomepageHeroSlide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class HomepageFeatureDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_can_show_and_update_homepage_features(): void
    {
        $user = User::factory()->create();
        $feature = HomepageFeature::create([
            'title' => 'Quality Product',
            'icon_class' => 'fa fa-check',
            'description' => 'Premium products with reliable quality standards.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('dashboard.homepage-features.index'));
        $response->assertOk();
        $response->assertSee('Homepage Features');

        $response = $this->post(route('dashboard.homepage-features.update'), [
            'features' => [[
                'id' => $feature->id,
                'title' => 'Updated Feature',
                'icon_class' => 'fa fa-star',
                'description' => 'Updated description',
                'sort_order' => 2,
                'is_active' => 1,
            ]],
            'hero_slides' => [],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('homepage_features', [
            'id' => $feature->id,
            'title' => 'Updated Feature',
        ]);
    }

    public function test_dashboard_can_update_homepage_hero_slides(): void
    {
        $user = User::factory()->create();
        $slide = HomepageHeroSlide::create([
            'title' => 'Welcome',
            'subtitle' => 'Discover amazing deals',
            'button_text' => 'Shop now',
            'button_url' => '/shop',
            'image_path' => 'cms/img/carousel-1.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('hero-slide.jpg');

        $response = $this->post(route('dashboard.homepage-features.update'), [
            'features' => [],
            'hero_slides' => [[
                'id' => $slide->id,
                'title' => 'Updated Hero',
                'subtitle' => 'Updated subtitle',
                'button_text' => 'Join now',
                'button_url' => '/register',
                'sort_order' => 2,
                'is_active' => 1,
            ]],
            'hero_images' => [
                $file,
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('homepage_hero_slides', [
            'id' => $slide->id,
            'title' => 'Updated Hero',
        ]);
        $this->assertDatabaseHas('homepage_hero_slides', [
            'id' => $slide->id,
        ]);
        $updatedSlide = HomepageHeroSlide::find($slide->id);
        $this->assertNotNull($updatedSlide->image_path);
        $this->assertStringContainsString('homepage-hero', $updatedSlide->image_path);
    }
}
