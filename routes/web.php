<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\LostStolenController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/export_assets', [AssetController::class,'export_assets']);

Route::get('/export_custom_code_namaa/{firstDate}/{secondDate}', [AssetController::class,'export_custom_code_namaa']);

Route::get('/export_transports', [TransportController::class,'export_transports']);

Route::get('/export_lostStolens', [LostStolenController::class,'export_lostStolens']);

Route::get('/export_maintenances', [MaintenanceController::class,'export_maintenances']);

Route::get('/export_items', [ItemController::class,'export_items']);

Route::get('/export_types', [TypeController::class,'export_types']);

Route::get('/export_documents', [DocumentController::class,'export_documents']);

Route::get('/export_custom_transport/{transportCode}/{transportType}/{firstDate}/{secondDate}', [TransportController::class,'export_custom_transport']);

Route::get('/export_word_report_transport/{transportCode}/{transportType}/{firstDate}/{secondDate}', [TransportController::class,'export_word_report_transport']);

Route::get('/export_word_report_maintenance/{maintenanceId}', [MaintenanceController::class,'export_word_report_maintenance']);

Route::get('/export_custom_maintenance/{maintenanceCode}/{firstDate}/{secondDate}', [MaintenanceController::class,'export_custom_maintenance']);

Route::get('/{pathMatch}', function () {
    return view('welcome');
})->where('pathMatch', ".*");





