<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\AdController as AdminAdController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController as PublicNewsController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [PublicNewsController::class, 'show'])->name('news.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login']);
});

Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes (Protected)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // News Management
    Route::resource('news', AdminNewsController::class);
    Route::post('/trix-attachment', [AdminNewsController::class, 'uploadTrixAttachment'])->name('trix.attachment');
    
    // Category Management
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    
    // Ads Management
    Route::resource('ads', AdminAdController::class);
});
