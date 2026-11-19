<?php

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\StudentAchievementController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\OurProgramController;
use App\Http\Controllers\HeaderPageSettingController;
use App\Http\Controllers\SchoolActivityController;
use App\Http\Controllers\Admin\SecondaryProgramController;
use App\Http\Controllers\PrimaryProgramController;
use App\Http\Controllers\Admin\PreschoolController;



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

Route::post('/admin/articles/upload-image', function (Request $request) {
    $request->validate([
        'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
    ]);

    $path = $request->file('image')->store('articles', 'public');

    return response()->json(['url' => Storage::disk('public')->url($path)]);
})->middleware('auth');

Route::prefix('/dashboard-web-great-crystal-school-Gre@tsch2026')->middleware(['auth'])->group(function () {
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
        Route::resource('achievements',StudentAchievementController::class);
        Route::get('/edit-achievements-header',[StudentAchievementController::class, 'editHero'])->name('edit.achievements.header');
        Route::post('/post-achievements-header',[StudentAchievementController::class, 'updateHero'])->name('achievements.edit.header');
        Route::resource('programs',ProgramsController::class);
        Route::get('/edit-programs-header',[ProgramsController::class, 'editHero'])->name('edit.programs.header');
        Route::post('/post-programs-header',[ProgramsController::class, 'updateHero'])->name('programs.edit.header');
        Route::resource('ourprograms', OurProgramController::class);
        Route::get('/edit-ourprograms-header',[OurProgramController::class, 'editHero'])->name('edit.ourprograms.header');
        Route::post('/post-ourprograms-header',[OurProgramController::class, 'updateHero'])->name('ourprograms.edit.header');
    })
     ->group(function () {
        Route::get(
            '/header-pages',
            [HeaderPageSettingController::class, 'index']
        )->name('header-pages.index');

        Route::get(
            '/header-pages/{headerPage}/edit',
            [HeaderPageSettingController::class, 'edit']
        )->name('header-pages.edit');

        Route::put(
            '/header-pages/{headerPage}',
            [HeaderPageSettingController::class, 'update']
        )->name('header-pages.update');

        Route::patch(
            '/header-pages/{headerPage}/toggle-status',
            [HeaderPageSettingController::class, 'toggleStatus']
        )->name('header-pages.toggle-status');
        Route::resource('school-activities', SchoolActivityController::class)
            ->parameters([
            'school-activities' => 'school_activity',
        ]);
        Route::get('/secondary-program', [SecondaryProgramController::class, 'index'])->name('secondary-program.index');
        Route::get('/secondary-program', [SecondaryProgramController::class, 'index'])->name('secondary-program.index');
        // Manage About Secondary
        Route::get('/secondary-program/about', [SecondaryProgramController::class, 'editAbout'])->name('secondary-program.about.edit');
        Route::put('/secondary-program/about', [SecondaryProgramController::class, 'updateAbout'])->name('secondary-program.about.update');
        // Manage Curriculum
        Route::get('/secondary-program/curriculum', [SecondaryProgramController::class, 'editCurriculum'])->name('secondary-program.curriculum.edit');
        Route::put('/secondary-program/curriculum', [SecondaryProgramController::class, 'updateCurriculum'])->name('secondary-program.curriculum.update');
        // Manage Learning Outcomes
        Route::get('/secondary-program/learning-outcomes', [SecondaryProgramController::class,'editOutcomes'])->name('secondary-program.outcomes.edit');
        Route::put('/secondary-program/learning-outcomes', [SecondaryProgramController::class,'updateOutcomes'])->name('secondary-program.outcomes.update');
        Route::get('/secondary-program/extracurriculars', [SecondaryProgramController::class,'editExtracurriculars'])->name('secondary-program.extracurriculars.edit');
        Route::put('/secondary-program/extracurriculars', [SecondaryProgramController::class,'updateExtracurriculars'])->name('secondary-program.extracurriculars.update');
        // PRIMARY PROGRAM
        Route::get('/primary-program', [PrimaryProgramController::class, 'index'])->name('primary-program.index');
        // PRIMARY PROGRAM - ABOUT
        Route::get('/primary-program/about', [PrimaryProgramController::class,'editAbout'])->name('primary-program.about.edit');
        Route::put('/primary-program/about', [PrimaryProgramController::class,'updateAbout'])->name('primary-program.about.update');
        // PRIMARY PROGRAM - LEVELS
        Route::get('/primary-program/levels', [PrimaryProgramController::class,'editLevels'])->name('primary-program.levels.edit');
        Route::put('/primary-program/levels', [PrimaryProgramController::class,'updateLevels'])->name('primary-program.levels.update');
        // PRIMARY PROGRAM - CURRICULUM
        Route::get('/primary-program/curriculum', [PrimaryProgramController::class,'editCurriculum'])->name('primary-program.curriculum.edit');
        Route::put('/primary-program/curriculum', [PrimaryProgramController::class,'updateCurriculum'])->name('primary-program.curriculum.update');
        // PRIMARY PROGRAM - EXTRACURRICULAR
        Route::get('/primary-program/extracurricular', [PrimaryProgramController::class,'editExtracurricular'])->name('primary-program.extracurricular.edit');
        Route::put('/primary-program/extracurricular', [PrimaryProgramController::class,'updateExtracurricular'])->name('primary-program.extracurricular.update');
        // PRESCHOOL
        Route::get('/preschool', [PreschoolController::class,'index'])->name('preschool.index');
        Route::get('/preschool/about', [PreschoolController::class,'editAbout'])->name('preschool.about.edit');
        Route::get('/preschool/classes', [PreschoolController::class,'editClasses'])->name('preschool.classes.edit');
        Route::put('/preschool/about', [PreschoolController::class,'updateAbout'])->name('preschool.about.update');
        Route::put('/preschool/classes', [PreschoolController::class,'updateClasses'])->name('preschool.classes.update');
    });
});