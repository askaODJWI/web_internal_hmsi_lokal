<?= $this->extend("layout/master-admin") ?>
<?php if(isset($data, $data1, $breadcrumbs)): ?>

<?= $this->section("title") ?>
    Admin HMSI | Survei | Rekap Pengisian
<?= $this->endSection() ?>

<?= $this->section("breadcrumbs") ?>
<?= $breadcrumbs ?>
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Rekap Pengisian Survei
    <p class="tx-primary tx-bold tx-16"><?= $data1->nama_survei ?></p>
<?= $this->endSection() ?>

<?= $this->section("tambah") ?>
    <a href="<?= base_url("admin/survei/dashboard") ?>" class="btn btn-secondary btn-sm"><i data-feather="arrow-left"></i> Kembali</a>
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

    <table id="rekap" class="table table-hover">
        <thead>
        <tr class="tx-center">
            <th class="wd-5p">No</th>
            <th class="wd-25p">Nama Lengkap</th>
            <th class="wd-10p">NRP</th>
            <th class="wd-10p">Angkatan</th>
            <th class="wd-15p">Jabatan</th>
            <th class="wd-15p">Departemen</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $i=>$d): ?>
            <tr>
                <td class="align-middle tx-center"><?= $i+1 ?></td>
                <td class="align-middle"><?= $d->nama ?></td>
                <td class="align-middle"><?= $d->nrp ?></td>
                <td class="align-middle tx-center"><?= "20".substr($d->nrp,4,2) ?></td>
                <td class="align-middle"><?= $d->jabatan ?? "-" ?></td>
                <td class="align-middle"><?= $d->nama_departemen ?? "-" ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#rekap').DataTable({
        <?= $this->include("layout/datatable.txt") ?>
    });
</script>

<?= $this->endSection() ?>

<?php endif; ?>