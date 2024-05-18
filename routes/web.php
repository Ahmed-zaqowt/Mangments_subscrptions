<?php

use App\Http\Controllers\Error\ErrorController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->group(function(){
    Route::get('/', [ IndexController::class ,'index_super'])->name('index_super');


    Route::get('errors' , [ErrorController::class , 'errors'])->name('errors');
    Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {

        Route::prefix('admins')->name('admin.')->controller(\App\Http\Controllers\Admin\Admin\AdminController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');
            Route::get('/show_sub/{id}', 'show_sub')->name('show_sub');
            Route::get('/getdatasub', 'getdatasub')->name('getdatasub');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::post('/delete', 'delete')->name('delete');
        });

        Route::prefix('users')->name('user.')->controller(\App\Http\Controllers\Admin\User\UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');
        });

        Route::prefix('packages')->name('package.')->controller(\App\Http\Controllers\Admin\Package\PackageController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::post('/delete', 'delete')->name('delete');
        });


        Route::prefix('subscriptions')->name('subscription.')->controller(\App\Http\Controllers\Admin\Subscription\SubscriptionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');

            Route::get('/accepted', 'accepted')->name('accepted');
            Route::get('/getdataaccepted', 'getdataaccepted')->name('getdataaccepted');

            Route::get('/expired', 'expired')->name('expired');
            Route::get('/getdataexpired', 'getdataexpired')->name('getdataexpired');
        });

        Route::prefix('orders')->name('order.')->controller(\App\Http\Controllers\Admin\Order\OrderController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');
            Route::post('/update', 'update')->name('update');
            Route::post('/update_numbers', 'update_numbers')->name('update_numbers');
            Route::get('/renewal', 'renewal')->name('renewal');
            Route::get('/getdatarenewal', 'getdatarenewal')->name('getdatarenewal');
            Route::get('/canceled', 'canceled')->name('canceled');
            Route::get('/getdatacanceled', 'getdatacanceled')->name('getdatacanceled');
        });

        Route::prefix('financial')->name('financial.')->controller(\App\Http\Controllers\Admin\Financial\FinancialEntitlementsController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');
            Route::post('/zeroing', 'zeroing')->name('zeroing');
        });



    });

    Route::prefix('distributor')->middleware('dist')->name('dist.')->group(function () {
        Route::get('/', [ IndexController::class ,'index_admin'])->name('index_admin');
        Route::prefix('users')->name('user.')->controller(\App\Http\Controllers\Admin\distributor\DistributorController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');
            Route::get('/getdatasub', 'getdatasub')->name('getdatasub');
            Route::get('/subsciptions/{id}', 'subsciptions')->name('subsciptions');
            Route::post('/add_sub', 'add_sub')->name('add_sub');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::post('/delete', 'delete')->name('delete');
        });

        Route::prefix('subscriptions')->name('subscription.')->controller(\App\Http\Controllers\Distributor\Subscription\SubscriptionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');

            Route::get('/accepted', 'accepted')->name('accepted');
            Route::get('/getdataaccepted', 'getdataaccepted')->name('getdataaccepted');

            Route::get('/expired', 'expired')->name('expired');
            Route::get('/getdataexpired', 'getdataexpired')->name('getdataexpired');

            Route::post('renewal' , 'renewal')->name('renewal');
        });

        Route::prefix('orders')->name('order.')->controller(\App\Http\Controllers\Distributor\order\OrderController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');
            Route::post('/delete', 'delete')->name('delete');
            Route::post('/update', 'update')->name('update');
            Route::get('/renewal', 'renewal')->name('renewal');
            Route::post('/unrenewal', 'unrenewal')->name('unrenewal');
            Route::get('/getdatarenewal', 'getdatarenewal')->name('getdatarenewal');
            Route::get('/canceled', 'canceled')->name('canceled');
            Route::get('/getdatacanceled', 'getdata_canceled')->name('getdata.canceled');
        });

        Route::prefix('financial')->name('financial.')->controller(\App\Http\Controllers\Distributor\Financial\FinancialController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getdata', 'getdata')->name('getdata');
        });
    });

    Route::prefix('admin/profile')->name('profile.')->controller(\App\Http\Controllers\Admin\Profile\ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/update', 'update')->name('update');
        Route::get('/password', 'password')->name('password');
        Route::post('/update_password', 'update_password')->name('update_password');
    });
});




require __DIR__ . '/auth.php';
