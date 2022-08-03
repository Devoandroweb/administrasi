<?php

use App\Http\Controllers\Administrasi\ASiswa;
use App\Http\Controllers\Administrasi\CPendanaan;
use App\Http\Controllers\Administrasi\Pemasukan;
use App\Http\Controllers\CAjaran;
use App\Http\Controllers\CDashboard;
use App\Http\Controllers\CDatatable;
use App\Http\Controllers\CJenisAdministrasi;
use App\Http\Controllers\CJurusan;
use App\Http\Controllers\CKelas;
use App\Http\Controllers\CLogin;
use App\Http\Controllers\CPembayaran;
use App\Http\Controllers\CSiswa;
use App\Http\Controllers\CUser;
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

Route::get('/admin',[CLogin::class,'admin'])->name('login')->middleware('guest');
Route::post('/auth',[CLogin::class, 'authAdmin']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CDashboard::class, 'index']);

    //resource
    Route::resource('/user', CUser::class)->except('credentials', 'check_username');
    Route::resource('/siswa', CSiswa::class);
    Route::resource('/jenis-administrasi', CJenisAdministrasi::class);
    Route::resource('/jurusan', CJurusan::class);
    Route::resource('/kelas', CKelas::class);
    Route::resource('/ajaran', CAjaran::class)->except('actifed_ajaran');

    //invoke
    Route::get('/administrasi-siswa', ASiswa::class);
    
    //custom funtion
    Route::get('/pendanaan', [CPendanaan::class, 'pendanaan']);
    Route::post('/pemasukan/save', [CPendanaan::class, 'pemasukan_save']);
    Route::post('/pengeluaran/save', [CPendanaan::class, 'pengeluaran_save']);

    Route::get('/pembayaran', [CPembayaran::class,'index']);
    Route::get('/pembayaran-cost-siswa/{id}', [CPembayaran::class, 'getBiayaSiswa']);
    Route::post('/pembayaran-save/{id}', [CPembayaran::class, 'save']);
    
    //another function
    Route::get('/user-checkusername', [CUser::class,'check_username']);
    Route::get('/aktif-ajaran/{id}', [CAjaran::class,'actifed_ajaran']);

    //datatable
    Route::get('/datatable/pegawai', [CDatatable::class,'pegawai']);
    Route::get('/datatable/user', [CDatatable::class,'user']);
    Route::get('/datatable/jenis-administrasi', [CDatatable::class, 'jenis_administrasi']);
    Route::get('/datatable/jurusan', [CDatatable::class, 'jurusan']);
    Route::get('/datatable/kelas', [CDatatable::class, 'kelas']);
    Route::get('/datatable/ajaran', [CDatatable::class, 'ajaran']);
    Route::get('/datatable/siswa', [CDatatable::class, 'siswa']);
    Route::get('/datatable/administrasi', [CDatatable::class, 'administrasi']);
    Route::get('/datatable/pendanaan', [CDatatable::class, 'pendanaan']);

    //signout
    Route:: get('/logout', [CLogin::class, 'logout'])->name('logout');
    
});
