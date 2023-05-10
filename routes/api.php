<?php

use App\Modules\Invoices\Presentation\Http\Rest\V1\InvoiceApproveController;
use App\Modules\Invoices\Presentation\Http\Rest\V1\InvoiceDisplayController;
use App\Modules\Invoices\Presentation\Http\Rest\V1\InvoiceRejectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Rfc4122\Validator;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::pattern('invoiceId', (new Validator())->getPattern());
Route::prefix('api/v1/invoice/{invoiceId}')->group(function () {
    Route::get('/', InvoiceDisplayController::class)->name('api.v1.invoice.display');
    Route::put('/approve', InvoiceApproveController::class)->name('api.v1.invoice.approve');
    Route::put('/reject', InvoiceRejectController::class)->name('api.v1.invoice.reject');
});
