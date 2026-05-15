<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/author-detail', function () {
    return view('author-detail');
});

Route::get('/authors', function () {
    return view('authors');
});

Route::get('/books-detail', function () {
    return view('books-detail');
});

Route::get('/books', function () {
    return view('books');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/history', function () {
    return view('history');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/my-account', function () {
    return view('my-account');
});

Route::get('/notifications', function () {
    return view('notifications');
});

Route::get('/recharge', function () {
    return view('recharge');
});

Route::get('/upload-book', function () {
    return view('upload-book');
});

Route::get('/wishlist', function () {
    return view('wishlist');
});
