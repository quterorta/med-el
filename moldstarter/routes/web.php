<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SliderImageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductSpecificationController;
use App\Http\Controllers\Admin\ProductSpecificationValueController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ManufacturerController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController as UserProductController;
use App\Http\Controllers\CategoryController as UserCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [BaseController::class, 'homePageView'])->name('home');
Route::get('/about-us', [BaseController::class, 'aboutUsPageView'])->name('about-us');
Route::get('/contacts', [BaseController::class, 'contactsPageView'])->name('contacts');
Route::get('/wishlist', [BaseController::class, 'wishlistPageView'])->name('wishlist');
Route::post('/set-wishlist', [BaseController::class, 'setWishlist'])->name('set-wishlist');
Route::get('/all-products', [BaseController::class, 'allProductsPageView'])->name('all-products');
Route::post('/product-contact-form', [MailController::class, 'productDetailContactForm'])->name('product-contact-form');
Route::post('/page-contact-form', [MailController::class, 'pageContactForm'])->name('page-contact-form');
Route::post('/footer-contact-form', [MailController::class, 'footerContactForm'])->name('footer-contact-form');
Route::get('/search', [BaseController::class, 'searchView'])->name('search');
Route::get('/product/{slug}', [UserProductController::class, 'productDetailView'])->name('product-detail');
Route::get('/category/{slug}/products', [UserCategoryController::class, 'categoryDetailView'])->name('category-detail');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'adminBase'])->name('admin-home');
        Route::resource('page', PageController::class);
        Route::resource('slider', SliderController::class);
        Route::resource('slider-image', SliderImageController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('product', ProductController::class);
        Route::resource('product-image', ProductImageController::class);
        Route::resource('product-specification', ProductSpecificationController::class);
        Route::resource('product-specification-value', ProductSpecificationValueController::class);
        Route::resource('partner', PartnerController::class);
        Route::resource('manufacturer', ManufacturerController::class);
    });
});

Route::post('/admin/edit-specification', [ProductSpecificationController::class, 'editSpecification'])->name('edit-specification');
Route::post('/admin/delete-specification', [ProductSpecificationController::class, 'deleteSpecification'])->name('delete-specification');

require __DIR__.'/auth.php';
