<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | Hadir | Rekap
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Rekap Kehadiran Acara
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<table id="rekap-acara" class="table table-hover">
    <thead>
    <tr class="tx-center">
        <th>No.</th>
        <th class="wd-10p">Kode</th>
        <th class="wd-20p">Nama</th>
        <th class="wd-15p">Tanggal</th>
        <th class="wd-20p">Pembuat / Pengubah</th>
        <th class="wd-15p">Jumlah Peserta</th>
        <th class="wd-20p">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $i=>$d): ?>
        <tr>
            <td class="align-middle tx-center"><?= $i+1 ?></td>
            <td class="align-middle tx-center tx-bold"><?= $d->kode_acara ?></td>
            <td class="align-middle"><?= $d->nama_acara ?></td>
            <td class="align-middle"><?= (new IntlDateFormatter("id_ID",IntlDateFormatter::FULL,IntlDateFormatter::SHORT,"Asia/Jakarta",IntlDateFormatter::GREGORIAN,"eeee, dd MMMM yyyy 'pukul' HH.mm z'"))->format(new DateTime($d->tanggal)) ?></td>
            <td class="align-middle">
                <?= $d->nama . "<br><i>" . $d->jabatan . " " . $d->nama_departemen . "</i>" ?><br>
            </td>
            <td class="align-middle"><?= $d->peserta ?> Orang</td>
            <td class="align-middle tx-center">
                <form action="<?= base_url("admin/hadir/rekap/detail") ?>" method="post">
                    <input type="hidden" name="kode_acara" id="kode_acara" value="<?= $d->kode_acara ?>">
                    <button type="submit" class="btn btn-primary btn-xs"><i data-feather="file-text"></i> Lihat Rekap Kehadiran</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#rekap-acara').DataTable({
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
