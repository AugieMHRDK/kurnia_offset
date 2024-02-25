<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PublicApiController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('/test', function (Request $request) {
//     return response('Test API', 200)
//                   ->header('Content-Type', 'application/json');
// });


// Route::post('/update-ack', [ApiController::class, 'updateAck'])->name('update-ack')->middleware('throttle:10,1');; WITH REQUEST LIMITER
Route::post('/transaksi/status', [ApiController::class, 'status'])->name('status');