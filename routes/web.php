<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HeatmapController;
use App\Http\Controllers\HelplinesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// ====================================================================
// PUBLIC ROUTES
// ====================================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

// Incidents — public viewing
Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');
Route::get('/incidents/{slug}', [IncidentController::class, 'show'])->name('incidents.show');

// Heatmap
Route::get('/heatmap', [HeatmapController::class, 'index'])->name('heatmap');

// Emergency Helplines
Route::get('/helplines', [HelplinesController::class, 'index'])->name('helplines');

// ====================================================================
// API / AJAX ENDPOINTS
// ====================================================================

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/lgas', [IncidentController::class, 'getLgas'])->name('lgas');
    Route::get('/heatmap/data', [HeatmapController::class, 'data'])->name('heatmap.data');
    Route::get('/heatmap/states', [HeatmapController::class, 'stateStats'])->name('heatmap.states');
});

// ====================================================================
// AUTHENTICATION
// ====================================================================

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ====================================================================
// AUTHENTICATED USER ROUTES
// ====================================================================

Route::middleware(['auth'])->group(function () {
    // Comments
    Route::post('/incidents/{incident}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    // User threat reports
    Route::get('/report', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/report', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/my-reports', [ReportController::class, 'myReports'])->name('reports.my');
});

// ====================================================================
// ADMIN ROUTES
// ====================================================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    // ── Incidents ────────────────────────────────────────────────
    Route::get('/incidents', [App\Http\Controllers\Admin\IncidentController::class, 'index'])
        ->name('incidents.index');
    Route::get('/incidents/create', [App\Http\Controllers\Admin\IncidentController::class, 'create'])
        ->name('incidents.create');
    Route::post('/incidents', [App\Http\Controllers\Admin\IncidentController::class, 'store'])
        ->name('incidents.store');
    Route::get('/incidents/{incident}', [App\Http\Controllers\Admin\IncidentController::class, 'show'])
        ->name('incidents.show');
    Route::get('/incidents/{incident}/edit', [App\Http\Controllers\Admin\IncidentController::class, 'edit'])
        ->name('incidents.edit');
    Route::put('/incidents/{incident}', [App\Http\Controllers\Admin\IncidentController::class, 'update'])
        ->name('incidents.update');
    Route::patch('/incidents/{incident}/approve', [App\Http\Controllers\Admin\IncidentController::class, 'approve'])
        ->name('incidents.approve');
    Route::patch('/incidents/{incident}/reject', [App\Http\Controllers\Admin\IncidentController::class, 'reject'])
        ->name('incidents.reject');
    Route::patch('/incidents/{incident}/toggle-featured', [App\Http\Controllers\Admin\IncidentController::class, 'toggleFeatured'])
        ->name('incidents.toggle-featured');
    Route::delete('/incidents/{incident}', [App\Http\Controllers\Admin\IncidentController::class, 'destroy'])
        ->name('incidents.destroy')
        ->middleware('admin:super_admin');

    // ── User Reports ─────────────────────────────────────────────
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('/reports/{report}', [App\Http\Controllers\Admin\ReportController::class, 'show'])
        ->name('reports.show');
    Route::patch('/reports/{report}/review', [App\Http\Controllers\Admin\ReportController::class, 'review'])
        ->name('reports.review');
    Route::post('/reports/{report}/convert', [App\Http\Controllers\Admin\ReportController::class, 'convertToIncident'])
        ->name('reports.convert');
    Route::delete('/reports/{report}', [App\Http\Controllers\Admin\ReportController::class, 'destroy'])
        ->name('reports.destroy');

    // ── Users ────────────────────────────────────────────────────
    Route::middleware('admin:super_admin')->group(function () {
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('users.index');
        Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])
            ->name('users.show');
        Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
        Route::patch('/users/{user}/change-role', [App\Http\Controllers\Admin\UserController::class, 'changeRole'])
            ->name('users.change-role');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])
            ->name('users.destroy');
    });

    // ── Comments ─────────────────────────────────────────────────
    Route::get('/comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])
        ->name('comments.index');
    Route::patch('/comments/{comment}/approve', [App\Http\Controllers\Admin\CommentController::class, 'approve'])
        ->name('comments.approve');
    Route::patch('/comments/{comment}/reject', [App\Http\Controllers\Admin\CommentController::class, 'reject'])
        ->name('comments.reject');
    Route::delete('/comments/{comment}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])
        ->name('comments.destroy');

    // ── Helplines ─────────────────────────────────────────────────
    Route::resource('helplines', App\Http\Controllers\Admin\HelplinesController::class)
        ->names('helplines');
});
