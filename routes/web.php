<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// User Routes
Route::get('/', function () {
    return view('user.index');
})->name('home');

Route::get('/about', function () {
    return view('user.about');
})->name('about');

Route::get('/author-detail', function () {
    return view('user.author-detail');
})->name('author-detail');

Route::get('/authors', function () {
    return view('user.authors');
})->name('authors');

Route::get('/books-detail', function () {
    return view('user.books-detail');
})->name('books-detail');

Route::get('/books', function () {
    return view('user.books');
})->name('books');

Route::get('/cart', function () {
    return view('user.cart');
})->name('cart');

Route::get('/contact', function () {
    return view('user.contact');
})->name('contact');

Route::get('/history', function () {
    return view('user.history');
})->name('history');

Route::get('/login', function () {
    return view('user.login');
})->name('login');

Route::get('/my-account', function () {
    return view('user.my-account');
})->name('my-account');

Route::get('/notifications', function () {
    return view('user.notifications');
})->name('notifications');

Route::get('/recharge', function () {
    return view('user.recharge');
})->name('recharge');

Route::get('/upload-book', function () {
    return view('user.upload-book');
})->name('upload-book');

Route::get('/wishlist', function () {
    return view('user.wishlist');
})->name('wishlist');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/books', function () {
        return view('admin.books');
    })->name('admin.books');

    Route::get('/books/create', function () {
        return view('admin.books-create');
    })->name('admin.books.create');

    Route::get('/books/edit/{id}', function ($id) {
        return view('admin.books-edit', compact('id'));
    })->name('admin.books.edit');

    Route::get('/authors', function () {
        return view('admin.authors');
    })->name('admin.authors');

    Route::get('/categories', function () {
        return view('admin.categories');
    })->name('admin.categories');

    Route::get('/reviews', function () {
        return view('admin.reviews');
    })->name('admin.reviews');

    Route::get('/orders', function () {
        return view('admin.orders');
    })->name('admin.orders');

    Route::get('/transactions', function () {
        return view('admin.transactions');
    })->name('admin.transactions');

    Route::get('/users', function () {
        return view('admin.users');
    })->name('admin.users');

    Route::get('/admins', function () {
        return view('admin.admins');
    })->name('admin.admins');

    Route::get('/notifications', function () {
        return view('admin.notifications');
    })->name('admin.notifications');

    Route::get('/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');

    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');

    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');
});
