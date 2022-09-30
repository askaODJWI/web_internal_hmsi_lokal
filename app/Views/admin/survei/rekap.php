<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | Survei | Rekap Pengisian
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Rekap Pengisian Survei
    <p class="tx-primary tx-bold tx-16"><?= $data1->nama_survei ?></p>
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
                <td class="align-middle"><?= $d->jabatan ?? "Bukan Fungsionaris" ?></td>
                <td class="align-middle"><?= $d->nama_departemen ?? "Bukan Fungsionaris" ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

    <script>
        $('#rekap').DataTable({
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