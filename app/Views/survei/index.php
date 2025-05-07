<?= $this->extend("layout/master-survei") ?>
<?php if(isset($data)): ?>

<?= $this->section("title") ?>
Pengisian Survei HMSI
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<div class="card card-body shadow-none bd-primary animated fadeInDown">
    <div class="marker marker-ribbon marker-primary pos-absolute t-10 l-0">Kode Survei: <?= $data->id_survei ?><br></div>
    <p class="mg-t-30">
        <span class="tx-gray-700">Kamu akan mengisi:</span><br><b><?= $data->nama_survei ?></b><br>
    </p>
    <p>
        <span class="tx-gray-700">Penyelenggara:</span><br><b><?= $data->nama_departemen ?></b>
    </p>
</div>

<?php if(session()->has("error")): ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3 animated zoomIn fast delay-1s" role="alert">
        <?= session()->getFlashdata("error") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
<?php endif; ?>

<div class="form-group mt-3 animated zoomIn fast delay-1s">
    <label for="nrp" class="tx-bold">NRP <span class="tx-danger">*</span></label>
    <div class="input-group mg-b-10">
        <input id="nrp" name="nrp" type="text" class="form-control wd-200" placeholder="Masukkan NRP kamu">
        <div class="input-group-append">
            <button type="submit" id="cek" name="cek" class="btn btn-primary"><i data-feather="search"></i> Cari</button>
        </div>
    </div>
</div>

<div class="mt-3 hasil_cek" style="display: none">
    <div class="card card-body tx-white bg-success ht-100p overflow-hidden">
        <div class="marker pos-absolute t-10 l-10">Hasil Pencarian: <span class="tx-primary" id="cek_nrp"></span></div>
        <table class="mg-t-25">
            <tr>
                <td style="min-width: 50px">Nama</td>
                <td>:</td>
                <td class="tx-bold" id="cek_nama"></td>
            </tr>
            <tr>
                <td>Prodi</td>
                <td>:</td>
                <td class="tx-bold" id="cek_prodi"></td>
            </tr>
            <tr>
                <td>Angkatan</td>
                <td>:</td>
                <td class="tx-bold" id="cek_angkatan"></td>
            </tr>
        </table>
        <a class="mt-2 btn btn-primary btn-block btn-xs" id="ambil_link"><i data-feather="edit-2"></i> Mulai Pengisian Survei</a>
    </div>
</div>

<div class="mt-3 hasil_error" style="display: none">
    <div class="card card-body tx-white bg-danger ht-100p overflow-hidden">
        <div class="marker pos-absolute  t-10 l-10">Hasil Pencarian: <span class="tx-primary" id="nrp_salah"></span></div>
        <span class="mg-t-25">Maaf, data yang kamu masukkan <b>tidak terdaftar</b> di sistem kami.
        Pastikan NRP sudah benar.</span>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    <?= $this->include("layout/mahasiswa.js") ?>

    $("#ambil_link").click(function(e) {
        e.preventDefault();
        let nrp = $("#nrp").val();
        let alamat = window.location.pathname;
        let id_survei = alamat.toString().replace("/s/","");
        let tautan = "<?= $data->tautan ?>";

        window.location = tautan.replace("nrp", nrp).replace("id-pengurus", 0).replace("id-survei", id_survei);
    });
</script>

<?= $this->endSection() ?>

<?php else: ?>

<?= $this->section("konten") ?>
Mohon maaf, halaman ini sedang error. Hubungi Pengembang via LINE: hendry.naufal atau WhatsApp: 0853-3130-3015 (hendry). Terima kasih.
<?= $this->endSection() ?>

<?php endif; ?>