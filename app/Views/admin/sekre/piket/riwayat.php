<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | Sekretariat | Piket | Riwayat
<?= $this->endSection() ?>

<?= $this->section("breadcrumb") ?>
<?= $breadcrumb ?>
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
        drawCallback: function() {
            feather.replace();
        }
    });

    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $(".select2-container").addClass("tx-12");
</script>

<?= $this->endSection() ?>