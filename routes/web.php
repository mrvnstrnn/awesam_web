<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


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

//ROUTE TO USER'S HOME

Route::get('/', [UserController::class, 'index'])->middleware(['auth', 'verified']);

Route::view('/team', 'team');
Route::view('/onboarding', 'onboarding');
//ROUTE TO SLUG 
//USERCONTROLLER WILL TAKE OVER THE ROUTING 
Route::get('/{slug}', [UserController::class, 'show'])
    ->where('slug', '.*')
    ->middleware(['auth', 'verified', 'navigation']);


Route::view('/profile-switcher/{mode}/{profile}', 'welcome');

