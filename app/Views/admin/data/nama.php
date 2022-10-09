<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
Admin HMSI | Data | Nama
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Cari Data Mahasiswa

<?php if(service("request")->getMethod() === "post"): ?>
<span class="text-primary">: <?= $data2 ?></span>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section("konten") ?>
<table id="daftar-nrp" class="table table-hover">
    <thead>
    <tr class="tx-center tx-bold">
        <th class="wd-5p">No.</th>
        <th class="wd-35p">Nama</th>
        <th class="wd-15p">NRP</th>
        <th class="wd-10p">Angkatan</th>
        <th class="wd-35p">Program Studi</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $i=>$d): ?>
        <tr>
            <td class="align-middle tx-center tx-bold"><?= $i+1 ?></td>
            <td class="align-middle"><?= $d->nama ?></td>
            <td class="align-middle"><?= $d->nrp ?></td>
            <td class="align-middle tx-center"><?= $d->angkatan ?></td>
            <td class="align-middle"><?= $d->prodi ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#daftar-nrp').DataTable({
        lengthMenu: [
            [ 10, 25, 50, 100, 200, -1 ],
            [ 10, 25, 50, 100, 200, "Semua" ]
        ],
        language: {
            searchPlaceholder: "Cari...",
            search: "",
            lengthMenu: "Lihat _MENU_ data per halaman",
            paginate: {
                next: "Berikutnya",
                previous: "Sebelumnya"
            },
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 data",
            infoFiltered: "(Disaring dari _MAX_ data)",
            emptyTable: "Tidak ada data yang ditemukan",
            zeroRecords:  "Tidak ada data yang ditemukan",
        },
    });

    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $(".select2-container").addClass("tx-12");
</script>

<?= $this->endSection() ?>
