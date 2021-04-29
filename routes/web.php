<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InviteController;

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
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/onboarding', [UserController::class, 'onboarding']);
    // Route::get('/invite', [UserController::class, 'invitation'])->name('invite.employee');
    Route::post('/send-invitation', [InviteController::class, 'send_invitation'])->name('invite.send');
    Route::post('/change-password', [UserController::class, 'change_password'])->name('update.password');
});


Route::get('/invitation-link/{token}/{invitation_code}', [InviteController::class, 'invitation_registration'])->name('invite.link')->middleware(['invitation']);

Route::view('/team', 'team');

//ROUTE TO SLUG 
//USERCONTROLLER WILL TAKE OVER THE ROUTING 

Route::get('/{slug}', [UserController::class, 'show'])
    ->where('slug', '.*')
    ->middleware(['auth', 'verified', 'navigation']);


Route::view('/profile-switcher/{mode}/{profile}', 'welcome');

