<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserAccountController;
use App\Http\Controllers\Admin\MonitoringSystem;
use App\Http\Controllers\Home\HomeArticleController;  
use App\Http\Controllers\Home\ProjectController;  
use App\Http\Controllers\Home\HomeMonitoringSystemController;  
use App\Http\Controllers\Home\MapController;  
use App\Http\Controllers\Test\StorageController;  

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
Route::post('/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'admin','middleware' => 'auth:sanctum'], function() {
        // Article
        Route::get('/getArticle', [ArticleController::class, 'getArticle']);
        Route::post('/storeArticle', [ArticleController::class, 'storeArticle']);
        Route::post('/upload', [ArticleController::class, 'upload']);
        Route::post('/deleteImage', [ArticleController::class, 'deleteImage']);
        Route::post('/deleteArticle', [ArticleController::class, 'deleteArticle']);
        Route::get('/getArticleEdit/{id}', [ArticleController::class, 'getArticleEdit']);
        Route::post('/updateArticle', [ArticleController::class, 'updateArticle']);

        // Inventory
        Route::get('/getInventory', [InventoryController::class, 'getInventory']);
        Route::post('/storeInventory', [InventoryController::class, 'storeInventory']);
        Route::post('/uploadInventory', [InventoryController::class, 'uploadInventory']);
        Route::post('/deleteImageInventory', [InventoryController::class, 'deleteImageInventory']);
        Route::post('/deleteInventory', [InventoryController::class, 'deleteInventory']);
        Route::get('/getInventoryEdit/{id}', [InventoryController::class, 'getInventoryEdit']);
        Route::post('/updateInventory', [InventoryController::class, 'updateInventory']);
        Route::post('/importInventory', [InventoryController::class, 'importInventory']);

        // Admin User
        Route::get('/getRole', [UserController::class, 'getRole']);
        Route::get('/getUser', [UserController::class, 'getUser']);
        Route::post('/storeUser', [UserController::class, 'storeUser']);
        Route::post('/deleteUser/{id}', [UserController::class, 'deleteUser']);
        Route::get('/getUserEdit/{id}', [UserController::class, 'getUserEdit']);
        Route::post('/updateUser', [UserController::class, 'updateUser']);
        Route::post('/updatePassword', [UserController::class, 'updatePassword']);

        // User Account Settings
        Route::get('/getUserAccount', [UserAccountController::class, 'getUserAccount']);
        Route::post('/updateUserAccount', [UserAccountController::class, 'updateUserAccount']);
        Route::post('/updateUserAccountPassword', [UserAccountController::class, 'updateUserAccountPassword']);

        // Monitoring System
        Route::get('/getBMSData', [MonitoringSystem::class, 'getBMSData']);
        Route::post('/deleteBMSData', [MonitoringSystem::class, 'deleteBMSData']);
        Route::get('/getBouy/{id}', [MonitoringSystem::class, 'getBouy']);
        Route::get('/getWLMSData', [MonitoringSystem::class, 'getWLMSData']);
        Route::post('/deleteWLMSData', [MonitoringSystem::class, 'deleteWLMSData']);
        Route::get('/getWaterLevel/{id}', [MonitoringSystem::class, 'getWaterLevel']);
});

Route::post('/storeBuoy', function(Request $request) {
        return $request;
});
Route::post('/storeDataWLMS', function(Request $request) {
        return $request;
});

// Home Article
Route::get('/getArticles', [HomeArticleController::class, 'getArticles']);
Route::get('/getArticle/{id}', [HomeArticleController::class, 'getArticle']);
Route::get('/getmoreArticle/{id}', [HomeArticleController::class, 'getmoreArticle']);
Route::post('/searchArticle', [HomeArticleController::class, 'searchArticle']);
// Projects 
Route::get('/getProject/{id}', [ProjectController::class, 'getProject']);
Route::get('/getRelatedArticle/{id}', [ProjectController::class, 'getRelatedArticle']);
// Monitoring System
Route::get('/getWaterLevel/{id}', [HomeMonitoringSystemController::class, 'getWaterLevel']);
Route::get('/getBouy/{id}', [HomeMonitoringSystemController::class, 'getBouy']);
// Map
Route::post('/getLayerData', [MapController::class, 'getLayerData']);
Route::post('/getProvinceData', [MapController::class, 'getProvinceData']);
Route::post('/getMunicipalitiesData', [MapController::class, 'getMunicipalitiesData']);
Route::post('/getBarangaysData', [MapController::class, 'getBarangaysData']);

// Test API
Route::get('/getMsg', [StorageController::class, 'getMsg']);
