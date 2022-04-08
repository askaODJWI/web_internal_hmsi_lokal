<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | Hadir | Dashboard
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Daftar Pranala Kehadiran Acara
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<table id="daftar-link-acara" class="table table-hover">
    <thead>
    <tr class="tx-center">
        <th class="wd-10p">Kode</th>
        <th class="wd-15p">Nama</th>
        <th class="wd-15p">Tanggal</th>
        <th class="wd-15p">Lokasi</th>
        <th class="wd-20p">Pembuat / Pengubah</th>
        <th class="wd-25p">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $d): ?>
    <tr>
        <td class="align-middle tx-center tx-bold"><?= $d->kode_acara ?></td>
        <td class="align-middle"><?= $d->nama_acara ?></td>
        <td class="align-middle"><?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%A, %d %B %Y",strtotime($d->tanggal)) .
                "<br>pukul " . date_format(date_create($d->tanggal),"H.i") . " WIB"?></td>
        <td class="align-middle"><?= (strlen($d->lokasi) <= 25) ? $d->lokasi : substr($d->lokasi,0,25) . " ..." ?></td>
        <td class="align-middle">
            <?= $d->nama . "<br><i>" . $d->jabatan . " " . $d->nama_departemen . "</i>" ?><br>
        </td>
        <td class="align-middle tx-center">
            <a href="<?= base_url("/$d->kode_acara") ?>" class="btn btn-primary btn-xs" target="_blank">
                <i data-feather="link-2"></i> Salin</a>
            <a href="<?= base_url("admin/hadir/ubah/$d->kode_acara") ?>" class="btn btn-warning btn-xs">
                <i data-feather="edit-2"></i> Ubah</a>
            <a onclick="deleteConfirm('<?= base_url('admin/hadir/hapus/'.$d->kode_acara) ?>')" href="#"
               class="btn btn-danger btn-xs"><i data-feather="trash-2"></i> Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#daftar-link-acara').DataTable({
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
