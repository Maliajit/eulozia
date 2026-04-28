<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\BrandController as AdminBrand;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\MediaController as AdminMedia;
use App\Http\Controllers\Admin\TaxController as AdminTax;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\NotificationController as AdminNotification;
use App\Http\Controllers\Admin\CRMController as AdminCRM;
use App\Http\Controllers\Admin\ReportController as AdminReport;
use App\Http\Controllers\Admin\ShippingController as AdminShipping;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\Admin\InventoryController as AdminInventory;
use App\Http\Controllers\Admin\OfferController as AdminOffer;
use App\Http\Controllers\Admin\BannerController as AdminBanner;
use App\Http\Controllers\Admin\HomeSectionController as AdminHomeSection;
use App\Http\Controllers\Api\Admin\AttributeController as ApiAttribute;
use App\Http\Controllers\Api\Admin\AttributeValueController as ApiAttributeValue;
use App\Http\Controllers\Api\Admin\BrandController as ApiBrand;
use App\Http\Controllers\Api\Admin\TaxClassController as ApiTaxClass;
use App\Http\Controllers\Api\Admin\TaxRateController as ApiTaxRate;
use App\Http\Controllers\Api\Admin\SpecificationController as ApiSpecification;
use App\Http\Controllers\Api\Admin\SpecificationValueController as ApiSpecificationValue;
use App\Http\Controllers\Api\Admin\SpecificationGroupController as ApiSpecificationGroup;

Route::prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN AUTH
    |--------------------------------------------------------------------------
    */
    Route::get('/login', [AdminAuth::class, 'loginPage'])->name('admin.login');
    Route::post('/login', [AdminAuth::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuth::class, 'logout'])->name('admin.logout');

    /*
    |--------------------------------------------------------------------------
    | AUTHENTICATED ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard/data', [AdminDashboard::class, 'getChartData'])->name('admin.dashboard.data');

        /*
        |--------------------------------------------------------------------------
        | CATEGORY MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::prefix('categories')->group(function () {
            Route::get('/', [AdminCategory::class, 'index'])->name('admin.categories.index');
            Route::get('/data', [AdminCategory::class, 'getData'])->name('admin.categories.data'); // JSON Data
            Route::get('/dropdown', [AdminCategory::class, 'getDropdown'])->name('admin.categories.dropdown');
            Route::get('/statistics', [AdminCategory::class, 'statistics'])->name('admin.categories.statistics'); // Stats
            Route::post('/bulk-delete', [AdminCategory::class, 'bulkDelete'])->name('admin.categories.bulk-delete');
            Route::post('/bulk-status', [AdminCategory::class, 'bulkStatus'])->name('admin.categories.bulk-status');

            Route::post('/', [AdminCategory::class, 'store'])->name('admin.categories.store');
            Route::get('/create', [AdminCategory::class, 'create'])->name('admin.categories.create');

            Route::get('/{id}/edit', [AdminCategory::class, 'edit'])->name('admin.categories.edit');
            Route::put('/{id}', [AdminCategory::class, 'update'])->name('admin.categories.update');
            Route::delete('/{id}', [AdminCategory::class, 'destroy'])->name('admin.categories.destroy');
            Route::post('/{id}/toggle-status', [AdminCategory::class, 'toggleStatus'])->name('admin.categories.toggle-status');

            Route::get('/{id}', [AdminCategory::class, 'show'])->name('admin.categories.show');
        });

        Route::get('/attributes/dropdown', [AdminCategory::class, 'getAttributesDropdown'])->name('admin.categories.attributes-dropdown');
        Route::get('/specification-groups/dropdown', [AdminCategory::class, 'getSpecGroupsDropdown'])->name('admin.categories.spec-groups-dropdown');

        /*
        |--------------------------------------------------------------------------
        | BRAND MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::prefix('brands')->group(function () {
            Route::get('/', [AdminBrand::class, 'index'])->name('admin.brands.index');
            Route::get('/data', [AdminBrand::class, 'getData'])->name('admin.brands.data');
            Route::get('/statistics', [AdminBrand::class, 'statistics'])->name('admin.brands.statistics');
            Route::post('/bulk-delete', [AdminBrand::class, 'bulkDelete'])->name('admin.brands.bulk-delete');
            Route::post('/bulk-status', [AdminBrand::class, 'bulkStatus'])->name('admin.brands.bulk-status');

            Route::post('/', [AdminBrand::class, 'store'])->name('admin.brands.store');
            Route::get('/create', [AdminBrand::class, 'create'])->name('admin.brands.create');

            Route::get('/{id}/edit', [AdminBrand::class, 'edit'])->name('admin.brands.edit');
            Route::put('/{id}', [AdminBrand::class, 'update'])->name('admin.brands.update');
            Route::delete('/{id}', [AdminBrand::class, 'destroy'])->name('admin.brands.destroy');
            Route::post('/{id}/toggle-status', [AdminBrand::class, 'toggleStatus'])->name('admin.brands.toggle-status');
        });

        /*
        |--------------------------------------------------------------------------
        | PRODUCT MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::prefix('products')->group(function () {
            Route::get('/', [AdminProduct::class, 'index'])->name('admin.products.index');
            Route::get('/create', [AdminProduct::class, 'create'])->name('admin.products.create');
            Route::get('/{product}/edit', [AdminProduct::class, 'edit'])->name('admin.products.edit');
            Route::post('/', [AdminProduct::class, 'store'])->name('admin.products.store');
            Route::put('/{product}', [AdminProduct::class, 'update'])->name('admin.products.update');
            Route::delete('/{product}', [AdminProduct::class, 'destroy'])->name('admin.products.destroy');


            Route::get('/attributes', [AdminProduct::class, 'attributes'])->name('admin.products.attributes');
            Route::get('/specifications', [AdminProduct::class, 'specifications'])->name('admin.products.specifications');
            Route::get('/tags', [AdminProduct::class, 'tags'])->name('admin.products.tags');

            Route::get('/variants', [AdminProduct::class, 'variants'])->name('admin.products.variants');
            Route::get('/category/{category}/specifications', [AdminProduct::class, 'getCategorySpecifications'])->name('admin.products.category.specifications');
            Route::get('/category/{category}/attributes', [AdminProduct::class, 'getCategoryAttributes'])->name('admin.products.category.attributes');
            Route::get('/search', [AdminProduct::class, 'search'])->name('admin.products.search');
        });

        /*
        |--------------------------------------------------------------------------
        | ORDER MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::prefix('orders')->name('admin.orders.')->group(function () {
            Route::get('/', [AdminOrder::class, 'index'])->name('index');
            Route::get('/data', [AdminOrder::class, 'getOrders'])->name('data');
            Route::get('/{order}', [AdminOrder::class, 'view'])->name('view');
            Route::post('/{order}/update-status', [AdminOrder::class, 'updateStatus'])->name('update-status');
            Route::post('/{order}/update-payment-status', [AdminOrder::class, 'updatePaymentStatus'])->name('update-payment-status');
            Route::post('/{order}/update-tracking', [AdminOrder::class, 'updateTracking'])->name('update-tracking');
            Route::delete('/{order}', [AdminOrder::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [AdminOrder::class, 'bulkDelete'])->name('bulk-delete');
            Route::get('/export', [AdminOrder::class, 'export'])->name('export');
            Route::get('/{order}/invoice', [AdminOrder::class, 'printInvoice'])->name('invoice');
        });

        /*
        |--------------------------------------------------------------------------
        | MEDIA MANAGER
        |--------------------------------------------------------------------------
        */
        Route::prefix('media')->group(function () {
            Route::get('/', [AdminMedia::class, 'index'])->name('admin.media.index');
            Route::get('/data', [AdminMedia::class, 'getData'])->name('admin.media.data');
            Route::post('/upload', [AdminMedia::class, 'upload'])->name('admin.media.upload');
            Route::post('/bulk-delete', [AdminMedia::class, 'bulkDelete'])->name('admin.media.bulk-delete');
            Route::post('/{id}/update', [AdminMedia::class, 'update'])->name('admin.media.update');
            Route::delete('/{id}/delete', [AdminMedia::class, 'destroy'])->name('admin.media.delete');
        });


        /*
        |--------------------------------------------------------------------------
        | OFFERS MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::prefix('offers')->group(function () {
            Route::get('/', [AdminOffer::class, 'index'])->name('admin.offers.index');
            Route::get('/create', [AdminOffer::class, 'create'])->name('admin.offers.create');
            Route::get('/edit', [AdminOffer::class, 'create'])->name('admin.offers.edit');
        });

        /*
        |--------------------------------------------------------------------------
        | TAX SETTINGS
        |--------------------------------------------------------------------------
        */
        Route::prefix('taxes')->group(function () {
            Route::get('/', [AdminTax::class, 'index'])->name('admin.taxes.index');
        });

        /*
        |--------------------------------------------------------------------------
        | USER MANAGEMENT
        |--------------------------------------------------------------------------
        */
        Route::prefix('users')->name('admin.users.')->group(function () {
            Route::get('/', [AdminUser::class, 'index'])->name('index');
            Route::get('/create', [AdminUser::class, 'create'])->name('create');
            Route::get('/{user}/edit', [AdminUser::class, 'edit'])->name('edit');
            Route::get('/data', [AdminUser::class, 'getCustomers'])->name('data');
            Route::post('/bulk-delete', [AdminUser::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/bulk-block', [AdminUser::class, 'bulkBlock'])->name('bulk-block');
            Route::get('/export', [AdminUser::class, 'export'])->name('export');
            Route::post('/{user}/toggle-status', [AdminUser::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{user}/toggle-block', [AdminUser::class, 'toggleBlock'])->name('toggle-block');
            Route::post('/', [AdminUser::class, 'store'])->name('store');
            Route::put('/{user}', [AdminUser::class, 'update'])->name('update');
            Route::delete('/{user}', [AdminUser::class, 'destroy'])->name('destroy');
            Route::get('/{user}', [AdminUser::class, 'show'])->name('show');
        });

        /*
        |--------------------------------------------------------------------------
        | INVENTORY
        |--------------------------------------------------------------------------
        */
        Route::prefix('inventory')->group(function () {
            Route::get('/', [AdminInventory::class, 'index'])->name('admin.inventory.index');
            Route::get('/history', [AdminInventory::class, 'history'])->name('admin.inventory.history');
            Route::get('/{id}/update', [AdminInventory::class, 'updateStock'])->name('admin.inventory.update');
        });

        /*
        |--------------------------------------------------------------------------
        | NOTIFICATIONS
        |--------------------------------------------------------------------------
        */
        Route::get('/notifications', [AdminNotification::class, 'index'])->name('admin.notifications.index');

        /*
        |--------------------------------------------------------------------------
        | CRM
        |--------------------------------------------------------------------------
        */
        Route::prefix('crm')->group(function () {
            Route::get('/', [AdminCRM::class, 'index'])->name('admin.crm.index');
            Route::get('/popup', [AdminCRM::class, 'popup'])->name('admin.crm.popup');
            Route::get('/settings', [AdminCRM::class, 'settings'])->name('admin.crm.settings');

            Route::prefix('banners')->name('admin.banners.')->group(function () {
                Route::get('/', [AdminBanner::class, 'index'])->name('index');
                Route::get('/create', [AdminBanner::class, 'create'])->name('create');
                Route::post('/', [AdminBanner::class, 'store'])->name('store');
                Route::get('/{banner}/edit', [AdminBanner::class, 'edit'])->name('edit');
                Route::put('/{banner}', [AdminBanner::class, 'update'])->name('update');
                Route::delete('/{banner}', [AdminBanner::class, 'destroy'])->name('destroy');
                Route::post('/{banner}/toggle-status', [AdminBanner::class, 'toggleStatus'])->name('toggle-status');
            });

            Route::prefix('home-sections')->name('admin.home-sections.')->group(function () {
                Route::get('/', [AdminHomeSection::class, 'index'])->name('index');
                Route::get('/create', [AdminHomeSection::class, 'create'])->name('create');
                Route::post('/', [AdminHomeSection::class, 'store'])->name('store');
                Route::get('/{section}/edit', [AdminHomeSection::class, 'edit'])->name('edit');
                Route::put('/{section}', [AdminHomeSection::class, 'update'])->name('update');
                Route::delete('/{section}', [AdminHomeSection::class, 'destroy'])->name('destroy');
                Route::post('/{section}/toggle-status', [AdminHomeSection::class, 'toggleStatus'])->name('toggle-status');
            });
        });

        /*
        |--------------------------------------------------------------------------
        | REPORTS
        |--------------------------------------------------------------------------
        */
        Route::prefix('reports')->group(function () {
            Route::get('/', [AdminReport::class, 'index'])->name('admin.reports.index');
            Route::get('/sales', [AdminReport::class, 'sales'])->name('admin.reports.sales');
            Route::get('/customers', [AdminReport::class, 'customers'])->name('admin.reports.customers');
            Route::get('/products', [AdminReport::class, 'products'])->name('admin.reports.products');
        });

        /*
        |--------------------------------------------------------------------------
        | SHIPPING
        |--------------------------------------------------------------------------
        */
        Route::prefix('shipping')->group(function () {
            Route::get('/', [AdminShipping::class, 'index'])->name('admin.shipping.index');
            Route::get('/charges', [AdminShipping::class, 'charges'])->name('admin.shipping.charges');
        });

        /*
        |--------------------------------------------------------------------------
        | SETTINGS
        |--------------------------------------------------------------------------
        */
        Route::get('/settings', [AdminSetting::class, 'index'])->name('admin.settings.index');

        /*
        |--------------------------------------------------------------------------
        | PAGES MANAGEMENT
        |--------------------------------------------------------------------------
        */
        // Route::resource('pages', App\Http\Controllers\Admin\PageController::class, ['as' => 'admin']);
        Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class, ['as' => 'admin']);
        Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class, ['as' => 'admin']);

        /*
        |--------------------------------------------------------------------------
        | API ROUTES (FOR AJAX COMPONENTS)
        |--------------------------------------------------------------------------
        */
    });
});

/*
|--------------------------------------------------------------------------
| API ROUTES (FOR AJAX COMPONENTS)
|--------------------------------------------------------------------------
*/
Route::prefix('api/admin')->middleware(['web', 'admin.api.auth'])->group(function () {
    // Attribute Routes
    Route::prefix('attributes')->group(function () {
        Route::get('/', [ApiAttribute::class, 'index']);
        Route::get('/dropdown', [ApiAttribute::class, 'dropdown']);
        Route::get('/types', [ApiAttribute::class, 'types']);
        Route::get('/statistics', [ApiAttribute::class, 'statistics']);
        Route::get('/for-product-variants', [ApiAttribute::class, 'forProductVariants']);
        Route::post('/', [ApiAttribute::class, 'store']);
        Route::get('/{id}', [ApiAttribute::class, 'show']);
        Route::put('/{id}', [ApiAttribute::class, 'update']);
        Route::delete('/{id}', [ApiAttribute::class, 'destroy']);

        // Status operations
        Route::post('/{id}/toggle-status', [ApiAttribute::class, 'toggleStatus']);
        Route::post('/{id}/toggle-variant', [ApiAttribute::class, 'toggleVariant']);
        Route::post('/{id}/toggle-filterable', [ApiAttribute::class, 'toggleFilterable']);

        // Bulk operations
        Route::post('/bulk-update', [ApiAttribute::class, 'bulkUpdate']);
        Route::post('/bulk-delete', [ApiAttribute::class, 'bulkDelete']);

        // Attribute Values Routes
        Route::prefix('/{attribute}/values')->group(function () {
            Route::get('/', [ApiAttributeValue::class, 'index']);
            Route::post('/', [ApiAttributeValue::class, 'store']);
            Route::get('/{id}', [ApiAttributeValue::class, 'show']);
            Route::put('/{id}', [ApiAttributeValue::class, 'update']);
            Route::delete('/{id}', [ApiAttributeValue::class, 'destroy']);
            Route::post('/{id}/toggle-status', [ApiAttributeValue::class, 'toggleStatus']);
            Route::post('/bulk-update', [ApiAttributeValue::class, 'bulkUpdate']);
            Route::post('/bulk-delete', [ApiAttributeValue::class, 'bulkDelete']);
        });
    });

    // Brand Routes
    Route::prefix('brands')->group(function () {
        Route::get('/', [ApiBrand::class, 'index']);
        Route::get('/dropdown', [ApiBrand::class, 'dropdown']);
        Route::get('/statistics', [ApiBrand::class, 'statistics']);
        Route::post('/', [ApiBrand::class, 'store']);
        Route::get('/{id}', [ApiBrand::class, 'show']);
        Route::put('/{id}', [ApiBrand::class, 'update']);
        Route::delete('/{id}', [ApiBrand::class, 'destroy']);

        // Status operations
        Route::post('/{id}/update-status', [ApiBrand::class, 'updateStatus']);
        Route::post('/{id}/update-featured', [ApiBrand::class, 'updateFeatured']);

        // Bulk operations
        Route::post('/bulk-status', [ApiBrand::class, 'bulkStatus']);
        Route::post('/bulk-featured', [ApiBrand::class, 'bulkFeatured']);
        Route::post('/bulk-delete', [ApiBrand::class, 'bulkDelete']);
    });

    // Tax Class Routes
    Route::prefix('tax-classes')->group(function () {
        Route::get('/', [ApiTaxClass::class, 'index']);
        Route::get('/dropdown', [ApiTaxClass::class, 'dropdown']);
        Route::get('/statistics', [ApiTaxClass::class, 'statistics']);
        Route::post('/', [ApiTaxClass::class, 'store']);
        Route::get('/{id}', [ApiTaxClass::class, 'show']);
        Route::put('/{id}', [ApiTaxClass::class, 'update']);
        Route::delete('/{id}', [ApiTaxClass::class, 'destroy']);
        Route::post('/{id}/toggle-default', [ApiTaxClass::class, 'toggleDefault']);
        Route::post('/bulk-delete', [ApiTaxClass::class, 'bulkDelete']);
    });

    // Tax Rate Routes
    Route::prefix('tax-rates')->group(function () {
        Route::get('/', [ApiTaxRate::class, 'index']);
        Route::get('/statistics', [ApiTaxRate::class, 'statistics']);
        Route::get('/types', [ApiTaxRate::class, 'types']);
        Route::get('/scopes', [ApiTaxRate::class, 'scopes']);
        Route::post('/', [ApiTaxRate::class, 'store']);
        Route::get('/{id}', [ApiTaxRate::class, 'show']);
        Route::put('/{id}', [ApiTaxRate::class, 'update']);
        Route::delete('/{id}', [ApiTaxRate::class, 'destroy']);
        Route::post('/{id}/toggle-status', [ApiTaxRate::class, 'toggleStatus']);
        Route::post('/bulk-delete', [ApiTaxRate::class, 'bulkDelete']);
        Route::post('/bulk-status', [ApiTaxRate::class, 'bulkStatus']);
        Route::post('/calculate', [ApiTaxRate::class, 'calculate']);
    });

    // Specification Groups Routes
    Route::prefix('specification-groups')->group(function () {
        Route::get('/', [ApiSpecificationGroup::class, 'index']);
        Route::get('/dropdown', [ApiSpecificationGroup::class, 'dropdown']);
        Route::get('/statistics', [ApiSpecificationGroup::class, 'statistics']);
        Route::get('/for-category-assignment', [ApiSpecificationGroup::class, 'forCategoryAssignment']);
        Route::post('/', [ApiSpecificationGroup::class, 'store']);
        Route::get('/{id}', [ApiSpecificationGroup::class, 'show']);
        Route::put('/{id}', [ApiSpecificationGroup::class, 'update']);
        Route::delete('/{id}', [ApiSpecificationGroup::class, 'destroy']);
        Route::post('/{id}/toggle-status', [ApiSpecificationGroup::class, 'toggleStatus']);
        Route::post('/bulk-update', [ApiSpecificationGroup::class, 'bulkUpdate']);
        Route::post('/bulk-delete', [ApiSpecificationGroup::class, 'bulkDelete']);
    });

    // Specification Routes
    Route::prefix('specifications')->group(function () {
        Route::get('/', [ApiSpecification::class, 'index']);
        Route::get('/dropdown', [ApiSpecification::class, 'dropdown']);
        Route::get('/input-types', [ApiSpecification::class, 'inputTypes']);
        Route::get('/statistics', [ApiSpecification::class, 'statistics']);
        Route::get('/for-product-creation', [ApiSpecification::class, 'forProductCreation']);
        Route::post('/', [ApiSpecification::class, 'store']);
        Route::get('/{id}', [ApiSpecification::class, 'show']);
        Route::put('/{id}', [ApiSpecification::class, 'update']);
        Route::delete('/{id}', [ApiSpecification::class, 'destroy']);

        // Status operations
        Route::post('/{id}/toggle-status', [ApiSpecification::class, 'toggleStatus']);
        Route::post('/{id}/toggle-required', [ApiSpecification::class, 'toggleRequired']);
        Route::post('/{id}/toggle-filterable', [ApiSpecification::class, 'toggleFilterable']);

        // Bulk operations
        Route::post('/bulk-update', [ApiSpecification::class, 'bulkUpdate']);
        Route::post('/bulk-delete', [ApiSpecification::class, 'bulkDelete']);

        // Specification Values Routes
        Route::prefix('/{specification}/values')->group(function () {
            Route::get('/', [ApiSpecificationValue::class, 'index']);
            Route::post('/', [ApiSpecificationValue::class, 'store']);
            Route::get('/{id}', [ApiSpecificationValue::class, 'show']);
            Route::put('/{id}', [ApiSpecificationValue::class, 'update']);
            Route::delete('/{id}', [ApiSpecificationValue::class, 'destroy']);
            Route::post('/{id}/toggle-status', [ApiSpecificationValue::class, 'toggleStatus']);
            Route::post('/bulk-update', [ApiSpecificationValue::class, 'bulkUpdate']);
            Route::post('/bulk-delete', [ApiSpecificationValue::class, 'bulkDelete']);
        });
    });
});
