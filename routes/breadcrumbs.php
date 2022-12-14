<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// User
Breadcrumbs::for('user_management', function (BreadcrumbTrail $trail) {
    $trail->push('User', url('user'));
});
//Pegawai
Breadcrumbs::for('siswa', function (BreadcrumbTrail $trail) {
    $trail->push('Siswa', url('siswa'));
});
Breadcrumbs::for('edit_siswa', function (BreadcrumbTrail $trail) {
    $trail->parent('siswa');
    $trail->push('Kelola Siswa', url('siswa'));
});
Breadcrumbs::for('import_siswa', function (BreadcrumbTrail $trail) {
    $trail->parent('siswa');
    $trail->push('Import Siswa', url('siswa'));
});
Breadcrumbs::for('jenis_administrasi', function (BreadcrumbTrail $trail) {
    $trail->push('Jenis Administrasi', url('jenis-adminitrasi'));
});
Breadcrumbs::for('jurusan', function (BreadcrumbTrail $trail) {
    $trail->push('Jurusan', url('jurusan'));
});
Breadcrumbs::for('kelas', function (BreadcrumbTrail $trail) {
    $trail->push('Kelas', url('kelas'));
});
Breadcrumbs::for('ajaran', function (BreadcrumbTrail $trail) {
    $trail->push('Ajaran', url('ajaran'));
});

Breadcrumbs::for('administrasi_siswa', function (BreadcrumbTrail $trail) {
    $trail->push('Administrasi Siswa', url('administrasi-siswa'));
});
Breadcrumbs::for('administrasi_siswa_tunggakan', function (BreadcrumbTrail $trail) {
    $trail->parent('administrasi_siswa');
    $trail->push('Tunggakan Siswa', url('administrasi-siswa'));
});
Breadcrumbs::for('administrasi_siswa_cicilan', function (BreadcrumbTrail $trail) {
    $trail->parent('administrasi_siswa');
    $trail->push('Cicilan Pembayaran Siswa', url('administrasi-siswa'));
});
Breadcrumbs::for('pendanaan', function (BreadcrumbTrail $trail) {
    $trail->push('Pendanaan', url('pendanaan'));
});
Breadcrumbs::for('whatsapp', function (BreadcrumbTrail $trail) {
    $trail->push('Whatsapp Gateway', url('whatsapp'));
});
Breadcrumbs::for('htransaksi', function (BreadcrumbTrail $trail) {
    $trail->push('Riwayat Transaksi', url('htransaksi'));
});

