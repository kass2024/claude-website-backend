<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ConsultationRequestAdminController;
use App\Http\Controllers\Admin\ContactMessageAdminController;
use App\Http\Controllers\Admin\QuoteRequestAdminController;
use App\Http\Controllers\Admin\BoardMemberAdminController;
use App\Http\Controllers\Admin\PartnerAdminController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\ProjectAdminController;
use App\Http\Controllers\Admin\ServiceAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Public\BoardMemberController;
use App\Http\Controllers\Public\BlogPostController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\ConsultationRequestController;
use App\Http\Controllers\Public\ContactMessageController;
use App\Http\Controllers\Public\QuoteRequestController;
use App\Http\Controllers\Public\FaqController;
use App\Http\Controllers\Public\FileController;
use App\Http\Controllers\Public\PartnerController;
use App\Http\Controllers\Public\ProjectController;
use App\Http\Controllers\Public\ServiceController;
use App\Http\Controllers\Public\SettingController;
use App\Http\Controllers\Public\TestimonialController;
use Illuminate\Support\Facades\Route;

// Public API is consumed by a static-exported frontend on shared hosting (cPanel).
// Prevent any intermediary cache (browser/CDN/proxy) from serving stale JSON after admin edits.
Route::middleware('no-cache')->group(function () {
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{service:slug}', [ServiceController::class, 'show']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{project:slug}', [ProjectController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);

    Route::get('/posts', [BlogPostController::class, 'index']);
    Route::get('/posts/{post:slug}', [BlogPostController::class, 'show']);

    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/faqs', [FaqController::class, 'index']);
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/board-members', [BoardMemberController::class, 'index']);
    Route::get('/partners', [PartnerController::class, 'index']);
    Route::get('/files/{path}', [FileController::class, 'show'])->where('path', '.*');
});

Route::post('/contact', [ContactMessageController::class, 'store']);
Route::post('/consultation', [ConsultationRequestController::class, 'store']);
Route::post('/quote', [QuoteRequestController::class, 'store']);
// POST /career-application will be added with file upload when career module is implemented.

Route::prefix('/admin')->middleware('no-cache')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AdminAuthController::class, 'me']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);

        Route::post('/upload', [UploadController::class, 'store']);

        Route::apiResource('services', ServiceAdminController::class);
        Route::apiResource('projects', ProjectAdminController::class);
        Route::apiResource('posts', PostAdminController::class);
        Route::apiResource('board-members', BoardMemberAdminController::class);
        
        // Additional routes for soft delete management
        Route::post('/board-members/{boardMember}/force-delete', [BoardMemberAdminController::class, 'forceDestroy']);
        Route::post('/board-members/{boardMember}/restore', [BoardMemberAdminController::class, 'restore']);
        Route::apiResource('partners', PartnerAdminController::class);

        Route::get('/settings', [SettingAdminController::class, 'index']);
        Route::put('/settings/{setting}', [SettingAdminController::class, 'update']);

        Route::get('/contact-messages', [ContactMessageAdminController::class, 'index']);
        Route::get('/contact-messages/{contactMessage}', [ContactMessageAdminController::class, 'show']);

        Route::get('/consultation-requests', [ConsultationRequestAdminController::class, 'index']);
        Route::get('/consultation-requests/{consultationRequest}', [ConsultationRequestAdminController::class, 'show']);

        Route::get('/quote-requests', [QuoteRequestAdminController::class, 'index']);
        Route::get('/quote-requests/{quoteRequest}', [QuoteRequestAdminController::class, 'show']);
        Route::put('/quote-requests/{quoteRequest}', [QuoteRequestAdminController::class, 'update']);
        Route::post('/quote-requests/{quoteRequest}/approve', [QuoteRequestAdminController::class, 'approve']);
    });
});

