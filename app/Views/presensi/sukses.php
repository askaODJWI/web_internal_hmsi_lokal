<?= $this->extend("layout/master-presensi") ?>

<?= $this->section("title") ?>
Kehadiran Acara HMSI
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<div class="card card-body tx-white bd-success ht-100p overflow-hidden animated headShake">
    <div class="marker bg-success tx-white pos-absolute t-10 l-10">Registrasi Acara Telah Berhasil</div>
    <p class="mg-t-25">
        <span class="tx-gray-700">Kamu sedang menghadiri acara:</span>
        <br>
        <b class="tx-black"><?= $data->nama_acara ?></b><br>
    </p>
    <p>
        <span class="tx-gray-700">Penyelenggara:</span>
        <br>
        <b class="tx-black"><?= $data->nama_departemen ?></b>
    </p>
    <span class="tx-gray-700">Hasil Registrasi:</span>
    <table class="tx-black tx-bold">
        <tr>
            <td style="min-width: 50px">Nama</td>
            <td>:</td>
            <td><?= $data->nama ?></td>
        </tr>
        <tr>
            <td>NRP</td>
            <td>:</td>
            <td><?= $data->nrp ?></td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>:</td>
            <td><?= date_format(date_create($data->waktu),"H.i") . " WIB" ?></td>
        </tr>
    </table>
    <br>
    <p>
        <span class="tx-gray-700">Lokasi:</span>
        <br>
        <b class="tx-black animated flash delay-2s">
            <?php
            if(!filter_var($data->lokasi, FILTER_VALIDATE_URL) === false) {
                echo "<a href='$data->lokasi' target='_blank'><u>$data->lokasi</u>
                    <i data-feather='external-link' class='tx-gray-600' style='height: 10px'></i></a>"; }
            else { echo $data->lokasi; }
            ?>
        </b>
    </p>
    <span class="tx-gray-700">Narahubung: <span class="tx-bold"><?= $data->nama_panggilan ?></span></span>
    <table class="tx-black tx-bold">
        <tr>
            <td style="min-width: 50px">LINE</td>
            <td>:</td>
            <td>
                <a href="https://line.me/ti/p/~<?= $data->id_line ?>" target="_blank"><u><?= $data->id_line ?></u>
                    <i data-feather="external-link" class="tx-gray-600" style="height: 10px"></i></a>
            </td>
        </tr>
        <tr>
            <td>WhatsApp</td>
            <td>:</td>
            <td>
                <a href="https://wa.me/62<?= substr($data->no_wa,1) ?>" target="_blank"><u><?= $data->no_wa ?></u>
                    <i data-feather="external-link" class="tx-gray-600 tx-primary" style="height: 10px"></i></a>
            </td>
        </tr>
    </table>
</div>

<?= $this->endSection() ?>
