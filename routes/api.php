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
use App\Http\Controllers\Report\LoanReportController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Report\PaymentReportController;
use App\Http\Controllers\Report\BorrowerReportController;


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

Route::controller(ResetPasswordController::class)->prefix('reset-password')->group(function () {

    Route::get('/{token}',  'index');

    Route::put('/',  'reset');

});



Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/app/dashboard', [AppController::class, 'dashboard']);

    Route::delete('/logout', [LogoutController::class, 'logout']);

    Route::put('/change-password', [ChangePasswordController::class, 'update']);

    Route::controller(UserController::class)->prefix('user')->group(function () {

        Route::get('/', 'user');

        Route::put('/update', 'update');

        Route::post('/upload-avatar', 'upload');

    });  
    
    Route::controller(LoanTypeController::class)->prefix('loan-types')->group(function () {

        Route::get('/', 'index');

        Route::get('/{loantype:id}','show');

        Route::put('/update/{id}', 'update');

        Route::post('/store', 'store');

        Route::delete('/destroy/{id}', 'destroy');

    });
  
    Route::controller(BorrowerController::class)->prefix('borrowers')->group(function () {

        Route::get('/', 'index');

        Route::get('/show/{borrower:id}', 'show');

        Route::get('/{borrower:id}/edit', 'edit');

        Route::post('/store','store');

        Route::post('/update/{borrower:id}', 'update');

        Route::delete('/destroy/{borrower:id}', 'destroy');

        Route::get('/search/{keyword}',  'search');

        Route::get('/person/count',  'count');

    });
   
    Route::controller(LoanController::class)->prefix('loans')->group(function () {  

        Route::get('/', 'index');

        Route::get('/{id}', 'view');

        Route::get('/borrower/{id}', 'getLoanByCustomer');

        Route::post('/store','store');   

        Route::delete('/destroy/{loan:id}',  'destroy');

        Route::put('/update-status/{loan:id}',  'updateStatus');

        Route::get('/existing-loan/{id}', 'exist');

        Route::get('/search/keyword={keyword}',  'search');

        Route::get('/customers/{id}/active-loan', 'activeLoan');

    });

    Route::controller(PaymentController::class)->prefix('payments')->group(function () {  

        Route::get('/', 'index');

        Route::get('/{payment:id}',  'view');

        Route::post('/store',  'store');

        Route::delete('/destroy/{payment:id}',  'destroy'); 

    });

    Route::controller(PaymentDueDateController::class)->prefix('payment-due-date')->group(function () {  

        Route::get('/loans/{id}',  'index');

        Route::get('/{id}', 'show');

    });

    Route::controller(InterestController::class)->prefix('interests')->group(function () { 

        Route::get('/', 'index');

        Route::get('/{interest:id}', 'view');

        Route::post('/store',  'store');

        Route::put('/update/{interest:id}', 'update');

        Route::delete('/destroy/{interest:id}', 'destroy');        

     });

     Route::post('/reports/loans', [LoanReportController::class, 'index']);

     Route::post('/reports/borrowers',[BorrowerReportController::class, 'index']);

     Route::post('/reports/payments',[PaymentReportController::class, 'index']);

});
