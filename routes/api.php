<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\LoanTypeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\PaymentDueDateController;
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

    Route::get('/customers', [BorrowerController::class, 'index']);
    Route::get('/customers/{id}', [BorrowerController::class, 'view']);
    Route::post('/customers/store', [BorrowerController::class, 'store']);
    Route::post('/customers/update/{customer:id}', [BorrowerController::class, 'update']);
    Route::delete('/customers/destroy/{customer:id}', [BorrowerController::class, 'destroy']);
    Route::get('/customers/search/{keyword}', [BorrowerController::class, 'search']);
    Route::get('/customers/person/count', [BorrowerController::class, 'count']);
   

    Route::delete('/logout', [LogoutController::class, 'logout']);
    Route::put('/change-password', [ChangePasswordController::class, 'update']);

    Route::get('/loans', [LoanController::class, 'index']);
    Route::get('/loans/{id}', [LoanController::class, 'view']);
    Route::get('/loans/borrower/{id}', [LoanController::class, 'getLoanByCustomer']);
    Route::post('/loans/store', [LoanController::class, 'store']);    
    Route::delete('/loans/destroy/{loan:id}', [LoanController::class, 'destroy']);
    Route::put('/loans/update-status/{loan:id}', [LoanController::class, 'updateStatus']);
    Route::get('/loans/existing-loan/{id}', [LoanController::class, 'exist']);
    Route::get('/loans/search/keyword={keyword}', [LoanController::class, 'search']);
    Route::get('/loans/customers/{id}/active-loan', [LoanController::class, 'activeLoan']);
   

    Route::get('/payments', [PaymentController::class, 'index']);
    Route::get('/payments/{payment:id}', [PaymentController::class, 'view']);
    Route::post('/payments/store', [PaymentController::class, 'store']);
    Route::delete('/payments/destroy/{payment:id}', [PaymentController::class, 'destroy']);  
    
    Route::get('/payment-due-date/loans/{id}', [PaymentDueDateController::class, 'index']);
    Route::get('/payment-due-date/{id}', [PaymentDueDateController::class, 'show']);

    Route::get('/interests', [InterestController::class, 'index']);
    Route::get('/interests/{interest:id}', [InterestController::class, 'view']);
    Route::post('/interests/store', [InterestController::class, 'store']);
    Route::put('/interests/update/{interest:id}', [InterestController::class, 'update']);
    Route::delete('/interests/destroy/{interest:id}', [InterestController::class, 'destroy']);

 


});
