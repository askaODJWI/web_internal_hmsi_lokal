<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | Hadir | Rekap Detail
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Rekap Kehadiran Acara
    <p class="tx-primary tx-bold tx-16"><?= $data1->nama_acara ?></p>
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<table id="rekap-detail" class="table table-hover">
    <thead>
    <tr class="tx-center">
        <th class="wd-5p">No</th>
        <th class="wd-15p">Waktu Kehadiran</th>
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
            <td class="align-middle tx-center"><?= $d->waktu ?></td>
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
    $('#rekap-detail').DataTable({
        lengthMenu: [
            [ 10, 25, 50, 100, 200, -1 ],
            [ 10, 25, 50, 100, 200, "Semua" ]
        ],
        dom: "Bfrtip",
        buttons: {
            buttons: [
                {
                    extend: "print",
                    text: "<i data-feather='printer'></i> Cetak Halaman Ini",
                    title: "",
                    messageTop: "<center><h4>Rekap Kehadiran Acara <?= $data1->nama_acara ?></h4></center><br>",
                    messageBottom:  "<br><center>Dokumen ini dicetak pada hari <b>" +
                        (new Date()).toLocaleString('id-ID',{dateStyle: 'full'}) + "</b> pukul <b>" +
                        (new Date()).toLocaleString('id-ID',{timeStyle: 'full'}) + "</b> oleh <b>" +
                        "<?= $data2->nama ?></b> NRP <b><?= $data2->nrp ?></b></center>",
                    autoPrint: false,
                    className: "btn btn-primary bg-primary",
                    customize: function (win) {
                        $(win.document.body).find("table")
                            .addClass("compact")
                            .css("font-size","10px");
                    },
                },
                {
                    extend: "pageLength",
                    className: "btn btn-outline-primary bg-white"
                },
            ],
        },
        language: {
            searchPlaceholder: "Cari...",
            search: "",
            buttons: {
                pageLength: {
                    _: "Tampilkan <b>%d</b> data per halaman",
                    '-1': "Tampilkan <b>semua</b> data dalam satu halaman"
                }
            },
            paginate: {
                next: "Berikutnya",
                previous: "Sebelumnya"
            },
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 data",
            infoFiltered: "(Disaring dari _MAX_ data)",
            emptyTable: "Tidak ada data yang ditemukan",
            zeroRecords: "Tidak ada data yang ditemukan",
        },
    });

    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
</script>

<?= $this->endSection() ?>