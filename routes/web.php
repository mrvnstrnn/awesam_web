<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\VendorController;

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
    Route::post('/address', [UserController::class, 'getAddress'])->name('get.address');
    Route::post('/send-invitation', [InviteController::class, 'send_invitation'])->name('invite.send');
    Route::post('/change-password', [UserController::class, 'change_password'])->name('update.password');
    Route::post('/finish-onboarding', [UserController::class, 'finish_onboarding'])->name('finish.onboarding');
    Route::get('/profile-switcher/{profile_id}', [UserController::class, 'profile_switcher'])->name('profile.switcher');

    Route::post('/add-vendor', [VendorController::class, 'add_vendor'])->name('add.vendor');
    Route::get('/all-vendor-list', [VendorController::class, 'all_vendor'])->name('all.vendors');
    Route::get('/vendor-data/{vendor_id}', [VendorController::class, 'get_vendor'])->name('get.vendors');
});


Route::get('/invitation-link/{token}/{invitation_code}', [InviteController::class, 'invitation_registration'])->name('invite.link')->middleware(['invitation']);

Route::view('/team', 'team');

//ROUTE TO SLUG 
//USERCONTROLLER WILL TAKE OVER THE ROUTING 

Route::get('/{slug}', [UserController::class, 'show'])
    ->where('slug', '.*')
    ->middleware(['auth', 'verified', 'navigation']);


// Route::view('/profile-switcher/{mode}/{profile}', 'welcome');

