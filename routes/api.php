<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;

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

Route::get('/user',[UserController::class,'user_list']);
Route::get('/service',[ServiceController::class,'service_list']);
Route::get('/invoice-list',[InvoiceController::class,'invoiceList']);
Route::post('/store-invoice', [InvoiceController::class, 'storeInvoice']);
Route::post('/store-invoice-items-0987', [InvoiceController::class, 'storeInvoiceItem']);
