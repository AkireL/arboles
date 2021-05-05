<?php

use App\Http\Controllers\API\ChildrenController;
use App\Http\Controllers\API\ParentsChildController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(["bindings"])->group(function () {

    Route::get('/v1/nodes/{node}/children', [ChildrenController::class, 'index']);
    Route::get('/v1/nodes/{node}/parents', [ParentsChildController::class, 'index']);
});
