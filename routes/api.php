<?php

use App\Http\Controllers\MigrationController;
use Illuminate\Support\Facades\Route;

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
Route::name('api_')->group(function () {
    Route::post('migrate', MigrationController::class)->name('migrate');
});

Route::middleware('auth:api')->group(function () {
    //
});
