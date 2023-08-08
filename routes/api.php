<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LostStolenController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Items API
Route::get('item', [ItemController::class,'index']);
Route::get('item/{id}', [ItemController::class,'show']);
Route::post('item', [ItemController::class,'store']);
Route::get('itemSearch', [ItemController::class,'getItem']);
Route::put('item/{id}', [ItemController::class,'update']);
Route::delete('item/{id}', [ItemController::class,'destroy']);
Route::post('item/import_items', [ItemController::class,'import_items']);

// Types API
Route::get('type', [TypeController::class,'index']);
Route::get('type/{id}', [TypeController::class,'show']);
Route::post('type', [TypeController::class,'store']);
Route::put('type/{id}', [TypeController::class,'update']);
Route::delete('type/{id}', [TypeController::class,'destroy']);
Route::get('typeSearch', [TypeController::class,'getType']);
Route::post('type/import_types', [TypeController::class,'import_types']);

// Assets API
Route::get('asset', [AssetController::class,'index']);
Route::get('asset/{id}', [AssetController::class,'show']);
Route::post('asset', [AssetController::class,'store']);
Route::put('asset/{id}', [AssetController::class,'update']);
Route::delete('asset/{id}', [AssetController::class,'destroy']);
Route::post('asset/import_assets', [AssetController::class,'import_assets']);
Route::get('codeSearch', [AssetController::class,'getCodeAsset']);
Route::get('serialSearch', [AssetController::class,'getCodeSerial']);
// Route::get('asset/export_employees', [AssetController::class,'export_employees']);

// Transports API
Route::get('transport', [TransportController::class,'index']);
Route::get('transport/{id}', [TransportController::class,'show']);
Route::get('showTransports/{id}/{transportType}/{firstDate}/{secondDate}', [TransportController::class,'show_transports']);
Route::get('showTempTransports/{transportType}/{firstDate}/{secondDate}', [TransportController::class,'show_temp_transports']);
Route::post('transport', [TransportController::class,'store']);
Route::put('transport/{id}', [TransportController::class,'update']);
Route::delete('transport/{id}', [TransportController::class,'destroy']);
Route::post('transport/import_transports', [TransportController::class,'import_transports']);
Route::get('transportTypeSearch', [TransportController::class,'getTransportType']);

// Lost & Stolen API
Route::get('lostStolen', [LostStolenController::class,'index']);
Route::get('lostStolen/{id}', [LostStolenController::class,'show']);
Route::post('lostStolen', [LostStolenController::class,'store']);
Route::put('lostStolen/{id}', [LostStolenController::class,'update']);
Route::delete('lostStolen/{id}', [LostStolenController::class,'destroy']);
Route::post('lostStolen/import_lostStolens', [LostStolenController::class,'import_lostStolens']);

// Maintenance API
Route::get('maintenance', [MaintenanceController::class,'index']);
Route::get('maintenance/{id}', [MaintenanceController::class,'show']);
Route::get('showMaintenances/{id}/{firstDate}/{secondDate}', [MaintenanceController::class,'show_maintenances']);
Route::post('maintenance', [MaintenanceController::class,'store']);
Route::put('maintenance/{id}', [MaintenanceController::class,'update']);
Route::delete('maintenance/{id}', [MaintenanceController::class,'destroy']);
Route::post('maintenance/import_maintenances', [MaintenanceController::class,'import_maintenances']);

// Documents API
Route::get('document', [DocumentController::class,'index']);
Route::get('document/{id}', [DocumentController::class,'show']);
Route::post('document', [DocumentController::class,'store']);
Route::put('document/{id}', [DocumentController::class,'update']);
Route::delete('document/{id}', [DocumentController::class,'destroy']);
Route::post('document/import_documents', [DocumentController::class,'import_documents']);

// Centers API
Route::get('center', [CenterController::class,'index']);

// Departments API
Route::get('department', [DepartmentController::class,'index']);

// Positions API
Route::get('position', [PositionController::class,'index']);

// Employees API
Route::get('employee', [EmployeeController::class,'index']);

// Login API
Route::post('login', [UserController::class,'store']);