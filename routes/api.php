<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user',[UserController::class,'user_list']);
Route::get('/service',[ServiceController::class,'service_list']);
Route::get('/invoice-list',[InvoiceController::class,'invoiceList']);
Route::post('/store-invoice', [InvoiceController::class, 'storeInvoice']);
Route::post('/store-invoice-items-0987', [InvoiceController::class, 'storeInvoiceItem']);

Route::get('/single-invoice/{id}', [InvoiceController::class, 'getSingleInvoice']);
Route::post('add-transaction',[TransactionController::class, 'addTransaction']);
Route::get('show-transaction/{id}',[TransactionController::class, 'getTransaction']);
Route::post('delete-transaction',[TransactionController::class, 'deleteTransaction']);


Route::post('invoice/deposit/{id}',[InvoiceController::class,'createDepositRequest']);
Route::get('invoice/deposit/show/{id}',[InvoiceController::class,'showDepositRequest']);
Route::post('invoice/deposit/update/{id}',[InvoiceController::class,'updateDepositRequest']);
