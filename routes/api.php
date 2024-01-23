<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChangeEmailController;
use App\Http\Controllers\CsrfTokenController;
use App\Http\Controllers\CategoryController;

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

// login
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/csrf-token', [CsrfTokenController::class, 'getToken']);

// events
Route::get('/events', [EventController::class, 'index']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);
Route::post('/events', [EventController::class, 'store']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/juror/{id}/event/', [EventController::class, 'getJurorEvent']);

// all users
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::post('/check-change-password/{id}', [UserController::class, 'checkChangePassword']);
Route::post('set-new-password/{id}', [UserController::class, 'setNewPassword']);
Route::post('/reset-password/{id}', [UserController::class, 'resetPassword']);
Route::post('/save-new-password', [UserController::class, 'saveNewPassword']);

// email change
Route::post('/change-email/{id}', [ChangeEmailController::class, 'changeEmail']);
Route::post('/email-verification/{id}', [ChangeEmailController::class, 'emailVerification']);

// jurors
Route::get('/jurors/{id}', [UserController::class, 'indexJurors']);
Route::delete('/jurors/{id}', [UserController::class, 'destroyJuror']);
Route::post('/jurors', [UserController::class, 'storeJuror']);

// categories
Route::get('/event/{id}/categories', [CategoryController::class, 'indexCategories']);
Route::get('/juror/{jurorId}/categories', [CategoryController::class, 'indexCategoriesJuror']);
Route::post('/categories', [CategoryController::class, 'storeCategory']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroyCategory']);

// super administrator web client

// organizers
Route::get('/organizers', [UserController::class, 'indexOrganizers']);
Route::get('/organizers/{id}', [UserController::class, 'singleOrganizer']);
Route::post('/organizers', [UserController::class, 'storeOrganizer']);
Route::delete('/organizers/{id}', [UserController::class, 'destroyOrganizer']);
Route::put('/organizers/{id}', [UserController::class, 'updateOrganizer']);
Route::get('/organizers/{id}/events', [UserController::class, 'organizerEvents']);

// jurors
Route::get('/jurors', [UserController::class, 'indexJurorsAdmin']);
Route::put('/jurors/{id}', [UserController::class, 'updateJuror']);