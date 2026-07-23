<?php

use App\Http\Controllers\AboutPublicController;
use App\Http\Controllers\ArchivePublicController;
use App\Http\Controllers\CMSController\AboutController;
use App\Http\Controllers\CMSController\AnggotaController;
use App\Http\Controllers\CMSController\ArchivesController;

use App\Http\Controllers\CMSController\EventController;
use App\Http\Controllers\CMSController\GalleryController;
use App\Http\Controllers\CMSController\HeroController;

use App\Http\Controllers\CMSController\KegiatanController;
use App\Http\Controllers\CMSController\NewsContentController;

use App\Http\Controllers\CMSController\ProgramKerjaController;
use App\Http\Controllers\CMSController\SponsorController;

use App\Http\Controllers\CMSController\WestJavaVideoController;

use App\Http\Controllers\CMSController\FooterContentController;
use App\Http\Controllers\CMSController\UserManagementController;
use App\Http\Controllers\CMSController\MutationSettingController;
use App\Http\Controllers\CMSController\ClubCMSController;

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
Route::get('/news/{news:slug}', [\App\Http\Controllers\NewsPublicController::class, 'show'])->name('news.show');
Route::get('/program-kerja/{programKerja:slug}', [\App\Http\Controllers\ProgramKerjaPublicController::class, 'show'])->name('program_kerja.show');
Route::get('/education', [\App\Http\Controllers\EducationPublicController::class, 'index'])->name('education');

// ======================== AUTH: BREEZE PROFILE (shared) ========================
Route::middleware('auth')->group(function () {
    Route::get('/account', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ======================== USER ROUTES (role: user) ========================
use App\Http\Controllers\UserController\UserGeneralProfileController;
use App\Http\Controllers\UserController\UserIdentityDocumentController;
use App\Http\Controllers\UserController\UserEducationDocumentController;
use App\Http\Controllers\UserController\UserTeamExperienceController;
use App\Http\Controllers\UserController\UserEventExperienceController;
use App\Http\Controllers\UserController\UserCertificationController;
use App\Http\Controllers\UserController\UserIntegrityDocumentController;

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    // Overview & General Documents
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::post('/documents', [UserProfileController::class, 'uploadDocument'])->name('documents.store');
    Route::delete('/documents/{document}', [UserProfileController::class, 'deleteDocument'])->name('documents.destroy');
    
    // Mutation Proposal
    Route::get('/mutation', [UserProfileController::class, 'mutationForm'])->name('mutation');
    Route::post('/mutation', [UserProfileController::class, 'submitMutation'])->name('mutation.store');

    // 1-to-1 Profile Forms
    Route::get('/profile/general', [UserGeneralProfileController::class, 'index'])->name('profile.general');
    Route::post('/profile/general', [UserGeneralProfileController::class, 'update'])->name('profile.general.update');
    
    Route::get('/profile/identity', [UserIdentityDocumentController::class, 'index'])->name('profile.identity');
    Route::post('/profile/identity', [UserIdentityDocumentController::class, 'update'])->name('profile.identity.update');
    
    Route::get('/profile/education', [UserEducationDocumentController::class, 'index'])->name('profile.education');
    Route::post('/profile/education', [UserEducationDocumentController::class, 'update'])->name('profile.education.update');

    // CRUD for HasMany Relationships
    Route::resource('team-experiences', UserTeamExperienceController::class)->except(['show', 'edit', 'update']);
    Route::resource('event-experiences', UserEventExperienceController::class)->except(['show', 'edit', 'update']);
    Route::resource('certifications', UserCertificationController::class)->except(['show', 'edit', 'update']);
    Route::resource('integrity-documents', UserIntegrityDocumentController::class)->except(['show', 'edit', 'update']);
});


// ======================== ADMIN ROUTES (role: admin, superadmin) ========================
Route::middleware(['auth', 'role:admin|superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/documents', [AdminDashboardController::class, 'documents'])->name('documents.index');
    Route::patch('/documents/{document}/verify', [AdminDashboardController::class, 'verify'])->name('documents.verify');
    Route::patch('/documents/{document}/reject', [AdminDashboardController::class, 'reject'])->name('documents.reject');
    Route::get('/mutations', [AdminDashboardController::class, 'mutations'])->name('mutations.index');
    Route::patch('/mutations/{mutation}/verify', [AdminDashboardController::class, 'verifyMutation'])->name('mutations.verify');
    Route::patch('/mutations/{mutation}/reject', [AdminDashboardController::class, 'rejectMutation'])->name('mutations.reject');
});


// ======================== SUPERADMIN: CMS ROUTES (role: superadmin) ========================
Route::middleware(['auth', 'role:superadmin'])->prefix('cms')->group(function () {

    Route::get('/', [\App\Http\Controllers\CMSController\SuperadminDashboardController::class, 'index'])->name('cms.dashboard');

    Route::resource('/hero', HeroController::class)->only(['index', 'store']);

    Route::resource('/about', AboutController::class);
    Route::resource('/anggota', AnggotaController::class)
        ->parameters([
            'anggota' => 'anggota'
        ]);
    Route::resource('/archive', ArchivesController::class);

    Route::resource('/events', EventController::class);
    Route::resource('/galleries', GalleryController::class);
    Route::delete('/gallery-photo/{photo}', [GalleryController::class, 'deletePhoto'])
        ->name('gallery.photo.delete');
    Route::get('/hero', [HeroController::class, 'index'])->name('hero.index');
    Route::resource('/club', ClubCMSController::class);
    Route::resource('/program-kerja', ProgramKerjaController::class);
    Route::resource('/education', \App\Http\Controllers\CMSController\EducationController::class);
    Route::resource('/news-content', NewsContentController::class)
        ->parameters([
            'news-content' => 'news'
        ]);
    Route::resource('/west-java-videos', WestJavaVideoController::class);
    Route::resource('/sponsor', SponsorController::class);
    Route::resource('/kegiatan', KegiatanController::class);
    Route::get('/footer', [FooterContentController::class, 'index'])->name('footer.index');
    Route::put('/footer', [FooterContentController::class, 'update'])->name('footer.update');
    // Settings
    Route::get('/settings', [MutationSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [MutationSettingController::class, 'update'])->name('settings.update');

    // User management (superadmin only)
    Route::resource('/users', UserManagementController::class)->except(['show']);
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
});

Route::get('/run-migrations', function () {
    Artisan::call('migrate:fresh', ['--force' => true]);
    return 'Migrations completed successfully!';
});


require __DIR__.'/auth.php';
