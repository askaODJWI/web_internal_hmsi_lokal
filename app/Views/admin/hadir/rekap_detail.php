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
    <?php if(!filter_var($data1->lokasi, FILTER_VALIDATE_URL) === false): ?>
        <tr class="tx-center">
            <th class="wd-5p">No</th>
            <th class="wd-15p">Waktu Kehadiran</th>
            <th class="wd-25p">Nama Lengkap</th>
            <th class="wd-10p">NRP</th>
            <th class="wd-5p">Angkatan</th>
            <th class="wd-25p">Departemen</th>
            <th class="wd-10p">Keterangan</th>
        </tr>
    <?php else: ?>
        <tr class="tx-center">
            <th class="wd-5p">No</th>
            <th class="wd-15p">Waktu Kehadiran</th>
            <th class="wd-25p">Nama Lengkap</th>
            <th class="wd-10p">NRP</th>
            <th class="wd-10p">Angkatan</th>
            <th class="wd-30p">Departemen</th>
        </tr>
    <?php endif; ?>
    </thead>
    <tbody>
    <?php foreach ($data as $i=>$d): ?>
        <tr>
            <td class="align-middle tx-center"><?= $i+1 ?></td>
            <td class="align-middle tx-center"><?= $d->waktu ?></td>
            <td class="align-middle"><?= $d->nama ?></td>
            <td class="align-middle"><?= $d->nrp ?></td>
            <td class="align-middle tx-center"><?= "20".substr($d->nrp,4,2) ?></td>
            <td class="align-middle"><?= $d->nama_departemen ?? "-" ?></td>
            <?php if(!filter_var($data1->lokasi, FILTER_VALIDATE_URL) === false): ?>
            <td class="align-middle tx-center"><?= $d->keterangan ?? "-" ?></td>
            <?php endif; ?>
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
                    text: "<i data-feather='file-text'></i> Ekspor PDF",
                    title: "",
                    messageTop: "<center><h4>Rekap Kehadiran Acara <?= $data1->nama_acara ?></h4></center><br>",
                    messageBottom:  "<br><center>Dokumen ini dicetak pada hari <b>" +
                        (new Date()).toLocaleString('id-ID',{dateStyle: 'full'}) + "</b> pukul <b>" +
                        (new Date()).toLocaleString('id-ID',{timeStyle: 'long'}) + "</b> oleh <b>" +
                        "<?= $data2->nama ?></b> NRP <b><?= $data2->nrp ?></b></center>",
                    autoPrint: false,
                    className: "btn btn-danger bg-danger",
                    customize: function (win) {
                        $(win.document.body).find("table")
                            .addClass("compact")
                            .css("font-size","10px");
                    },
                },
                {
                    extend: "excel",
                    text: "<i data-feather='table'></i> Ekspor Excel",
                    className: "btn btn-success bg-success",
                    filename: "Rekap Kehadiran Acara <?= $data1->nama_acara ?>",
                    title: "Rekap Kehadiran Acara <?= $data1->nama_acara ?>",
                    messageTop: "Dokumen ini TIDAK VALID untuk digunakan sebagai bukti capaian IPMS. Silakan gunakan Ekspor PDF untuk bukti capaian IPMS.",
                    messageBottom:  "Dokumen ini dicetak pada hari " +
                        (new Date()).toLocaleString('id-ID',{dateStyle: 'full'}) + " pukul " +
                        (new Date()).toLocaleString('id-ID',{timeStyle: 'long'}) + " oleh " +
                        "<?= $data2->nama ?> NRP <?= $data2->nrp ?>",
                    customize: function( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row:first c', sheet).attr( 's', '2' );
                        $('row c[r=A2]', sheet).attr( 's', '12' );
                        $('row:last c', sheet).attr( 's', '2' );
                    }
                },
                {
                    extend: "pageLength",
                    className: "btn btn-outline-primary bg-white"
                },
            ]
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