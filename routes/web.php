<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\ArchivesController;
use App\Http\Controllers\BigNewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\NewsContentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ViewBigNewsController;
use App\Http\Controllers\ProgramKerjaController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\EditBigNewsController;
use Illuminate\Pagination\LengthAwarePaginator;


Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/about-us', function () {
    return view('tentang-kami');
})->name('about-us');
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

Route::get('/cms', function () {
    return view('/cms/hero', [
        'page' => 'home'
    ]);
});


Route::get('/cms', [HeroController::class, 'index']); 

Route::resource('/cms/hero', HeroController::class)->only(['index', 'store']);

Route::resource('/cms/about', AboutController::class);
Route::resource('/cms/anggota', AnggotaController::class)
    ->parameters([
        'anggota' => 'anggota'
    ]);
Route::resource('/cms/archive', ArchivesController::class);
Route::get('/cms/big-news', [BigNewsController::class, 'index'])->name('big_news.index');
Route::resource('big_news', BigNewsController::class);
Route::resource('/cms/events', EventController::class);
Route::resource('/cms/gallery', GalleryController::class);
Route::delete('/gallery-photo/{photo}', [GalleryController::class, 'deletePhoto'])
    ->name('gallery.photo.delete');
Route::get('/cms/hero', [HeroController::class, 'index'])->name('hero.index');
Route::resource('/cms/club', ProfileController::class);
Route::resource('/cms/program-kerja', ProgramKerjaController::class);
Route::resource('/cms/news-content', NewsContentController::class)
    ->parameters([
        'news-content' => 'news'
    ]);;
Route::resource('/cms/sponsor', SponsorController::class);
Route::get('/cms/viewBignews', [ViewBigNewsController::class, 'index'])->name('viewBignews.index');
Route::resource('/cms/kegiatan', KegiatanController::class);