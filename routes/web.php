<?php

use App\Http\Controllers\AboutPublicController;
use App\Http\Controllers\ArchivePublicController;
use App\Http\Controllers\CMSController\AboutController;
use App\Http\Controllers\CMSController\AnggotaController;
use App\Http\Controllers\CMSController\ArchivesController;
use App\Http\Controllers\CMSController\BigNewsController;
use App\Http\Controllers\CMSController\EventController;
use App\Http\Controllers\CMSController\GalleryController;
use App\Http\Controllers\CMSController\HeroController;
use App\Http\Controllers\CMSController\KegiatanController;
use App\Http\Controllers\CMSController\NewsContentController;
use App\Http\Controllers\CMSController\ProfileController;
use App\Http\Controllers\CMSController\ProgramKerjaController;
use App\Http\Controllers\CMSController\SponsorController;
use App\Http\Controllers\CMSController\ViewBigNewsController;
use App\Http\Controllers\CMSController\WestJavaVideoController;
use App\Http\Controllers\CMSController\HighlightController;
use App\Http\Controllers\EditBigNewsController;
use App\Http\Controllers\EventPublicController;
use App\Http\Controllers\GalleryPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilePublicController;
use App\Http\Controllers\WestJavaCornerController;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutPublicController::class, 'index'])->name('about-us');
Route::get('/west-java-corner', [WestJavaCornerController::class, 'index'])->name('west-java-corner');
Route::get('/event', [EventPublicController::class, 'index'])->name('event');
Route::get('/database', function () {
    return view('database');
})->name('database');
Route::get('/profile', [ProfilePublicController::class, 'index'])->name('profile');
Route::get('/gallery', [GalleryPublicController::class, 'index'])->name('gallery');
Route::get('/archives', [ArchivePublicController::class, 'index'])->name('archives');

Route::get('/cms', function () {
    return view('/cms/hero', [
        'page' => 'home'
    ]);
});


Route::get('/cms', [HeroController::class, 'index']); 

Route::resource('/cms/hero', HeroController::class)->only(['index', 'store']);
Route::resource('/cms/highlight', HighlightController::class);
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
Route::resource('/cms/west-java-videos', WestJavaVideoController::class);
Route::resource('/cms/sponsor', SponsorController::class);
// Route::get('/cms/viewBignews', [ViewBigNewsController::class, 'index'])->name('viewBignews.index');
Route::resource('/cms/kegiatan', KegiatanController::class);