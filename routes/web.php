<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ReportPhotoController as AdminReportPhotoController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Member\ReportController as MemberReportController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/direktori', [PublicController::class, 'directory'])->name('directory');
Route::get('/timeline', [PublicController::class, 'timeline'])->name('timeline');
Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/laporan/{report:slug}', [PublicController::class, 'reportDetail'])->name('reports.show');
Route::get('/profil/{member:slug}', [PublicController::class, 'profile'])->name('members.show');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('members/import/template', [AdminMemberController::class, 'downloadTemplate'])->name('members.import.template');
    Route::post('members/import', [AdminMemberController::class, 'import'])->name('members.import');
    Route::resource('members', AdminMemberController::class);
    Route::resource('reports', AdminReportController::class);
    Route::delete('reports/{report}/photos/{photo}', [AdminReportPhotoController::class, 'destroy'])->name('reports.photos.destroy');

    Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

/*
|--------------------------------------------------------------------------
| Member Area
|--------------------------------------------------------------------------
*/
Route::prefix('member')->name('member.')->middleware(['auth', 'role:member'])->group(function () {
    Route::get('/', [MemberDashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [MemberProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [MemberProfileController::class, 'update'])->name('profile.update');

    Route::resource('reports', MemberReportController::class)->except(['show']);
    Route::delete('reports/{report}/photos/{photo}', [MemberReportController::class, 'destroyPhoto'])->name('reports.photos.destroy');
});
