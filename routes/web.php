<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// User Routes
Route::get('/', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
Route::get('/about', function () { return view('user.about'); })->name('about');
Route::get('/contact', [App\Http\Controllers\User\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\User\ContactController::class, 'submit'])->name('contact.submit');

// Books Routes
Route::get('/books', [App\Http\Controllers\User\BookController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [App\Http\Controllers\User\BookController::class, 'show'])->name('books.show');

// Authors Routes
Route::get('/authors', [App\Http\Controllers\User\AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{slug}', [App\Http\Controllers\User\AuthorController::class, 'show'])->name('authors.show');

// Cart Routes (guest)
Route::get('/cart', [App\Http\Controllers\User\CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [App\Http\Controllers\User\CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{bookId}', [App\Http\Controllers\User\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [App\Http\Controllers\User\CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/clear', [App\Http\Controllers\User\CartController::class, 'clear'])->name('cart.clear');

// Wishlist Routes (guest)
Route::get('/wishlist', [App\Http\Controllers\User\WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/toggle', [App\Http\Controllers\User\WishlistController::class, 'toggle'])->name('wishlist.toggle');

// Auth Routes
Route::get('/login', [App\Http\Controllers\User\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\User\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\User\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\User\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\User\AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [App\Http\Controllers\User\AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\User\AuthController::class, 'forgotPassword'])->name('password.email');

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    // History Routes
    Route::get('/history', [App\Http\Controllers\User\HistoryController::class, 'index'])->name('history');

    // Notifications Routes
    Route::get('/notifications', [App\Http\Controllers\User\NotificationController::class, 'index'])->name('notifications');
    Route::patch('/notifications/{id}/read', [App\Http\Controllers\User\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::patch('/notifications/mark-all-read', [App\Http\Controllers\User\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{id}', [App\Http\Controllers\User\NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Account Routes
    Route::get('/my-account', [App\Http\Controllers\User\AccountController::class, 'index'])->name('account.index');
    Route::patch('/profile', [App\Http\Controllers\User\AccountController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/password', [App\Http\Controllers\User\AccountController::class, 'changePassword'])->name('password.change');

    // Recharge Routes
    Route::get('/recharge', [App\Http\Controllers\User\RechargeController::class, 'index'])->name('recharge');
    Route::post('/recharge', [App\Http\Controllers\User\RechargeController::class, 'process'])->name('recharge.process');
    Route::get('/recharge/callback', [App\Http\Controllers\User\RechargeController::class, 'callback'])->name('recharge.callback');

    // Upload Book Routes
    Route::get('/upload-book', [App\Http\Controllers\User\UploadBookController::class, 'create'])->name('books.upload');
    Route::post('/upload-book', [App\Http\Controllers\User\UploadBookController::class, 'store'])->name('books.store');

    // Book Actions (AJAX)
    Route::post('/books/{id}/wishlist', [App\Http\Controllers\User\BookActionController::class, 'toggleWishlist'])->name('books.wishlist');
    Route::post('/books/{id}/review', [App\Http\Controllers\User\BookActionController::class, 'storeReview'])->name('books.review');
    Route::post('/books/{id}/comment', [App\Http\Controllers\User\BookActionController::class, 'storeComment'])->name('books.comment');
    Route::post('/books/{id}/report', [App\Http\Controllers\User\BookActionController::class, 'reportBook'])->name('books.report');
    Route::get('/books/{id}/download', [App\Http\Controllers\User\BookActionController::class, 'downloadBook'])->name('books.download');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::get('/books', function () { return view('admin.books'); })->name('admin.books');
    Route::get('/books/create', function () { return view('admin.books-create'); })->name('admin.books.create');
    Route::get('/books/edit/{id}', function ($id) { return view('admin.books-edit', compact('id')); })->name('admin.books.edit');
    Route::get('/authors', function () { return view('admin.authors'); })->name('admin.authors');
    Route::get('/categories', function () { return view('admin.categories'); })->name('admin.categories');
    Route::get('/reviews', function () { return view('admin.reviews'); })->name('admin.reviews');
    Route::get('/orders', function () { return view('admin.orders'); })->name('admin.orders');
    Route::get('/transactions', function () { return view('admin.transactions'); })->name('admin.transactions');
    Route::get('/users', function () { return view('admin.users'); })->name('admin.users');
    Route::get('/admins', function () { return view('admin.admins'); })->name('admin.admins');
    Route::get('/notifications', function () { return view('admin.notifications'); })->name('admin.notifications');
    Route::get('/reports', function () { return view('admin.reports'); })->name('admin.reports');
    Route::get('/settings', function () { return view('admin.settings'); })->name('admin.settings');
    Route::get('/profile', function () { return view('admin.profile'); })->name('admin.profile');
});
