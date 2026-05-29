<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class CmsController extends Controller
{
    public function __construct()
    {
        $locale = session('locale', config('app.locale'));
        app()->setLocale($locale);
    }

    protected function ensurePublicCms(): void
    {
        $publicCms = public_path('cms');
        if (!File::isDirectory($publicCms)) {
            try {
                File::makeDirectory($publicCms, 0755, true);
            } catch (\Exception $e) {
                Log::warning('Could not create public/cms directory: ' . $e->getMessage());
            }
        }
    }

    public function index()
    {
        $this->ensurePublicCms();
        return view('cms.index');
    }

    public function shop()
    {
        $this->ensurePublicCms();
        return view('cms.shop');
    }

    public function detail()
    {
        $this->ensurePublicCms();
        return view('cms.detail');
    }

    public function contact()
    {
        $this->ensurePublicCms();
        return view('cms.contact');
    }

    public function cart()
    {
        $this->ensurePublicCms();
        return view('cms.cart');
    }

    public function checkout()
    {
        $this->ensurePublicCms();
        return view('cms.checkout');
    }
}
