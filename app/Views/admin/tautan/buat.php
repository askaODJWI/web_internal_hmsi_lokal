<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | Tautan | Buat
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Buat Peringkas Tautan Baru
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<form action="<?= base_url("admin/tautan/buat") ?>" method="post" data-parsley-validate>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="panjang" class="tx-bold">Tautan Asli <span class="tx-danger">*</span></label>
                <input id="panjang" name="panjang" type="text" class="form-control" placeholder="Masukkan tautan asli" required data-parsley-required-message="Tautan asli wajib diisi!">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="pendek" class="tx-bold">Tautan Pendek <span class="tx-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">hmsi.tekan.id/</span>
                    </div>
                    <input id="pendek" name="pendek" type="text" class="form-control" placeholder="Masukkan tautan pendek" required data-parsley-required-message="Tautan pendek wajib diisi!">
                </div>
            </div>
        </div>
        <div class="col-lg-2 mt-auto">
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary btn-icon">
                    <i data-feather="save"></i> <span>Simpan</span>
                </button>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
