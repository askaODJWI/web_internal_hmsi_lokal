<?= $this->extend("layout/master-admin") ?>
<?php if(isset($data, $breadcrumbs)): ?>
<?= $this->section("title") ?>
Admin HMSI | Rapor | Isi
<?= $this->endSection() ?>

<?= $this->section("breadcrumbs") ?>
<?= $breadcrumbs ?>
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Isi Nilai Rapor Fungsionaris
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<table id="daftar-isi-rapor" class="table table-hover">
    <thead>
    <tr class="tx-center">
        <th class="wd-5p">No.</th>
        <th class="wd-30p">Nama</th>
        <th class="wd-30p">Departemen</th>
        <th class="wd-5p">Juni</th>
        <th class="wd-5p">Juli</th>
        <th class="wd-5p">Agustus</th>
        <th class="wd-20p">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php $total = array_key_last($data); ?>
    <?php for($i = 0 ; $i <= $total ; $i+=15): ?>
        <tr>
            <td class="align-middle tx-center"><?= $i / 15 + 1 ?></td>
            <td class="align-middle"><?= $data[$i]->nama ?></td>
            <td class="align-middle"><?= $data[$i]->nama_departemen ?></td>
            <td class="align-middle tx-center">
                <?= ($data[$i]->nilai === "0" || $data[$i+1]->nilai === "0" || $data[$i+2]->nilai === "0" || $data[$i+3]->nilai === "0" || $data[$i+4]->nilai === "0") ?
                    "❌" : "✅" ?><br>
            </td>
            <td class="align-middle tx-center">
                <?= ($data[$i+5]->nilai === "0" || $data[$i+6]->nilai === "0" || $data[$i+7]->nilai === "0" || $data[$i+8]->nilai === "0" || $data[$i+9]->nilai === "0") ?
                    "❌" : "✅" ?><br>
            </td>
            <td class="align-middle tx-center">
                <?= ($data[$i+10]->nilai === "0" || $data[$i+11]->nilai === "0" || $data[$i+12]->nilai === "0" || $data[$i+13]->nilai === "0" || $data[$i+14]->nilai === "0") ?
                    "❌" : "✅" ?><br>
            </td>
            <td class="align-middle tx-center">
                <a href="<?= base_url("admin/rapor/isi/detail") . "/" . $data[$i]->id_pengurus ?>"
                   class="btn btn-primary btn-xs"><i data-feather="edit-2"></i> Isi Penilaian</a>
            </td>
        </tr>
    <?php endfor; ?>
    </tbody>
</table>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#daftar-isi-rapor').DataTable({
        <?= $this->include("layout/datatable.txt") ?>
    });
</script>

<?= $this->endSection() ?>

<?php endif; ?>