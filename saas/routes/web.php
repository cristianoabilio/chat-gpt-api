<?php

use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;

Route::get('/', function () {
    return view('welcome');
});


/// User Routes
Route::middleware(['auth', IsUser::class])->group(function () {

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

});
/// Eend User Routes


/// Admin Routes
Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {

Route::get('/dashboard', function () {
    return view('admin.index');
})->name('admin.dashboard');

Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
Route::get('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.change.password');
Route::post('/admin/profile/update', [AdminController::class, 'profileUpdate'])->name('admin.profile.update');
Route::post('/admin/password/update', [AdminController::class, 'passwordUpdate'])->name('admin.password.update');

});
/// Eend User Routes


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
