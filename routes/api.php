<?php

use App\Http\Controllers\PostController;
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

//  Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'auth:api'], function ()
{
    Route::group(['prefix' => 'post'], function ()
    {
        Route::get('/list', [PostController::class, 'list']);
        Route::post('/create', [PostController::class, 'store']);
    });
    Route::group(['prefix' => 'user'], function ()
    {
        Route::get('/{user}/follow', [PostController::class, 'follow']);
    });
});
