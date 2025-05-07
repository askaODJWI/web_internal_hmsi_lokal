<?= $this->extend("layout/master-admin") ?>
<?php if(isset($data, $data2, $breadcrumbs)): ?>

<?= $this->section("title") ?>
    Admin HMSI | Survei | Dashboard
<?= $this->endSection() ?>

<?= $this->section("breadcrumbs") ?>
<?= $breadcrumbs ?>
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Daftar Survei
<?= $this->endSection() ?>

<?= $this->section("tambah") ?>
<a href="<?= base_url("admin/survei/tambah") ?>" class="btn btn-primary btn-sm"><i data-feather="plus"></i> Buat Survei Baru</a>
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<table id="daftar-survei" class="table table-hover">
    <thead>
    <tr class="tx-center">
        <th class="wd-5p">No.</th>
        <th class="wd-10p">Kode</th>
        <th class="wd-35p">Nama Survei</th>
        <th class="wd-30p">Pembuat</th>
        <th class="wd-20p">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $i=>$d): ?>
    <tr>
        <td class="align-middle tx-center"><?= $i+1 ?></td>
        <td class="align-middle tx-center tx-bold"><?= $d->id_survei ?></td>
        <td class="align-middle"><?= $d->nama_survei ?></td>
        <td class="align-middle">
            <?= "<b>" . $d->nama . "</b><br>" . $d->jabatan . "<br>" . $d->nama_departemen ?>
        </td>
        <td class="align-middle tx-center">
            <?php
            $id_pengurus = str_replace("id-pengurus",session()->get("id_pengurus"),$d->tautan);
            $nrp = str_replace("nrp",$data2->nrp,$id_pengurus);
            $id_survei = str_replace("id-survei",$d->id_survei,$nrp);

            if($d->cek === '0'): ?>
                <a href="<?= $id_survei ?>" class="btn btn-success btn-xs btn-block">
                    <i data-feather="edit-2"></i> Mulai Isi Survei
                </a>
            <?php else: ?>
                <a href="#" class="btn btn-secondary btn-xs btn-block">
                    <i data-feather="x-octagon"></i> Survei Telah Diisi
                </a>
            <?php endif; ?>

            <?php
            $id = $d->id_survei;
            if($d->id_departemen === $data2->id_departemen || session()->get("id_pengurus") < 20000):
            ?>
                <a href="<?= base_url("s/$d->id_survei") ?>" class="btn btn-light btn-xs btn-block" target="_blank">
                    <i data-feather="link"></i> Salin Tautan Survei
                </a>
                <a href="<?= base_url("admin/survei/detail/$id") ?>" class="btn btn-primary btn-xs btn-block">
                    <i data-feather="pie-chart"></i> Rekap Pengisian</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#daftar-survei').DataTable({
        <?= $this->include("layout/datatable.txt") ?>
    });
</script>

<?= $this->endSection() ?>

<?php endif; ?>