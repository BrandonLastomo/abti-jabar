<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/about', function () {
    return view('tentang-kami');
})->name('about');
Route::get('/west-java-corner', function () {
    return view('west-java-corner');
})->name('west-java-corner');
Route::get('/event', function () {
    return view('event');
})->name('event');
Route::get('/database', function () {
    return view('database');
})->name('database');
Route::get('/profile', function () {
    return view('profile');
})->name('profile');
Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');
Route::get('/archives', function () {
    return view('archives');
})->name('archives');