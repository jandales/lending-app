<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\LoanTypeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\PaymentDueDateController;
use App\Http\Controllers\Export\LoanExportController;
use App\Http\Controllers\Report\LoanReportController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Export\PaymentExportController;
use App\Http\Controllers\Report\PaymentReportController;
use App\Http\Controllers\Export\BorrowerExportController;
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

    Route::get('/setcookie', [AppController::class, 'setcookie']);

    Route::get('/getCookie', [AppController::class, 'getCookie']);

    Route::get('/app/dashboard', [AppController::class, 'dashboard']);

    Route::delete('/logout', [LogoutController::class, 'logout']);

    Route::put('/change-password', [ChangePasswordController::class, 'update']);

    Route::controller(AccountController::class)->prefix('user')->group(function () {

        Route::get('/', 'user');  
        
        Route::put('/update', 'update');

        Route::post('/upload-avatar', 'upload');

    });  

    Route::controller(UserController::class)->prefix('users')->group(function () {

        Route::get('/', 'index');

        Route::post('/store', 'store');       

        Route::get('/{user:id}/edit', 'edit');

        Route::put('/{user:id}/update', 'update');  
        
        Route::delete('/{user:id}/destroy', 'destroy');

        Route::get('/search', 'search');

      
         
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

        Route::get('/search',  'search');

        Route::get('/person/count',  'count');

    });
   
    Route::controller(LoanController::class)->prefix('loans')->group(function () {  

        Route::get('/', 'index');

        Route::get('/{id}/show', 'view');

        Route::get('/borrower/{id}', 'getLoanByCustomer');

        Route::post('/store','store');   

        Route::delete('/destroy/{loan:id}',  'destroy');

        Route::put('/update-status/{loan:id}',  'updateStatus');

        Route::get('/existing-loan/{id}', 'exist');

        Route::get('/search',  'search');

        Route::get('/customers/{id}/active-loan', 'activeLoan');

    });

    Route::controller(PaymentController::class)->prefix('payments')->group(function () {  

        Route::get('/', 'index');

        // Route::get('/{payment:id}',  'view');

        Route::post('/store',  'store');

        Route::delete('/destroy/{payment:id}',  'destroy'); 

        Route::get('/search',  'search');
      
    });

    Route::controller(PaymentDueDateController::class)->prefix('payment-due-date')->group(function () {  

        Route::get('/loans/{id}',  'index');

        Route::get('/{id}', 'show');

    });

    Route::controller(InterestController::class)->prefix('interests')->group(function () {
        Route::get('/', 'index');
        Route::get('/{interest:id}', 'show');
        Route::post('/store',  'store');
        Route::put('/update/{interest:id}', 'update');
        Route::delete('/destroy/{interest:id}', 'destroy'); 
     });

    Route::controller(PasswordController::class)->prefix('password')->group(function () {         
        Route::post('/reset/user/{id}', 'reset');
    });

    Route::post('/reports/loans', [LoanReportController::class, 'index']);

    Route::post('/reports/borrowers',[BorrowerReportController::class, 'index']);

    Route::post('/reports/payments',[PaymentReportController::class, 'index']);

    Route::post('/report/export/loan', [LoanExportController::class, 'index']);

    Route::get('/loans/details/{id}/create-pdf', [LoanExportController::class, 'createLoanDetailPDF']);

    Route::post('/report/export/borrower', [BorrowerExportController::class, 'index']);

    Route::post('/report/export/payments', [PaymentExportController::class, 'index']);

    Route::get('/create-pdf', [BorrowerExportController::class, 'createPDF']);

    Route::post('/report/loans/create-pdf', [LoanExportController::class, 'createPDF']);

    Route::post('/report/payments/create-pdf', [PaymentExportController::class, 'createPDF']);

});
