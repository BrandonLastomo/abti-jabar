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
use App\Http\Controllers\CMSController\HighlightController;
use App\Http\Controllers\CMSController\KegiatanController;
use App\Http\Controllers\CMSController\NewsContentController;
use App\Http\Controllers\CMSController\ProfileController as CMSProfileController;
use App\Http\Controllers\CMSController\ProgramKerjaController;
use App\Http\Controllers\CMSController\SponsorController;
use App\Http\Controllers\CMSController\ViewBigNewsController;
use App\Http\Controllers\CMSController\WestJavaVideoController;
use App\Http\Controllers\CMSController\LiveController;
use App\Http\Controllers\CMSController\FooterContentController;
use App\Http\Controllers\CMSController\UserManagementController;
use App\Http\Controllers\EditBigNewsController;
use App\Http\Controllers\EventPublicController;
use App\Http\Controllers\GalleryPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilePublicController;
use App\Http\Controllers\WestJavaCornerController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// ======================== PUBLIC ROUTES ========================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutPublicController::class, 'index'])->name('about-us');
Route::get('/west-java-corner', [WestJavaCornerController::class, 'index'])->name('west-java-corner');
Route::get('/event', [EventPublicController::class, 'index'])->name('event');
Route::get('/database', function () {
    return view('database');
})->name('database');
Route::get('/profile-team', [ProfilePublicController::class, 'index'])->name('profile');
Route::get('/gallery', [GalleryPublicController::class, 'index'])->name('gallery');
Route::get('/archives', [ArchivePublicController::class, 'index'])->name('archives');


// ======================== AUTH: BREEZE PROFILE (shared) ========================
Route::middleware('auth')->group(function () {
    Route::get('/account', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ======================== USER ROUTES (role: user) ========================
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::post('/documents', [UserProfileController::class, 'uploadDocument'])->name('documents.store');
    Route::delete('/documents/{document}', [UserProfileController::class, 'deleteDocument'])->name('documents.destroy');
});


// ======================== ADMIN ROUTES (role: admin) ========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/documents/{document}/verify', [AdminDashboardController::class, 'verify'])->name('documents.verify');
    Route::patch('/documents/{document}/reject', [AdminDashboardController::class, 'reject'])->name('documents.reject');
});


// ======================== SUPERADMIN: CMS ROUTES (role: superadmin) ========================
Route::middleware(['auth', 'role:superadmin'])->prefix('cms')->group(function () {

    Route::get('/', [HeroController::class, 'index']);

    Route::resource('/hero', HeroController::class)->only(['index', 'store']);
    Route::resource('/highlight', HighlightController::class);
    Route::resource('/about', AboutController::class);
    Route::resource('/anggota', AnggotaController::class)
        ->parameters([
            'anggota' => 'anggota'
        ]);
    Route::resource('/archive', ArchivesController::class);
    Route::get('/big-news', [BigNewsController::class, 'index'])->name('big_news.index');
    Route::resource('/big_news', BigNewsController::class);
    Route::resource('/events', EventController::class);
    Route::resource('/galleries', GalleryController::class);
    Route::delete('/gallery-photo/{photo}', [GalleryController::class, 'deletePhoto'])
        ->name('gallery.photo.delete');
    Route::get('/hero', [HeroController::class, 'index'])->name('hero.index');
    Route::resource('/club', CMSProfileController::class);
    Route::resource('/program-kerja', ProgramKerjaController::class);
    Route::resource('/news-content', NewsContentController::class)
        ->parameters([
            'news-content' => 'news'
        ]);
    Route::resource('/west-java-videos', WestJavaVideoController::class);
    Route::resource('/sponsor', SponsorController::class);
    Route::resource('/kegiatan', KegiatanController::class);
    Route::get('/footer', [FooterContentController::class, 'index'])->name('footer.index');
    Route::put('/footer', [FooterContentController::class, 'update'])->name('footer.update');
    Route::resource('/live', LiveController::class);
    Route::patch('/live/{live}/toggle', [LiveController::class, 'toggleLive'])->name('live.toggle');

    // User management (superadmin only)
    Route::resource('/users', UserManagementController::class)->except(['show']);
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
});


require __DIR__.'/auth.php';
