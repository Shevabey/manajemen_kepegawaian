<?= $this->extend('layouts/main') ?>
<?= $this->section('content'); ?>

<div class="my-3 p-3 bg-body rounded shadow-sm">
    <div class="d-flex justify-content-between border-bottom py-2">
        <h3 class="pb-2 mb-0">Edit Data Pegawai</h3>
        <a href="/pegawai" class="btn btn-dark">Kembali</a>
    </div>
    <div class="pt-3">
        <form action="/pegawai/update/<?= $pegawai->id; ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="" class="form-label">Nama Pegawai:</label>
                <input type="text" class="form-control <?= session('errors')['nama_pegawai'] ?? false ? 'is-invalid' : '' ?>" name="nama_pegawai" name="nama_pegawai" value="<?= $pegawai->nama_pegawai ?>">
                <div class="invalid-feedback">
                    <?= session('errors')['nama_pegawai'] ?? '' ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Alamat Pegawai:</label>
                <input type="text" class="form-control <?= session('errors')['alamat'] ?? false ? 'is-invalid' : '' ?>" name="alamat" value="<?= $pegawai->alamat ?>">
                <div class="invalid-feedback">
                    <?= session('errors')['alamat'] ?? '' ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">No. Telepon:</label>
                <input type="text" class="form-control <?= session('errors')['telepon'] ?? false ? 'is-invalid' : '' ?>" name="telepon" value="<?= $pegawai->telepon ?>">
                <div class="invalid-feedback">
                    <?= session('errors')['telepon'] ?? '' ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Jabatan:</label>
                <select name="jabatan_id" id="" class="form-control">
                    <option value="">-- Pilih Jabatan --</option>
                    <?php foreach ($jabatan as $j) { ?>
                        <option value="<?= $j->id; ?>" <?= ($j->id == $pegawai->jabatan_id) ? 'selected' : '' ?>><?= $j->nama_jabatan; ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    <?= session('errors')['jabatan_id'] ?? '' ?>
                </div>
            </div>
            <div class="md-3">
                <label for="" class="form-label">Foto Pegawai</label>
                <?php if ($pegawai->foto_pegawai): ?>
                    <div class="mb-2">
                        <img src="<?= site_url() ?>uploads/<?= $pegawai->foto_pegawai ?>" alt="foto pegawai" class="img-thumbnail" width="90">
                    </div>
                <?php endif ?>
                <input type="file" name="file_foto" class="form-control <?= session('errors')['file_foto'] ?? false ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback">
                    <?= session('errors')['file_foto'] ?? '' ?>
                </div>
            </div>
            <input type="hidden" name="foto_lama" value="<?= $pegawai->foto_pegawai; ?>">
            <button type="submit" class="btn btn-dark">Update</button>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>