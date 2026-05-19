<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All admin routes require authentication and admin role
|
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Books Management
    Route::resource('books', BookController::class);
    Route::patch('/books/{id}/approve', [BookController::class, 'approve'])->name('books.approve');
    Route::patch('/books/{id}/reject', [BookController::class, 'reject'])->name('books.reject');

    // Authors Management
    Route::resource('authors', AuthorController::class);

    // Categories Management
    Route::resource('categories', CategoryController::class);

    // Publishers Management
    Route::resource('publishers', PublisherController::class);

    // Tags Management
    Route::resource('tags', TagController::class);

    // Sliders Management
    Route::resource('sliders', SliderController::class);

    // Users Management
    Route::resource('users', UserController::class);
    Route::patch('/users/{id}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::patch('/users/{id}/unban', [UserController::class, 'unban'])->name('users.unban');
    Route::patch('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.role');
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

    // Orders Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    // Reports Management
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::patch('/reports/{id}/resolve', [ReportController::class, 'resolve'])->name('reports.resolve');
    Route::patch('/reports/{id}/reject', [ReportController::class, 'reject'])->name('reports.reject');

    // Comments Management
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{id}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Reviews alias (same as comments)
    Route::get('/reviews', [CommentController::class, 'index'])->name('reviews.index');

    // Transactions Management
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // Settings Management
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

    // Notifications Management
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');

    // Admins Management
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Contact Messages Management
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{id}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::post('/contacts/{id}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.markRead');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});
