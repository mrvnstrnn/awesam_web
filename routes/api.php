<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobeController;

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

Route::get('/stored-proc/{profile_id}/{program_id}', [GlobeController::class, 'getDataNewEndorsement'])->name('all.getDataNewEndorsement');

Route::get('/new-endorsements/{profile_id}/{program_id}', [GlobeController::class, 'getNewEndorsement'])->name('all.getNewEndorsement');
Route::post('/accept-endorsements', [GlobeController::class, 'acceptEndorsement'])->name('accept.endorsement');


