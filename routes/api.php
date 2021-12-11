<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobeController;
use App\Http\Controllers\ApiController;

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

Route::any('/send-invitation-vendor', [ApiController::class, 'send_invitation_vendor'])->name('send_invitation_vendor');
Route::any('/send-invitation-vendor-admin', [ApiController::class, 'send_invitation_vendor_admin'])->name('send_invitation_vendor_admin');
Route::any('/for-vendor-invitation', [ApiController::class, 'for_vendor_invitation'])->name('for_vendor_invitation');
Route::any('/for-invitation', [ApiController::class, 'for_invitation'])->name('for_invitation');

Route::get('/stored-proc/{profile_id}/{program_id}/{activity_id}/{what_to_load}', [GlobeController::class, 'getNewEndorsement'])->name('all.getNewEndorsement');
Route::get('/workflow-proc/{program_id}', [GlobeController::class, 'getWorkflow'])->name('all.getWorkflow');

