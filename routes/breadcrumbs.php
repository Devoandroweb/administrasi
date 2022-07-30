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
Breadcrumbs::for('pegawai', function (BreadcrumbTrail $trail) {
    $trail->push('Pegawai', url('pegawai'));
});
Breadcrumbs::for('edit_pegawai', function (BreadcrumbTrail $trail) {
    $trail->parent('pegawai');
    $trail->push('Kelola Pegawai', url('pegawai'));
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

