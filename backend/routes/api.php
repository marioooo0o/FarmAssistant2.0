<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadastralParcelController;
use App\Http\Controllers\ExcelCSVController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\FieldController;

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

Route::get('/', [ExcelCSVController::class, 'importExcelCSV']);
Route::middleware(['api'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'userProfile');
    });
    Route::controller(FarmController::class)->group(function () {
        Route::post('/farms', 'store');
        Route::get('/farms/{id}', 'show');
        Route::post('/farms/{id}', 'update');
        Route::delete('/farms/{id}', 'destroy');
    });
    Route::controller(FieldController::class)->group(function () {
        Route::post('/farms/{farm_id}/fields', 'store');
        Route::get('/farms/{farm_id}/fields/{id}', 'show');
        Route::post('/farms/{farm_id}/fields/{id}', 'update');
        Route::delete('/farms/{farm_id}/fields/{id}', 'destroy');
    });
    Route::controller(CadastralParcelController::class)->group(function () {
        Route::post('/farms/{farm_id}/fields/{field_id}/cadastral-parcels', 'store');
    });
});
