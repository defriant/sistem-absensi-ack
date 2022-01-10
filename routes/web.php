<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WebController::class, 'index'])->name('index');
Route::post('login-attempt', [WebController::class, 'login_attempt']);

Route::middleware('auth')->group(function () {
    Route::get('logout', [WebController::class, 'logout']);
    Route::post('user/change-password', [WebController::class, 'change_password']);
    Route::post('user/profile/update', [WebController::class, 'profile_update']);
});

Route::middleware(['auth', 'adminRole'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard']);

    Route::get('admin/divisi', function () {
        return view('components.admin.divisi');
    });
    Route::get('admin/divisi/get', [AdminController::class, 'get_divisi']);
    Route::post('admin/divisi/add', [AdminController::class, 'add_divisi']);
    Route::post('admin/divisi/update', [AdminController::class, 'update_divisi']);
    Route::post('admin/divisi/delete', [AdminController::class, 'delete_divisi']);

    Route::get('admin/karyawan', [AdminController::class, 'karyawan']);
    Route::get('admin/karyawan/get', [AdminController::class, 'get_karyawan']);
    Route::post('admin/karyawan/add', [AdminController::class, 'add_karyawan']);
    Route::post('admin/karyawan/update', [AdminController::class, 'update_karyawan']);
    Route::post('admin/karyawan/delete', [AdminController::class, 'delete_karyawan']);

    Route::get('admin/absensi', [AdminController::class, 'absensi']);
    Route::post('admin/divisi/get', [AdminController::class, 'get_absensi']);
});


Route::middleware(['auth', 'karyawanRole'])->group(function () {
    Route::get('user/dashboard', [KaryawanController::class, 'user_dashboard']);
    Route::get('user/absensi/get', [KaryawanController::class, 'get_absensi']);
    Route::post('user/absensi/submit', [KaryawanController::class, 'submit_absensi']);

    Route::get('user/pengajuan', function () {
        return view('components.user.pengajuan');
    });
    Route::get('user/pengajuan/get', [KaryawanController::class, 'get_pengajuan']);
    Route::post('user/pengajuan/add', [KaryawanController::class, 'add_pengajuan']);
    Route::post('user/pengajuan/delete', [KaryawanController::class, 'delete_pengajuan']);
});
