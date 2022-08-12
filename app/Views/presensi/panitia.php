<?= $this->extend("layout/master-presensi") ?>

<?= $this->section("title") ?>
Kehadiran Acara HMSI
<?= $this->endSection() ?>

<?= $this->section("konten") ?>
<div class="card card-body shadow-none bd-primary animated fadeInDown">
    <div class="marker marker-ribbon marker-danger pos-absolute t-10 l-0">Hak Akses Panitia: <?= $data->kode_acara ?><br></div>
    <p class="mg-t-30">
        <span class="tx-gray-700">Kehadiran Acara oleh Panitia:</span><br><b><?= $data->nama_acara ?></b><br>
        <span class=""><?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%A, %d %B %Y",strtotime($data->tanggal)) .
                " pukul " . date_format(date_create($data->tanggal),"H.i") . " WIB"?></span>
    </p>
    <p>
        <span class="tx-gray-700">Penyelenggara:</span><br><b><?= $data->nama_departemen ?></b>
    </p>
</div>

<?php if(session()->has("error")): ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3 mb-3" role="alert">
        <?= session()->getFlashdata("error") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
<?php endif; ?>

<?php if(session()->has("berhasil")): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3 mb-3" role="alert">
        <?= session()->getFlashdata("berhasil") ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
<?php endif; ?>

<div class="form-group mt-3 animated zoomIn fast delay-1s">
    <label for="nrp" class="tx-bold">NRP <span class="tx-danger">*</span></label>
    <div class="input-group mg-b-10">
        <input id="nrp" name="nrp" type="text" class="form-control wd-200" placeholder="Masukkan NRP peserta">
        <div class="input-group-append">
            <button type="submit" id="cek" name="cek" class="btn btn-primary"><i data-feather="search"></i> Cek NRP</button>
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
        <form action="<?= base_url("/hadir_panitia") ?>" method="post">
            <input type="hidden" id="form_kode" name="form_kode" value="<?= $data->kode_acara ?>">
            <input type="hidden" id="form_nrp" name="form_nrp">
            <button type="submit" class="mt-2 btn btn-primary btn-block btn-xs"><i data-feather="check-circle"></i> Klik untuk Hadir</button>
        </form>
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
    $("#cek").click(function(e) {
        e.preventDefault();
        let div = $(".hasil_cek");
        let error = $(".hasil_error");
        let cek_nrp = $("#cek_nrp");
        let cek_prodi = $("#cek_prodi");
        let cek_nama = $("#cek_nama");
        let cek_angkatan = $("#cek_angkatan");
        let data_benar = $("#data_benar");
        let nrp_salah = $("#nrp_salah");
        let form_nrp = $("#form_nrp");
        let form2_nrp = $("#form2_nrp");
        let nrp = $("#nrp").val();

        div.hide();
        error.hide();

        if(nrp.length === 10 || nrp.length === 14)
        {
            cek_nrp.empty();
            cek_prodi.empty();
            cek_nama.empty();
            cek_angkatan.empty();
            nrp_salah.empty();
            data_benar.prop('checked',false);

            $.ajax(
                {
                    type: "GET",
                    url: "/ajax/cek_nrp/" + nrp,
                    dataType: "json",

                    success: function (data)
                    {
                        console.log(data);
                        cek_nrp.append(data.nrp);
                        cek_nama.append(data.nama);
                        cek_prodi.append(data.prodi);
                        cek_angkatan.append(data.angkatan);
                        form_nrp.prop('value',data.nrp);
                        div.show();
                        div.addClass('animated fadeInDown fast');
                    },
                    error: function ()
                    {
                        nrp_salah.append(nrp);
                        form2_nrp.prop('value',nrp);
                        error.show();
                        error.addClass('animated fadeInDown fast');
                    }
                });
        }
    });
</script>

<?= $this->endSection() ?>
