<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function ()
{
    return redirect()->route('home');
});

Route::group(['middleware' => ['auth']], function ()
{
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('user/{user}', [UserController::class, 'view_profile'])->name('view_profile');
});


Auth::routes();
