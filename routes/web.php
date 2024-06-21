<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Test\StorageController ;  

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


Route::get('/{any}', function () {
    return view('main');
})->where('any', '.*');

