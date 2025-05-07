<?= $this->extend("layout/master-admin") ?>
<?php if(isset($data4, $breadcrumbs)): ?>

<?= $this->section("title") ?>
    Admin HMSI | Sekretariat | Piket | Riwayat
<?= $this->endSection() ?>

<?= $this->section("breadcrumbs") ?>
<?= $breadcrumbs ?>
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Riwayat Kehadiran Piket Ruang Kesekretariatan
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<div class="row mg-t-30">
    <div class="col-12">
        <table id="riwayat-piket" class="table table-hover">
            <thead>
            <tr class="tx-center">
                <th class="wd-5p">No</th>
                <th class="wd-30p">Hari / Tanggal</th>
                <th class="wd-20p">Waktu Mulai</th>
                <th class="wd-20p">Waktu Selesai</th>
                <th class="wd-25p">Jenis Piket</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data4 as $i=>$d): ?>
                <tr>
                    <td class="align-middle tx-center"><?= $i+1 ?></td>
                    <td class="align-middle tx-center">
                        <?= (new IntlDateFormatter("id_ID",IntlDateFormatter::FULL,IntlDateFormatter::SHORT,"Asia/Jakarta",IntlDateFormatter::GREGORIAN,"eeee, dd MMMM yyyy"))->format(new DateTime($d->waktu_datang)) ?>
                    </td>
                    <td class="align-middle tx-center">
                        <?= (new IntlDateFormatter("id_ID",IntlDateFormatter::FULL,IntlDateFormatter::SHORT,"Asia/Jakarta",IntlDateFormatter::GREGORIAN,"HH.mm.ss z'"))->format(new DateTime($d->waktu_datang)) ?>
                    </td>
                    <td class="align-middle tx-center">
                        <?= ($d->waktu_keluar !== null) ? (new IntlDateFormatter("id_ID",IntlDateFormatter::FULL,IntlDateFormatter::SHORT,"Asia/Jakarta",IntlDateFormatter::GREGORIAN,"HH.mm.ss z'"))->format(new DateTime($d->waktu_datang)) : "Tidak Terdata" ?>
                    </td>
                    <td class="align-middle tx-center"><?= ($d->status === '0') ? "Piket Wajib" : "Piket Tidak Wajib" ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#riwayat-piket').DataTable({
        <?= $this->include("layout/datatable.txt") ?>
    });
</script>

<?= $this->endSection() ?>

<?php endif; ?>