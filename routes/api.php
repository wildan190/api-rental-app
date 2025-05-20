<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\FaqController;
use App\Http\Controllers\Api\Admin\GalleryController;
use App\Http\Controllers\Api\Admin\MetaWebController;
use App\Http\Controllers\Api\Admin\MobilController;
use App\Http\Controllers\Api\Admin\TestimoniController;
use App\Http\Controllers\Api\Web\AboutUsController;
use App\Http\Controllers\Api\Web\LandingPageController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/home', [LandingPageController::class, 'index']);
Route::get('/about-us', [AboutUsController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/mobils', [MobilController::class, 'index']);
    Route::post('/mobils', [MobilController::class, 'store']);
    Route::get('/mobils/{id}', [MobilController::class, 'show']);
    Route::put('/mobils/{id}', [MobilController::class, 'update']);
    Route::delete('/mobils/{id}', [MobilController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/galleries', [GalleryController::class, 'index']);
    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::get('/galleries/{id}', [GalleryController::class, 'show']);
    Route::put('/galleries/{id}', [GalleryController::class, 'update']);
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/faqs', [FaqController::class, 'index']);
    Route::post('/faqs', [FaqController::class, 'store']);
    Route::get('/faqs/{id}', [FaqController::class, 'show']);
    Route::put('/faqs/{id}', [FaqController::class, 'update']);
    Route::delete('/faqs/{id}', [FaqController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/testimonis', [TestimoniController::class, 'index']);
    Route::post('/testimonis', [TestimoniController::class, 'store']);
    Route::get('/testimonis/{id}', [TestimoniController::class, 'show']);
    Route::put('/testimonis/{id}', [TestimoniController::class, 'update']);
    Route::delete('/testimonis/{id}', [TestimoniController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/meta-web', [MetaWebController::class, 'index']);
    Route::post('/meta-web', [MetaWebController::class, 'storeOrUpdate']);
});
