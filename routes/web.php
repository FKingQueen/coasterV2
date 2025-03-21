<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Test\StorageController ;  

use Illuminate\Http\Request;

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

Route::post('/postApi', [StorageController ::class, 'postApi']);
Route::get('/getApi/{msg}', [StorageController ::class, 'getApi']);

Route::get('/csrf-token', function() {
    return response()->json(['csrf_token' => csrf_token()]);
});
Route::group(['prefix' => 'admin','middleware' => 'auth:sanctum'], function() {
    Route::post('/storeBuoy', function(Request $request) {
        return $request;
    });
});

Route::post('/storeDataWLMS', function(Request $request) {
    return $request;
});


Route::get('/{any}', function () {
    return view('main');
})->where('any', '^(?!geoserver).*');
