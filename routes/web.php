<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Vendor\VendorDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Admin Route
Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);
Route::get('admin/forgot-password', [AdminController::class, 'forgotPassword'])->name('admin.forgot_password');

//Admin Group Route
Route::group(['prefix'=>'admin', 'as'=>'admin.', 'middleware'=>['auth', 'role:admin']], function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AdminController::class, 'profileUpdate'])->name('profile_update');
    Route::get('/change-password', [AdminController::class, 'changePassword'])->name('change_password');
    Route::post('/password/update', [AdminController::class, 'updatePassword'])->name('update_password');

});

//Vendor Route
//Admin Route
Route::get('vendor/login', [VendorController::class, 'login'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);

//Vendor Group Route
Route::group(['prefix'=>'vendor', 'as'=>'vendor.', 'middleware'=>['auth', 'role:vendor']], function() {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [VendorController::class, 'logout'])->name('logout');
    Route::get('/profile', [VendorController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [VendorController::class, 'profileUpdate'])->name('profile_update');
    Route::get('/change-password', [VendorController::class, 'changePassword'])->name('change_password');
    Route::post('/password/update', [VendorController::class, 'updatePassword'])->name('update_password');
});
