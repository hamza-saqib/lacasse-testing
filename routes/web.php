<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */
Route::namespace('Admin')->group(function () {
    Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('admin/login', 'LoginController@login')->name('admin.login');
    Route::get('admin/logout', 'LoginController@logout')->name('admin.logout');
});
Route::group(['prefix' => 'admin', 'middleware' => ['employee'], 'as' => 'admin.' ], function () {
    Route::namespace('Admin')->group(function () {
        Route::group(['middleware' => ['role:admin|superadmin|clerk, guard:employee']], function () {
            Route::get('/', 'DashboardController@index')->name('dashboard');
            Route::namespace('Products')->group(function () {
                Route::resource('products', 'ProductController');
                Route::get('remove-image-product', 'ProductController@removeImage')->name('product.remove.image');
                Route::get('remove-image-thumb', 'ProductController@removeThumbnail')->name('product.remove.thumb');
            });
            Route::namespace('Shops')->group(function () {
                Route::resource('shops', 'ShopController');
                Route::get('shops/{id}/products', 'ShopController@showProducts')->name('shops.products');
                Route::get('shops/{id}/orders', 'ShopController@showOrders')->name('shops.orders');
            });
            Route::namespace('Customers')->group(function () {
                Route::resource('customers', 'CustomerController');
                Route::resource('customers.addresses', 'CustomerAddressController');
            });
            Route::namespace('Categories')->group(function () {
                Route::resource('categories', 'CategoryController');
                Route::get('remove-image-category', 'CategoryController@removeImage')->name('category.remove.image');
            });
            Route::namespace('Orders')->group(function () {
                Route::resource('orders', 'OrderController');
                Route::resource('order-statuses', 'OrderStatusController');
                Route::get('orders/{id}/invoice', 'OrderController@generateInvoice')->name('orders.invoice.generate');
            });

             Route::resource('addresses', 'Addresses\AddressController');
             Route::post('addresses/province', 'Addresses\AddressController@provinces');
         

             Route::post('addresses/city', 'Addresses\AddressController@citysList');

            Route::resource('countries', 'Countries\CountryController');
            Route::resource('countries.provinces', 'Provinces\ProvinceController');
            Route::resource('countries.provinces.cities', 'Cities\CityController');
            Route::resource('couriers', 'Couriers\CourierController');
            Route::resource('attributes', 'Attributes\AttributeController');
            //Route::get('attributes.partgroups', 'Attributes\AttributeController@partgroups');
            Route::get('partgroups', 'Categories\CategoryController@partgroups')->name('categories.partgroups');
            Route::get('carmodel', 'Categories\CategoryController@carmodel')->name('categories.carmodel');
            Route::get('carsubmodel', 'Categories\CategoryController@carsubmodel')->name('categories.carsubmodel');
            Route::get('carparts', 'Categories\CategoryController@carparts')->name('categories.carparts');
            Route::get('subpart', 'Categories\CategoryController@subpart')->name('categories.subpart');
            Route::get('piece', 'Categories\CategoryController@piece')->name('categories.piece');
            Route::get('assignCarParts', 'Categories\CategoryController@assignCarParts')->name('categories.assignCarParts');
            Route::put('saveParts', 'Categories\CategoryController@saveParts')->name('categories.saveCarParts');
            Route::put('unassign', 'Categories\CategoryController@unassignParts')->name('categories.unassignParts');
            Route::resource('attributes.values', 'Attributes\AttributeValueController');
            Route::resource('brands', 'Brands\BrandController');

        });
        Route::group(['middleware' => ['role:admin|superadmin, guard:employee']], function () {
            Route::resource('employees', 'EmployeeController');
            Route::get('employees/{id}/profile', 'EmployeeController@getProfile')->name('employee.profile');
            Route::put('employees/{id}/profile', 'EmployeeController@updateProfile')->name('employee.profile.update');
            Route::resource('roles', 'Roles\RoleController');
            Route::resource('permissions', 'Permissions\PermissionController');
        });
    });
});

// Route::get('/clear-cache', function() {
//             $exitCode = Artisan::call('cache:clear');
//             //die("dfd");
//             return 'cache cleared';
// });
/**
 * Frontend routes
 */
Auth::routes();
Route::namespace('Auth')->group(function () {
    Route::get('cart/login', 'CartLoginController@showLoginForm')->name('cart.login');
    Route::post('cart/login', 'CartLoginController@login')->name('cart.login');
    Route::get('logout', 'LoginController@logout');
});

Route::namespace('Front')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Route::get('/link-storage', function() {
    //     $exitCode = Artisan::call('storage:link');
    // return 'link created';
    // });
    Route::get('language/{slug?}', 'HomeController@language')->name('changeLanguage');
    Route::get('paymentwallresponse', 'CheckoutController@paymentwallresponse')->name('checkout.paymentwallresponse');
    Route::get('thank-you', 'CheckoutController@thank_you')->name('checkout.thankYou');
    Route::get('payment-failed', 'CheckoutController@payment_failed')->name('checkout.paymentFailed');
    Route::group(['middleware' => ['auth', 'web']], function () {

        Route::namespace('Payments')->group(function () {
            Route::get('bank-transfer', 'BankTransferController@index')->name('bank-transfer.index');
            Route::post('bank-transfer', 'BankTransferController@store')->name('bank-transfer.store');
        });

        Route::namespace('Addresses')->group(function () {
            Route::resource('country.state', 'CountryStateController');
            Route::resource('state.city', 'StateCityController');
        });

        Route::get('accounts', 'AccountsController@index')->name('accounts');
        Route::post('accounts-update','AccountsController@update')->name('update.accounts');
        Route::post('password-update','AccountsController@passwordupdate')->name('update.password');
        //Paymentwall
        Route::get('paymentwallpay', 'CheckoutController@paymentwall')->name('checkout.paymentwall');
        Route::get('cashondelivery', 'CheckoutController@cashondelivery')->name('checkout.cashondelivery');
        //Route::post('paymentwallresponse', 'CheckoutController@paymentwallresponse')->name('checkout.paymentwallresponse');




        Route::get('checkout', 'CheckoutController@index')->name('checkout.index');
        Route::post('checkout', 'CheckoutController@store')->name('checkout.store');
        Route::get('checkout/execute', 'CheckoutController@executePayPalPayment')->name('checkout.execute');
        Route::post('checkout/execute', 'CheckoutController@charge')->name('checkout.execute');
        Route::get('checkout/cancel', 'CheckoutController@cancel')->name('checkout.cancel');
        Route::get('checkout/success', 'CheckoutController@success')->name('checkout.success');
        Route::resource('customer.address', 'CustomerAddressController');
        Route::post("addwishlist", 'ProductController@addwishlist')->name('front.add.addwishlist');
        Route::post("removewishlist", 'ProductController@removewishlist')->name('front.remove.wishlist');
        Route::get("wishlist", 'ProductController@wishlist')->name('front.show.wishlist');
    });
    Route::resource('cart', 'CartController');
    Route::get("category/{slug}", 'CategoryController@getCategory')->name('front.category.slug');
    Route::get("getsubcategory/{slug?}", 'CategoryController@getsubcategory')->name('front.subcategory.slug');
    Route::get("partgroups/{slug?}", 'CategoryController@getpartgroups')->name('front.getpartgroups.slug');
    Route::get("search", 'ProductController@search')->name('search.product');
    Route::get("{product}", 'ProductController@show')->name('front.get.product');

    Route::get("products-page/{ispart}/{make}/{model}", 'CategoryController@showallpartgroups')->name('front.show.all.partgroups');
     /*Route::get("products-page/{ispart}/{make}/{model}", 'ProductController@showallproducts')->name('front.show.all.products');
    */
    Route::get("products/{ispart}/{cateid}/{make}/{model}", 'CategoryController@showallproducts')->name('front.show.all.products');
    Route::get("product-page/{slug}", 'ProductController@showproducts')->name('front.show.product');
});