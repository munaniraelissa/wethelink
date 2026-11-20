<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyLocationController;
use App\Http\Controllers\CompanyRegistrationController;
use App\Http\Controllers\Dashboard\ContactMessageController;
use App\Http\Controllers\Dashboard\HomepageFeatureController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::view('/user-details', 'dashboard.user-details')->name('user.details');
Route::view('/users', 'dashboard.users')->name('users');
Route::view('/add-user', 'dashboard.add-user')->name('add.user');
Route::view('/profile', 'dashboard.profile')->name('profile');
Route::view('/charts', 'dashboard.charts')->name('charts');
Route::view('/tables', 'dashboard.tables')->name('tables');
Route::view('/forms', 'dashboard.forms')->name('forms');
Route::view('/components', 'dashboard.components')->name('components');
Route::view('/alerts', 'dashboard.alerts')->name('alerts');
Route::view('/edit-form', 'dashboard.categories.edit')->name('edit.form');
Route::view('/settings', 'dashboard.settings')->name('settings');
Route::view('/blank', 'dashboard.blank')->name('blank');
Route::view('/404', 'dashboard.404')->name('404');
Route::view('/500', 'dashboard.500')->name('500');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::view('/reset-password', 'auth.reset-password')->name('password.reset');
Route::view('/verify-email', 'auth.verify-email')->name('verification.notice');
Route::view('/confirm-password', 'auth.confirm-password')->name('password.confirm');

Route::get('/', [CmsController::class, 'index'])->name('home');
Route::get('/sectors/{slug}', [\App\Http\Controllers\SeoController::class, 'sector'])->name('sector');
Route::get('/sitemap.xml', [\App\Http\Controllers\SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [\App\Http\Controllers\SeoController::class, 'robots'])->name('robots');
Route::get('/shop', [CmsController::class, 'shop'])->name('shop');
Route::get('/manufacturers', [CmsController::class, 'manufacturers'])->name('manufacturers');
Route::get('/product/{slug}', [CmsController::class, 'detail'])->name('product.detail');
Route::post('product/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/contact', [CmsController::class, 'contact'])->name('contact');
Route::post('/contact', [CmsController::class, 'storeContactMessage'])->name('contact.store');
Route::get('/about', function () {
    $categories = Category::with('children')->get();

    return view('cms.about', compact('categories'));
})->name('about');
Route::get('/help', function () {
    $categories = Category::with('children')->get();

    return view('cms.help', compact('categories'));
})->name('help');
Route::get('/cart', [CmsController::class, 'cart'])->name('cart');
Route::get('/checkout', [CmsController::class, 'checkout'])->name('checkout');

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::view('/register', 'auth.signup')->name('register');
Route::view('/register-company', 'auth.register-company')->name('company.registration');
Route::get('/register/company', [CompanyRegistrationController::class, 'showRegistrationForm'])->name('company.registration.form');
Route::post('/register/company', [CompanyRegistrationController::class, 'registerCompany'])->name('company.registration.store');

Route::get('trans/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'rw'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('locale.switch');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/main-dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profile routes
    Route::get('/profile', function () {
        return view('dashboard.profile', ['user' => auth()->user()]);
    })->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password.update');

    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/change-status', [UserController::class, 'changeStatus'])->name('users.change-status');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    // Role Management
    Route::resource('roles', RoleController::class);

    // Subscription Package Management
    Route::resource('subscription-packages', SubscriptionPackageController::class);

    // Subscription Management
    Route::resource('subscriptions', SubscriptionController::class);
    Route::post('subscriptions/{subscription}/approve', [SubscriptionController::class, 'approve'])->name('subscriptions.approve');
    Route::post('subscriptions/{subscription}/perform-approve', [SubscriptionController::class, 'performApprove'])->name('subscriptions.perform-approve');
    Route::post('subscriptions/{subscription}/reject', [SubscriptionController::class, 'reject'])->name('subscriptions.reject');
    Route::post('subscriptions/{subscription}/perform-reject', [SubscriptionController::class, 'performReject'])->name('subscriptions.perform-reject');

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Brand Management
    Route::resource('brands', BrandController::class);

    // Size Management
    Route::resource('sizes', SizeController::class);

    // Color Management
    Route::resource('colors', ColorController::class);

    // Product Management
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/images/{image}/delete', [ProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::post('products/{product}/videos/{video}/delete', [ProductController::class, 'deleteVideo'])->name('products.videos.delete');

    Route::resource('companies', CompanyController::class);
    Route::resource('companies.locations', CompanyLocationController::class);

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/homepage-features', [HomepageFeatureController::class, 'index'])->name('homepage-features.index');
        Route::post('/homepage-features', [HomepageFeatureController::class, 'update'])->name('homepage-features.update');

        Route::resource('contact-messages', ContactMessageController::class, ['only' => ['index', 'show', 'destroy'], 'parameters' => ['contact-messages' => 'message']]);
        Route::post('contact-messages/{message}/mark-as-read', [ContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-as-read');
        Route::post('contact-messages/delete-read', [ContactMessageController::class, 'deleteRead'])->name('contact-messages.delete-read');
    });
});
