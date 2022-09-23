<?php

use App\Http\Controllers\Api\V2\AddressController;
use App\Http\Controllers\Api\V2\BannerController;
use App\Http\Controllers\Api\V2\BrandController;
use App\Http\Controllers\Api\V2\CardController;
use App\Http\Controllers\Api\V2\CartController;
use App\Http\Controllers\Api\V2\CategoryController;
use App\Http\Controllers\Api\V2\CompareController;
use App\Http\Controllers\Api\V2\FeedbackController;
use App\Http\Controllers\Api\V2\LoginController;
use App\Http\Controllers\Api\V2\MenuController;
use App\Http\Controllers\Api\V2\OrderController;
use App\Http\Controllers\Api\V2\OtpController;
use App\Http\Controllers\Api\V2\PageController;
use App\Http\Controllers\Api\V2\PaymentMethodController;
use App\Http\Controllers\Api\V2\ProductController;
use App\Http\Controllers\Api\V2\ProductGroupController;
use App\Http\Controllers\Api\V2\ProfileController;
use App\Http\Controllers\Api\V2\PromotionController;
use App\Http\Controllers\Api\V2\PublicationController;
use App\Http\Controllers\Api\V2\RegisterController;
use App\Http\Controllers\Api\V2\ResetPasswordController;
use App\Http\Controllers\Api\V2\ReviewController;
use App\Http\Controllers\Api\V2\SearchController;
use App\Http\Controllers\Api\V2\SettingController;
use App\Http\Controllers\Api\V2\ShippingMethodController;
use App\Http\Controllers\Api\V2\StoreController;
use App\Http\Controllers\Api\V2\VerifyController;
use App\Http\Controllers\Api\V2\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// auth register login
Route::post('register', [RegisterController::class, 'store'])->middleware('throttle:10,60,register')->name('register');
Route::post('login', [LoginController::class, 'store'])->middleware('throttle:10,60,login')->name('login');
Route::post('otp', [OtpController::class, 'store'])->middleware('throttle:3,10,otp')->name('otp');
Route::post('otp/check', [OtpController::class, 'check'])->middleware('throttle:3,10,otp_check')->name('otp.check');
Route::post('verify/phone', [VerifyController::class, 'phone'])->middleware('throttle:10,60,verify_phone')->name('verify.phone');
Route::post('reset-password', [ResetPasswordController::class, 'store'])->middleware('throttle:10,60,reset_password')->name('reset-password');

// auth required
Route::middleware(['auth:sanctum'])->group(function(){

    // logout
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    // profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->middleware('throttle:3,10,profile_delete')->name('profile.destroy');
    Route::put('profile/password/update', [ProfileController::class, 'passwordUpdate'])->name('profile.password.update');
    Route::post('profile/image/update', [ProfileController::class, 'imageUpdate'])->name('profile.image.update');
    Route::put('profile/phone-number/update', [ProfileController::class, 'phoneNumberUpdate'])->middleware('throttle:10,60,phone_number_update')->name('profile.phone-number.update');
});

// search
Route::get('search', [SearchController::class, 'index'])->name('search.index');

// categories
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/tree', [CategoryController::class, 'tree'])->name('categories.tree');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('categories/{category}/subcategories', [CategoryController::class, 'subcategories'])->name('categories.subcategories');
Route::get('categories/{category}/brands', [CategoryController::class, 'brands'])->name('categories.brands');
Route::get('categories/{category}/attributes', [CategoryController::class, 'attributes'])->name('categories.attributes');
Route::get('categories/{category}/prices', [CategoryController::class, 'prices'])->name('categories.prices');

// brands
Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('brands/{brand}', [BrandController::class, 'show'])->name('brands.show');

// promotions
Route::get('promotions', [PromotionController::class, 'index'])->name('promotions.index');
Route::get('promotions/{promotion}', [PromotionController::class, 'show'])->name('promotions.show');

// products
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::post('products/list', [ProductController::class, 'index'])->name('products.list');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('products/{product}/attributes', [ProductController::class, 'attributes'])->name('products.attributes');
Route::get('products/{product}/stickers', [ProductController::class, 'stickers'])->name('products.stickers');
Route::get('products/{product}/categories', [ProductController::class, 'categories'])->name('products.categories');

// product groups
Route::get('product-groups/{productGroup}', [ProductGroupController::class, 'show'])->name('product-groups.show');

// banners
Route::get('banners', [BannerController::class, 'index'])->name('banners.index');

// settings
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');

// pages
Route::get('pages', [PageController::class, 'index'])->name('pages.index');
Route::get('pages/{page}', [PageController::class, 'show'])->name('pages.show');

// publications
Route::get('publications', [PublicationController::class, 'index'])->name('publications.index');
Route::get('publications/types', [PublicationController::class, 'types'])->name('publications.types');
Route::get('publications/{publication}', [PublicationController::class, 'show'])->name('publications.show');

// reviews
Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

// payment methods
Route::get('payment-methods', [PaymentMethodController::class, 'index'])->name('payment-methods.index');

// shipping methods
Route::get('shipping-methods', [ShippingMethodController::class, 'index'])->name('shipping-methods.index');

// stores
Route::get('stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('stores/{store}', [StoreController::class, 'show'])->name('stores.show');

// menus
Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
Route::get('menus/{menu}', [MenuController::class, 'show'])->name('menus.show');

// feedback
Route::post('feedback', [FeedbackController::class, 'store'])->middleware('throttle:10,1,feedback_store')->name('feedback.store');

// auth required
Route::middleware(['auth:sanctum'])->group(function(){
    // cart
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('cart/items/add', [CartController::class, 'itemsAdd'])->name('cart.items.add');
    Route::put('cart/items/update', [CartController::class, 'itemsUpdate'])->name('cart.items.update');
    Route::delete('cart/items/remove', [CartController::class, 'itemsRemove'])->name('cart.items.remove');
    Route::post('cart/items/remove/multiple', [CartController::class, 'itemsRemoveMultiple'])->name('cart.items.remove.multiple');

    // wishlist
    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::post('wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
    Route::post('wishlist/items/add', [WishlistController::class, 'itemsAdd'])->name('wishlist.items.add');
    Route::delete('wishlist/items/remove', [WishlistController::class, 'itemsRemove'])->name('wishlist.items.remove');
    Route::post('wishlist/items/remove/multiple', [WishlistController::class, 'itemsRemoveMultiple'])->name('wishlist.items.remove.multiple');

    // compare list
    Route::get('compare', [CompareController::class, 'index'])->name('compare.index');
    Route::post('compare', [CompareController::class, 'store'])->name('compare.store');
    Route::post('compare/clear', [CompareController::class, 'clear'])->name('compare.clear');
    Route::post('compare/items/add', [CompareController::class, 'itemsAdd'])->name('compare.items.add');
    Route::delete('compare/items/remove', [CompareController::class, 'itemsRemove'])->name('compare.items.remove');
    Route::post('compare/items/remove/multiple', [CompareController::class, 'itemsRemoveMultiple'])->name('compare.items.remove.multiple');

    // addresses
    Route::get('addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('addresses/{address}', [AddressController::class, 'show'])->name('addresses.show');
    Route::put('addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');

    // orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order}/order-items', [OrderController::class, 'orderItems'])->name('orders.order-items');

    // cards
    Route::get('cards', [CardController::class, 'index'])->name('cards.index');
    Route::post('cards', [CardController::class, 'store'])->name('cards.store');;
    Route::post('cards/confirm', [CardController::class, 'confirm'])->name('cards.confirm');;
    Route::delete('cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');
    Route::post('cards/{card}/set-default', [CardController::class, 'setDefault'])->name('cards.set-default');
});
