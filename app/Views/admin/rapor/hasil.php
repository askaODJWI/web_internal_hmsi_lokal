<?= $this->extend("layout/master-admin") ?>
<?php if(isset($data, $data2, $breadcrumbs)): ?>

<!-- <php if(isset($breadcrumbs)): ?> -->

<?= $this->section("title") ?>
Admin HMSI | Rapor | Hasil
<?= $this->endSection() ?>

<?= $this->section("breadcrumbs") ?>
<?= $breadcrumbs ?>
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Hasil Penilaian Rapor Fungsionaris
<?= $this->endSection() ?>

<?php if(session("id_pengurus") < 40000): ?>
<?= $this->section("tambah") ?>
<a href="<?= base_url("admin/rapor/dashboard") ?>" class="btn btn-secondary btn-sm"><i data-feather="arrow-left"></i> Kembali</a>
<?= $this->endSection() ?>
<?php endif; ?>

<?= $this->section("konten") ?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
    div.card.hasil {
        page-break-after:always;
    }
</style>

<?php $total = array_key_last($data); ?>
<?php for($i = 0 ; $i <= $total ; $i+=5): ?>
<div class="card bg-white hasil">
    <div class="card-body mg-t-30 mg-b-30">
        <div class="tx-center tx-24 tx-bold" style="font-family: 'Montserrat Alternates', sans-serif; color: #2C427A;">
            <u style="text-decoration-color: #359388; text-underline-offset: 5px;">RAPOR FUNGSIONARIS</u>
        </div>
        <div class="tx-center tx-14 mg-t-1" style="color: #2C427A;">
            Periode <?php switch($data[$i]->id_bulan){
                case(1): echo "Juni"; break;
                case(2): echo "Juli"; break;
                case(3): echo "Agustus"; break;}
            ?> 2024
        </div>

        <div class="mg-t-30"></div>

        <div class="tx-center tx-16" style="color: #2C427A;">diberikan kepada</div>
        <div class="tx-center tx-32 tx-bold" style="font-family: 'Montserrat Alternates', sans-serif; color: #359388;">
            <?= strtoupper($data[0]->nama) ?>
        </div>
        <div class="tx-center tx-16 tx-bold" style="color: #2C427A;"><?= $data[0]->jabatan . " " . $data[0]->nama_departemen ?></div>

        <div class="mg-t-30"></div>

        <div class="tx-center tx-16" style="color: #2C427A;">telah mendapatkan nilai sebesar</div>
        <?php
        $inisiatif = round(($data[$i]->nilai + $data[$i+1]->nilai) / 2, 2);
        $integritas = round(($data[$i+2]->nilai + $data[$i+3]->nilai + $data[$i+4]->nilai) / 3,2);
        $akhir = round((($inisiatif + $integritas) / 2), 2);
        ?>
        <div class="tx-center tx-50 tx-bold" style="font-family: 'Montserrat Alternates', sans-serif; color: #359388;">
            <?= $akhir ?>
        </div>

        <div class="mg-t-20"></div>

        <div class="tx-center tx-16" style="color: #2C427A;">dengan perincian sebagai berikut:</div>
        <div class="tx-12 mg-t-10">
            <table class="table table-bordered col-12 col-lg-9 ml-auto mr-auto" style="color: #359388;">
                <tr>
                    <td class="wd-10p tx-bold tx-center">Jenis</td>
                    <td class="wd-70p tx-bold tx-center">Indikator</td>
                    <td class="wd-10p tx-bold tx-center">Nilai</td>
                    <td class="wd-10p tx-bold tx-center">Rata-rata</td>
                </tr>
                <tr>
                    <td class="tx-bold align-middle tx-center" rowspan="2">Kekeluargaan</td>
                    <td class=""><?= $data[$i]->deskripsi ?></td>
                    <td class="tx-center align-middle"><?= $data[$i]->nilai ?></td>
                    <td class="tx-center align-middle" rowspan="2"><?= $inisiatif ?></td>
                </tr>
                <tr>
                    <td class=""><?= $data[$i+1]->deskripsi ?></td>
                    <td class="tx-center align-middle"><?= $data[$i+1]->nilai ?></td>
                </tr>
                <tr>
                    <td class="tx-bold align-middle tx-center" rowspan="3">Keprofesian</td>
                    <td class=""><?= $data[$i+2]->deskripsi ?></td>
                    <td class="tx-center align-middle"><?= $data[$i+2]->nilai ?></td>
                    <td class="tx-center align-middle" rowspan="3"><?= $integritas ?></td>
                </tr>
                <tr>
                    <td class=""><?= $data[$i+3]->deskripsi ?></td>
                    <td class="tx-center align-middle"><?= $data[$i+3]->nilai ?></td>
                </tr>
                <tr>
                    <td class=""><?= $data[$i+4]->deskripsi ?></td>
                    <td class="tx-center align-middle"><?= $data[$i+4]->nilai ?></td>
                </tr>
                <tr>
                    <td class="tx-right tx-bold" colspan="3">Nilai Akhir</td>
                    <td class="tx-center tx-bold align-middle"><?= $akhir ?></td>
                </tr>
            </table>
        </div>

        <div class="mg-t-50"></div>

        <div class="tx-center tx-12" style="color: #2C427A;">Catatan Kepala Departemen:</div>
        <div class="tx-center tx-12 col-12 col-lg-8 ml-auto mr-auto" style="color: #359388;">
            <?= $data2[$i / 5]->umpan_balik ?>
        </div>

        <div class="mg-t-50"></div>

        <div class="tx-center tx-14" style="color: #2C427A;">Ketua Himpunan Mahasiswa Sistem Informasi</div>
        <div class="tx-center" style="margin-top: -14px; margin-bottom: -10px;">
            <img src="<?= base_url("pic/ttd-ken.png") ?>" style="max-width:18%" alt="tanda tangan ketua hmsi">
        </div>
        <div class="tx-center tx-14 tx-bold" style="color: #2C427A;">Kentaro Mas'ud Mizoguchi</div>
        <div class="tx-center tx-14" style="color: #2C427A;">NRP. 5026211007</div>
    </div>
</div>
<div class="mg-t-50"></div>
<?php endfor; ?>

<?= $this->endSection() ?>

<?php endif; ?>