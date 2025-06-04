<?php

use Illuminate\Support\Facades\Route;
use Modules\Ecommerce\Enums\Permission;
use Modules\Ecommerce\Http\Controllers\RefundReasonController;
use Modules\Refund\Http\Controllers\RefundController;
use Modules\Refund\Http\Controllers\RefundPolicyController;

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

// Route::group([], function () {
//     Route::resource('refund', RefundController::class)->names('refund');
// });


Route::apiResource('refund-reasons', RefundReasonController::class, [
    'only' => ['index', 'show'],
]);

Route::resource('refund-policies', RefundPolicyController::class, [
    'only' => ['index', 'show'],
]);


/**
 * *****************************************
 * Authorized Route for Super Admin only
 * *****************************************
 */

Route::group(['middleware' => ['permission:' . Permission::SUPER_ADMIN, 'auth:sanctum']], function () {
    
    Route::apiResource('refund-reasons', RefundReasonController::class, [
        'only' => ['store', 'update', 'destroy'],
    ]);

    Route::resource('refund-policies', RefundPolicyController::class, [
        'only' => ['store', 'update', 'destroy'],
    ]);
    Route::apiResource(
        'refunds',
        RefundController::class,
        [
            'only' => ['destroy', 'update'],
        ]
    );
});

/**
 * ******************************************
 * Authorized Route for Customers only
 * ******************************************
 */

Route::group(['middleware' => ['can:' . Permission::CUSTOMER, 'auth:sanctum', 'email.verified']], function () {
    Route::apiResource(
        'refunds',
        RefundController::class,
        [
            'only' => ['index', 'store', 'show'],
        ]
    );
});