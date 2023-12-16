<?php

use App\Http\Controllers\API\PrinterDataNikahController;
use App\Http\Controllers\API\SelectDataController;
use App\Http\Controllers\GetLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('brand', [SelectDataController::class, 'brand'])->name('select-brand');
Route::get('category', [SelectDataController::class, 'category'])->name('select-category');
Route::get('user', SelectDataController::class)->name('select-user');
Route::prefix('/locations')->group(function () {
    Route::get('get-district', GetLocationController::class)->name('get-district');
    Route::get('get-village', [GetLocationController::class,'village'])->name('get-village');
});

Route::get('jabatan', [SelectDataController::class, 'jabatan'])->name('select-jabatan');
Route::get('pekerjaan', [SelectDataController::class, 'pekerjaan'])->name('select-pekerjaan');
Route::get('datakua', [SelectDataController::class, 'datakua'])->name('select-datakua');
Route::get('datadesa', [SelectDataController::class, 'datadesa'])->name('select-datadesa');
Route::get('dataaparatur', [SelectDataController::class, 'aparaturDesa'])->name('select-aparatur');
Route::get('n6', [SelectDataController::class, 'n6'])->name('select-n6');


