<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AlumnisController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CurriculumController;

// Guest authentication routes
Route::get('/login-web-great-crystal-school', [
    AuthenticatedSessionController::class,
    'create',
])->name('login');

Route::post('/login-post-web-great-crystal-school', [
    AuthenticatedSessionController::class,
    'store',
])->name('login.store');

// Logout
Route::post('/logout', [
    AuthenticatedSessionController::class,
    'destroy',
])->middleware('auth')->name('logout');

Route::get('/', function() {
    Return Inertia::render('Public/Home');
});
Route::get('/about', function() {
    Return Inertia::render('Public/About');
});
Route::get('/programs', function() {
    Return Inertia::render('Public/Program');
});
Route::get('/facility', function() {
    Return Inertia::render('Public/Facility');
});
Route::get('/curriculum', function() {
    Return Inertia::render('Public/Curriculum');
});
Route::get('/alumni', function() {
    Return Inertia::render('Public/Alumni');
});
Route::get('/history', function() {
    Return Inertia::render('Public/History');
});
Route::get('/achievements', function() {
    Return Inertia::render('Public/Achievement');
});
Route::get('/vision-mission', function() {
    Return Inertia::render('Public/VisiMisi');
});
Route::get('/news', function() {
    Return Inertia::render('Public/News');  
});
Route::get('/news/detail', function() {
    Return Inertia::render('Public/DetailNews');  
});
Route::get('/gallery', function() {
    Return Inertia::render('Public/Gallery');  
});
Route::get('/contact', function() {
    Return Inertia::render('Public/Contact');  
});
Route::get('/programs/preschool', function () {
    return Inertia::render('Public/Preschool');
})->name('programs.preschool');

Route::get('/programs/primary', function () {
    return Inertia::render('Public/Primary');
})->name('programs.primary');

Route::get('/programs/secondary', function () {
    return Inertia::render('Public/Secondary');
})->name('programs.secondary');

Route::prefix('/dashboard-web-great-crystal-school-2026')->middleware(['auth'])->group(function () {
    Route::get('/', function () { return Inertia::render('Public/Admin/Dashboard'); })->name('dashboard');
    Route::get('/admin/home/hero', [HomepageController::class, 'edit'])->name('admin.home.hero.edit');
    Route::post('/admin/home/hero/update', [HomepageController::class, 'update'])->name('admin.home.hero.update');
    Route::get('/admin/home/about', [HomepageController::class, 'editAbout'])->name('admin.home.about.edit');
    Route::post('/admin/home/about/update', [HomepageController::class, 'updateAbout'])->name('admin.home.about.update');
    Route::get('/admin/home/programs', [HomepageController::class, 'editPrograms'])->name('admin.home.programs.edit');
    Route::post('/admin/home/programs',[HomepageController::class, 'updatePrograms'])->name('admin.home.programs.update');
    Route::get('/admin/home/why-choose-us', [HomepageController::class, 'editWhyChoose'])->name('admin.home.why-choose.edit');
    Route::post('/admin/home/why-choose-us',[HomepageController::class, 'updateWhyChoose'])->name('admin.home.why-choose.update');
    Route::get('/admin/home/admission', [HomepageController::class, 'editAdmission'])->name('admin.home.admission.edit');
    Route::post('/admin/home/admission', [HomepageController::class, 'updateAdmission'])->name('admin.home.admission.update');
    Route::get('/admin/home/get-in-touch', [HomepageController::class, 'editGetInTouch'])->name('admin.home.get-in-touch.edit');
    Route::post('/admin/home/get-in-touch', [HomepageController::class, 'updateGetInTouch'])->name('admin.home.get-in-touch.update');
    Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::post('/posts/upload-image',[PostController::class, 'uploadImage'])->name('posts.upload-image');
        Route::resource('posts',PostController::class);
        Route::get('/edit-post-header',[PostController::class, 'editHero'])->name('edit.post.header');
        Route::post('/post-edit-header',[PostController::class, 'updateHero'])->name('post.edit.header');
    })
    ->group(function(){
        Route::resource('alumnis',AlumnisController::class);
        Route::get('/news/{slug}', [PostController::class, 'show'])->name('news.show');
        Route::resource('facilities',FacilityController::class);
        Route::get('/edit-facilities-header',[FacilityController::class, 'editHero'])->name('edit.facilities.header');
        Route::post('/post-facilities-header',[FacilityController::class, 'updateHero'])->name('facilities.edit.header');
        Route::resource('galleries',GalleryController::class);
        Route::get('/edit-galleries-header',[GalleryController::class, 'editHero'])->name('edit.galleries.header');
        Route::post('/post-galleries-header',[GalleryController::class, 'updateHero'])->name('galleries.edit.header');
        Route::resource('curriculum', CurriculumController::class);
        Route::get('/edit-curriculum-header',[CurriculumController::class, 'editHero'])->name('edit.curriculum.header');
        Route::post('/post-curriculum-header',[CurriculumController::class, 'updateHero'])->name('curriculum.edit.header');
    });
});


require __DIR__.'/auth.php';