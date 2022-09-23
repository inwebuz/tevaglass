<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\Voyager\ExportController;
use App\Http\Controllers\Voyager\ImportController;
use App\Http\Controllers\Voyager\StatusController;
use App\Http\Controllers\Voyager\VoyagerOrderController;
use App\Http\Controllers\Voyager\VoyagerProductAttributesTemplateController;
use App\Http\Controllers\Voyager\VoyagerProductController;
use App\Http\Controllers\Voyager\VoyagerProductGroupController;
use App\Http\Controllers\Voyager\VoyagerSubscriberController;
use App\Http\Controllers\Voyager\VoyagerUserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ZoodpayController;
use App\Http\Middleware\CheckRedirects;
use App\Http\Middleware\ForceLowercaseUrls;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use TCG\Voyager\Facades\Voyager;

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

// Voyager admin routes
Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'auth'], function(){

        // status activate/deactivate
        Route::get('/status/activate', [StatusController::class, 'activate'])->name('voyager.status.activate');
        Route::get('/status/deactivate', [StatusController::class, 'deactivate'])->name('voyager.status.deactivate');

        // product attributes
        Route::get('/products/{product}/attributes/edit', [VoyagerProductController::class, 'attributesEdit'])->name('voyager.products.attributes.edit');
        Route::post('/products/{product}/attributes', [VoyagerProductController::class, 'attributesUpdate'])->name('voyager.products.attributes.update');

        // product attributes templates
        Route::get('/product_attributes_templates/{product_attributes_template}/builder', [VoyagerProductAttributesTemplateController::class, 'builderEdit'])->name('voyager.product_attributes_templates.builder');
        Route::post('/product_attributes_templates/{product_attributes_template}/builder', [VoyagerProductAttributesTemplateController::class, 'builderUpdate']);

        // product groups
        Route::get('/product_groups/{product_group}/settings', [VoyagerProductGroupController::class, 'settings'])->name('voyager.product_groups.settings');
        Route::put('/product_groups/{product_group}/attributes/update', [VoyagerProductGroupController::class, 'attributesUpdate'])->name('voyager.product_groups.attributes.update');
        Route::put('/product_groups/{product_group}/attribute-values/update', [VoyagerProductGroupController::class, 'attributeValuesUpdate'])->name('voyager.product_groups.attribute_values.update');
        Route::get('/product_groups/{product_group}/products/create', [VoyagerProductGroupController::class, 'productsCreate'])->name('voyager.product_groups.products.create');
        Route::get('/product_groups/{product_group}/products', [VoyagerProductGroupController::class, 'productsIndex'])->name('voyager.product_groups.products.index');
        Route::post('/product_groups/{product_group}/products', [VoyagerProductGroupController::class, 'productsStore'])->name('voyager.product_groups.products.store');
        Route::post('/product_groups/{product_group}/products/{product}/detach', [VoyagerProductGroupController::class, 'productsDetach'])->name('voyager.product_groups.products.detach');

        // orders
        Route::post('/orders/{order}/delivery/store', [VoyagerOrderController::class, 'deliveryStore'])->name('voyager.orders.delivery.store');
        Route::post('/orders/{order}/refund/store', [VoyagerOrderController::class, 'refundStore'])->name('voyager.orders.refund.store');
        Route::post('/orders/{order}/status/update', [VoyagerOrderController::class, 'statusUpdate'])->name('voyager.orders.status.update');

        // import
        Route::get('/import', [ImportController::class, 'index'])->name('voyager.import.index');
        Route::post('/import/products', [ImportController::class, 'products'])->name('voyager.import.products');
        Route::post('/import/smartup/products', [ImportController::class, 'smartupProducts'])->name('voyager.import.smartup.products');

        // export
        Route::get('/export', [ExportController::class, 'index'])->name('voyager.export.index');
        Route::get('/export/products/store', [ExportController::class, 'productsStore'])->name('voyager.export.products.store');
        Route::get('/export/products/store/full', [ExportController::class, 'productsStoreFull'])->name('voyager.export.products.store.full');
        Route::post('/export/products/download', [ExportController::class, 'productsDownload'])->name('voyager.export.products.download');

        // download subscribers
        Route::get('/subscribers/download', [VoyagerSubscriberController::class, 'download'])->name('voyager.subscribers.download');

        // user
        Route::get('/users/{user}/api_tokens', [VoyagerUserController::class, 'apiTokens'])->name('voyager.users.api_tokens');
        Route::post('/users/{user}/api_tokens', [VoyagerUserController::class, 'apiTokensStore'])->name('voyager.users.api_tokens.store');
    });

    Voyager::routes();
});

// telegram bot
Route::post('telegram-bot', [TelegramBotController::class, 'index'])->name('telegram-bot');
Route::get('telegram-bot/sethook', [TelegramBotController::class, 'sethook'])->name('telegram-bot.sethook');
Route::get('telegram-bot/deletehook', [TelegramBotController::class, 'deletehook'])->name('telegram-bot.deletehook');

// Payment
Route::post('paycom', [PaymentGatewayController::class, 'paycom'])->name('payment-gateway.paycom');
Route::any('click/prepare', [PaymentGatewayController::class, 'click'])->name('payment-gateway.click.prepare');
Route::any('click/complete', [PaymentGatewayController::class, 'click'])->name('payment-gateway.click.complete');
Route::any('zoodpay', [PaymentGatewayController::class, 'zoodpay'])->name('payment-gateway.zoodpay');
Route::any('atmos', [PaymentGatewayController::class, 'atmos'])->name('payment-gateway.atmos');

Route::get('testing', [TestingController::class, 'index'])->name('testing.index');

// synchronization
// Route::post('synchro/torgsoft-LYtkVn6MhH2TqdhK', [SynchroController::class, 'torgsoft'])->name('synchro.torgsoft');
// Route::get('synchro/torgsoft', [SynchroController::class, 'torgsoft'])->name('synchro.torgsoft.get');

// Localized site routes
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ /*'localeSessionRedirect', */'localizationRedirect', 'localeViewPath', 'localize', ForceLowercaseUrls::class, CheckRedirects::class  ]
    ],  function() {

    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    // Route::group(['middleware' => ['auth']], function() {

    // home page
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('about', [PageController::class, 'about'])->name('about');

    // sitemap
    Route::get('/sitemap/index', [SitemapController::class, 'index'])->name('sitemap.index');
    Route::get('/sitemap/create', [SitemapController::class, 'create'])->name('sitemap.create');

    // search
    Route::get('search', [SearchController::class, 'index'])->name('search');

    // contacts
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts');
    Route::post('contacts/send', [ContactController::class, 'send'])->name('contacts.send');

    // subscriber
    Route::post('subscriber/subscribe', [SubscriberController::class, 'subscribe'])->name('subscriber.subscribe');
    Route::get('subscriber/unsubscribe', [SubscriberController::class, 'unsubscribe'])->name('subscriber.unsubscribe');

    // brand view
    // Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
    // Route::get('brand/{brand}-{slug}', [BrandController::class, 'show'])->name('brands.show');

    // brand view
    Route::get('portfolio', [ProjectController::class, 'index'])->name('portfolio');
    Route::get('project/{project}-{slug}', [ProjectController::class, 'show'])->name('projects.show');

    // product view
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('category/{category}-{slug}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('product/{product}-{slug}', [ProductController::class, 'show'])->name('products.show');

    // reviews
    Route::post('reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

    // publications pages
    Route::get('news', [PublicationController::class, 'news'])->name('news.index');
    Route::get('publications/{publication}-{slug}', [PublicationController::class, 'show'])->name('publications.show');
    Route::get('publications/{publication}/increment/views', [PublicationController::class, 'incrementViews'])->name('publications.increment.views');
    Route::get('publications/{publication}-{slug}/print', [PublicationController::class, 'print'])->name('publications.print');

    // banner statistics routes
    Route::get('banner/{banner}/increment/clicks', [BannerController::class, 'incrementClicks'])->name('banner.increment.clicks');
    Route::get('banner/{banner}/increment/views', [BannerController::class, 'incrementViews'])->name('banner.increment.views');
    // });

    // order routes
    // Route::get('order/{order}-{check}', [OrderController::class, 'show'])->name('order.show');
    // Route::get('order/{order}-{check}/print', [OrderController::class, 'print'])->name('order.print');
    // Route::post('order', [OrderController::class, 'add'])->name('order.add');

    // profile routes
    // Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    // Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // auth routes
    Auth::routes(['verify' => true]);

    // regular pages
    Route::get('page/{page}-{slug}', [PageController::class, 'index'])->name('pages.show');
    Route::get('page/{page}-{slug}/print', [PageController::class, 'print'])->name('page.print');
});

// non localized routes

// captcha
Route::get('/refereshcaptcha', [HelperController::class, 'refereshCaptcha']);

// cache clear and optimize
Route::get('/cache/optimize/{check}', [CacheController::class, 'optimize'])->name('cache.optimize');
Route::get('/cache/view/clear/{check}', [CacheController::class, 'viewClear'])->name('cache.view.clear');
