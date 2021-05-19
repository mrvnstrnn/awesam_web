<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GlobeController;

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
    Route::get('/getVendorList/{program_status}', [VendorController::class, 'vendor_list'])->name('vendor.list');
    Route::post('/terminateVendor', [VendorController::class, 'terminate_vendor'])->name('terminate.vendor');

    
    Route::get('/all-profile', [ProfileController::class, 'all_profile'])->name('all.profile');
    Route::get('/edit-profile/{id}', [ProfileController::class, 'edit_profile'])->name('edit.profile');
    Route::post('/update-profile', [ProfileController::class, 'update_profile'])->name('update.profile');

    Route::get('/all-permission', [ProfileController::class, 'all_permission'])->name('all.permission');
    Route::get('/edit-permission/{permission}', [ProfileController::class, 'edit_permission'])->name('edit.permission');
    Route::post('/addupdate-permission', [ProfileController::class, 'addupdate_permission'])->name('addupdate.permission');
    Route::post('/delete-permission', [ProfileController::class, 'deletePermission'])->name('delete.permission');

    
    Route::post('/accept-reject-endorsement', [GlobeController::class, 'acceptRejectEndorsement'])->name('accept-reject.endorsement');
    
    Route::get('/forverification', [UserController::class, 'forverification_list'])->name('all.forverification');

    
    Route::get('/workflow-data-proc/{program_id}', [GlobeController::class, 'getDataWorkflow'])->name('all.getDataWorkflow');

    Route::get('/unassigend-sites-data/{profile_id}/{program_id}/{activity_id}/{what_to_load}', [GlobeController::class, 'unassignedSites'])->name('all.unassignedSites');

    Route::post('/assign-agent', [GlobeController::class, 'assign_agent'])->name('assign.agent');

    Route::get('/forverification', [UserController::class, 'forverification_list'])->name('all.forverification');


});


Route::get('/invitation-link/{token}/{invitation_code}', [InviteController::class, 'invitation_registration'])->name('invite.link')->middleware(['invitation']);

Route::view('/team', 'team');

//ROUTE TO SLUG 
//USERCONTROLLER WILL TAKE OVER THE ROUTING 

Route::get('/{slug}', [UserController::class, 'show'])
    ->where('slug', '.*')
    ->middleware(['auth', 'verified', 'navigation']);


// Route::view('/profile-switcher/{mode}/{profile}', 'welcome');

