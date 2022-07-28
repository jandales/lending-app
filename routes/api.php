<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoanTypeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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
Route::post('/login', [LoginController::class, 'attempt']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'index']);
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index']);
Route::put('/reset-password', [ResetPasswordController::class, 'reset']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', [UserController::class, 'user']);
    Route::put('/user/update',[UserController::class, 'update']);
    Route::post('/user/upload-avatar',[UserController::class, 'upload']);

    Route::get('/app/dashboard', [AppController::class, 'dashboard']);
    
    Route::get('/loan-types',[LoanTypeController::class, 'index']);
    Route::get('/loan-types/{loantype:id}',[LoanTypeController::class, 'show']);
    Route::put('/loan-types/update/{id}',[LoanTypeController::class, 'update']);
    Route::post('/loan-types/store',[LoanTypeController::class, 'store']);
    Route::delete('/loan-types/destroy/{id}', [LoanTypeController::class, 'destroy']);

    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/{customer:id}', [CustomerController::class, 'view']);
    Route::post('/customers/store', [CustomerController::class, 'store']);
    Route::post('/customers/update/{customer:id}', [CustomerController::class, 'update']);
    Route::delete('/customers/destroy/{customer:id}', [CustomerController::class, 'destroy']);
    Route::get('/customers/search/{keyword}', [CustomerController::class, 'search']);
    Route::get('/customers/person/count', [CustomerController::class, 'count']);

    Route::delete('/logout', [LogoutController::class, 'logout']);
    Route::put('/change-password', [ChangePasswordController::class, 'update']);


    Route::get('/loans', [LoanController::class, 'index']);
    Route::get('/loans/{loan:id}', [LoanController::class, 'view']);
    Route::get('/loans/customer/{id}', [LoanController::class, 'getLoanByCustomer']);
    Route::post('/loans/store', [LoanController::class, 'store']);    
    Route::delete('/loans/destroy/{loan:id}', [LoanController::class, 'destroy']);

    Route::get('/payments', [PaymentController::class, 'index']);
    Route::get('/payments/{payment:id}', [PaymentController::class, 'view']);
    Route::post('/payments/store', [PaymentController::class, 'store']);
    Route::delete('/payments/destroy/{payment:id}', [PaymentController::class, 'destroy']);

   

 


});
