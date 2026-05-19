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
Route::get('/books/{id}/read', [App\Http\Controllers\User\BookReaderController::class, 'show'])->name('books.read');
Route::get('/books/{id}/preview', [App\Http\Controllers\User\BookReaderController::class, 'preview'])->name('books.preview');
Route::get('/books/{id}/preview-pdf', [App\Http\Controllers\User\BookReaderController::class, 'previewPdf'])->name('books.preview_pdf');
Route::post('/books/{id}/read/progress', [App\Http\Controllers\User\BookReaderController::class, 'updateProgress'])->name('books.read.progress');
Route::get('/books/{id}/read/page', [App\Http\Controllers\User\BookReaderController::class, 'getPage'])->name('books.read.page');

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
    Route::patch('/my-profile', [App\Http\Controllers\User\AccountController::class, 'updateProfile'])->name('user.profile.update');
    Route::patch('/my-password', [App\Http\Controllers\User\AccountController::class, 'changePassword'])->name('user.password.change');

    // Recharge Routes
    Route::get('/recharge', [App\Http\Controllers\User\RechargeController::class, 'index'])->name('recharge');
    Route::post('/recharge', [App\Http\Controllers\User\RechargeController::class, 'process'])->name('recharge.process');
    Route::get('/recharge/callback', [App\Http\Controllers\User\RechargeController::class, 'callback'])->name('recharge.callback');
    Route::get('/recharge/vnpay-return', [App\Http\Controllers\User\RechargeController::class, 'vnpayReturn'])->name('recharge.vnpay_return');

    // Upload Book Routes
    Route::get('/upload-book', [App\Http\Controllers\User\UploadBookController::class, 'create'])->name('user.books.upload');
    Route::post('/upload-book', [App\Http\Controllers\User\UploadBookController::class, 'store'])->name('user.books.store');

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

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', App\Http\Controllers\Admin\BookController::class);
    Route::patch('/books/{id}/approve', [App\Http\Controllers\Admin\BookController::class, 'approve'])->name('books.approve');
    Route::patch('/books/{id}/reject', [App\Http\Controllers\Admin\BookController::class, 'reject'])->name('books.reject');
    Route::resource('authors', App\Http\Controllers\Admin\AuthorController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('publishers', App\Http\Controllers\Admin\PublisherController::class);
    Route::resource('tags', App\Http\Controllers\Admin\TagController::class);
    Route::resource('sliders', App\Http\Controllers\Admin\SliderController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::patch('/users/{id}/ban', [App\Http\Controllers\Admin\UserController::class, 'ban'])->name('users.ban');
    Route::patch('/users/{id}/unban', [App\Http\Controllers\Admin\UserController::class, 'unban'])->name('users.unban');
    Route::patch('/users/{id}/role', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.role');
    Route::get('/users/export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::patch('/reports/{id}/resolve', [App\Http\Controllers\Admin\ReportController::class, 'resolve'])->name('reports.resolve');
    Route::patch('/reports/{id}/reject', [App\Http\Controllers\Admin\ReportController::class, 'reject'])->name('reports.reject');
    Route::get('/comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
    Route::get('/reviews', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('reviews.index');
    Route::patch('/comments/{id}/approve', [App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{id}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
    Route::get('/admins', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admins.index');
    Route::post('/admins', [App\Http\Controllers\Admin\AdminController::class, 'store'])->name('admins.store');
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{id}/reply', [App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('contacts.reply');
    Route::post('/contacts/{id}/mark-read', [App\Http\Controllers\Admin\ContactController::class, 'markAsRead'])->name('contacts.markRead');
    Route::delete('/contacts/{id}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
});
