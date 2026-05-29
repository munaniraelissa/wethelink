<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CmsController;

Route::get('/', [CmsController::class, 'index'])->name('home');
Route::get('/shop', [CmsController::class, 'shop'])->name('shop');
Route::get('/detail', [CmsController::class, 'detail'])->name('detail');
Route::get('/contact', [CmsController::class, 'contact'])->name('contact');
Route::get('/cart', [CmsController::class, 'cart'])->name('cart');
Route::get('/checkout', [CmsController::class, 'checkout'])->name('checkout');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.signup')->name('register');

Route::get('/lang/{locale}', function ($locale) {
    $availableLocales = ['en', 'rw'];

    if (in_array($locale, $availableLocales, true)) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }

    // Try to redirect back to the previous page; if no previous URL is available
    // (or it's the current request), redirect to the named `home` route.
    $previous = url()->previous();
    if ($previous && $previous !== request()->fullUrl()) {
        return redirect()->to($previous);
    }

    return redirect()->route('home');
})->name('locale.switch');
Route::get('/main-dashboard', function () {
    return view('dashboard.index');
});
