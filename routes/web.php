<?php

use App\Http\Controllers\DaftarJemaatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\JadwalIbadahAudioVisualController;
use App\Http\Controllers\JadwalIbadahController;
use App\Http\Controllers\JadwalIbadahPemusikController;
use App\Http\Controllers\JadwalIbadahPengajaranController;
use App\Http\Controllers\JadwalIbadahsController;
use App\Http\Controllers\JadwalIbadahUsherController;
use App\Http\Controllers\JadwalPengajaranController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UpdateProfileController;
use App\Http\Controllers\UsherController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
Route::redirect('/', '/login');
Route::get('/dashboard/jemaat', [DashboardController::class, 'index'])->name('jemaat')->middleware('is_admin');
Route::get('/dashboard/usher', [DashboardController::class, 'usher'])->name('usher')->middleware('is_admin');
Route::get('/dashboard/avl', [DashboardController::class, 'avl'])->name('avl')->middleware('is_admin');
Route::get('/dashboard/pemusik', [DashboardController::class, 'pemusik'])->name('pemusik')->middleware('is_admin');

Route::get('/daftar-jemaat', [DaftarJemaatController::class, 'index'])->name('daftar-jemaat')->middleware('is_admin');
Route::get('/jadwal-ibadah', [JadwalIbadahController::class, 'index'])->name('jadwal-ibadah')->middleware('auth');
Route::get('/jadwal-ibadah/jemaat/{id}', [JadwalIbadahController::class, 'getJemaat'])->middleware('is_admin');
Route::get('/jadwal-ibadah/create', [JadwalIbadahController::class, 'create'])->name('jadwal-ibadah.create')->middleware('is_admin');
Route::post('/jadwal-ibadah/create', [JadwalIbadahController::class, 'store'])->name('jadwal-ibadah.store')->middleware('is_admin');
Route::get('/jadwal-ibadah/edit/{id}', [JadwalIbadahController::class, 'edit'])->name('jadwal-ibadah.edit')->middleware('is_admin');
Route::put('/jadwal-ibadah/update/{id}', [JadwalIbadahController::class, 'update'])->name('jadwal-ibadah.update')->middleware('is_admin');
Route::get('/profile', [UpdateProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::put('/profile/update-profile', [UpdateProfileController::class, 'updateprofile'])->middleware('auth');
Route::get('/jadwal-pengajaran/create', [JadwalPengajaranController::class, 'create'])->name('jadwal-pengajaran.create')->middleware('is_admin');
Route::get('/get-ibadah-schedule/{id}', [JadwalPengajaranController::class, 'getIbadahSchedule'])->middleware('is_admin');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::post('/ibadah/signup/{ibadahId}', [JadwalIbadahController::class, 'signup'])->name('ibadah.signup')->middleware('auth');

Route::resource('/ibadah/delete/ibadah', JadwalIbadahsController::class)->middleware('is_admin');
Route::resource('/ibadah/delete/ushers', JadwalIbadahUsherController::class)->middleware('is_admin');
Route::resource('/ibadah/delete/pemusiks', JadwalIbadahPemusikController::class)->middleware('is_admin');
Route::resource('/ibadah/delete/avls', JadwalIbadahAudioVisualController::class)->middleware('is_admin');
Route::resource('/pengajaran/delete/pengajaran', JadwalIbadahPengajaranController::class)->middleware('is_admin');

Route::get('/jadwal-ibadah/edit/ushers/{id}', [JadwalIbadahController::class, 'editUshers'])->name('jadwal-ibadah.edit-ushers')->middleware('is_admin');
Route::get('/jadwal-ibadah/edit/pemusiks/{id}', [JadwalIbadahController::class, 'editPemusiks'])->name('jadwal-ibadah.edit-pemusiks')->middleware('is_admin');
Route::get('/jadwal-ibadah/edit/avls/{id}', [JadwalIbadahController::class, 'editAudioVisuals'])->name('jadwal-ibadah.edit-audiovisuals')->middleware('is_admin');
Route::get('jadwal-ibadah/edit/pengajarans/{id}', [JadwalIbadahController::class, 'editPengajarans'])->name('jadwal-ibadah.edit-pengajarans')->middleware('is_admin');

Route::post('/ibadah/add/ushers/{id}', [JadwalIbadahController::class, 'addIbadahUshers'])->name('ibadah.add-ushers')->middleware('is_admin');
Route::post('/ibadah/add/pemusiks/{id}', [JadwalIbadahController::class, 'addIbadahPemusiks'])->name('ibadah.add-pemusiks')->middleware('is_admin');
Route::post('/ibadah/add/avls/{id}', [JadwalIbadahController::class, 'addIbadahAudioVisuals'])->name('ibadah.add-audiovisuals')->middleware('is_admin');
Route::post('ibadah/add/pengajarans/{id}', [JadwalIbadahController::class, 'addIbadahPengajarans'])->name('ibadah.add-pengajarans')->middleware('is_admin');

Route::get('/jadwal-pengajaran', [JadwalPengajaranController::class, 'index'])->name('jadwal-pengajaran')->middleware('auth');
Route::post('/jadwal-pengajaran/create', [JadwalPengajaranController::class, 'store'])->name('jadwal-pengajaran.store')->middleware('is_admin');
Route::get('/jadwal-pengajaran/edit/{id}', [JadwalPengajaranController::class, 'edit'])->name('jadwal-pengajaran.edit')->middleware('is_admin');
Route::put('/jadwal-pengajaran/update/{id}', [JadwalPengajaranController::class, 'update'])->name('jadwal-pengajaran.update')->middleware('is_admin');

Route::get('/finance', [FinanceController::class, 'index'])->name('finance')->middleware('is_admin');
Route::get('/finance/create', [FinanceController::class, 'create'])->name('finance.create')->middleware('is_admin');
Route::post('/finance/create', [FinanceController::class, 'store'])->name('finance.store')->middleware('is_admin');
Route::get('/finance/edit/{id}', [FinanceController::class, 'edit'])->name('finance.edit')->middleware('is_admin');
Route::put('/finance/update/{id}', [FinanceController::class, 'update'])->name('finance.update')->middleware('is_admin');
Route::delete('/finance/delete/{id}', [FinanceController::class, 'destroy'])->name('finance.destroy')->middleware('is_admin');

Route::get('/jadwal-ibadah/export', [JadwalIbadahController::class, 'export'])->name('jadwal-ibadah.export');
Route::get('/jadwal-ibadah/export/{id}', [JadwalIbadahController::class, 'exportDetail'])->name('jadwal-ibadah.export-detail')->middleware('is_admin');
Route::get('/finance/export', [FinanceController::class, 'export'])->name('finance.export')->middleware('is_admin');