<?= $this->extend('layouts/main') ?>
<?= $this->section('content'); ?>

<?php if (session()->get('login')): ?>
    <div class="alert alert-success">
        Selamat Datang, <strong><?= session()->get('nama'); ?></strong>
    </div>
<?php endif; ?>
<div class="p-5 text-center bg-white rounded-3 shadow-sm">
    <h1 class="text-vbody-emphasis">Aplikasi CRUD Pegawai</h1>
    <p class="lead">Selamat datang di Aplikasi CRUD pegawai. aplikasi ini untuk mengelola data pegawai</p>
</div>

<?= $this->endSection(); ?>