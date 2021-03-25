<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;

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

Route::group(['prefix' => 'api'], function ()
{
    Route::group(['prefix' => 'post'], function ()
    {
        Route::get('list', [PostController::class, 'list']);
        Route::post('create', [PostController::class, 'store']);
        Route::post('{post}/like', [PostController::class, 'like']);
        Route::post('{post}/delete', [PostController::class, 'delete_post']);
        Route::post('{post}/comments', [PostCommentController::class, 'create']);
    });
    Route::group(['prefix' => 'user'], function ()
    {
        Route::get('logged_in_user', [UserController::class, 'logged_in_user']);
        Route::post('{user}/follow', [UserController::class, 'follow']);
        Route::post('{user}/unfollow', [UserController::class, 'unfollow']);
    });

    Route::get('feed', [PostController::class, 'feed']);
});



Route::get('/', function ()
{
    return redirect()->route('home');
});

Route::group(['middleware' => ['auth:web']], function ()
{
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('user/{user}', [UserController::class, 'view_profile'])->name('view_profile');
});

Auth::routes();
