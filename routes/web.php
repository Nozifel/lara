<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OpenAPIController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function(){

    Route::controller(AuthController::class)->group(function(){
        
        Route::post('/login', 'login');

        Route::post('/logout', 'logout');

    });

});
