<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//referencias a los controllers de las APis
//use App\Http\Controllers\Api\v1\CustomerController;
//use App\Http\Controllers\Api\v1\InvoiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\v1'], function() {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('invoices', InvoiceController::class);
    //Routa para insertar varios registros de one. Se conoce como Bulk
    Route::post('invoices/bulk', ['uses' => 'InvoiceController@bulkStore']);

});
