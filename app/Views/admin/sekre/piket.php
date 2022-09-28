<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
Admin HMSI | Sekretariat | Piket
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Kehadiran Piket Ruang Kesekretariatan
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<div class="row mg-b-10">
    <div class="col-6 col-md-4 col-lg-2 mg-b-10">
        <div class="card shadow-none tx-white
        <?= (
                (strtotime("22:00:01") <= time()) ||
                (strtotime("07:00:00") >= time()) ||
                (date("w") == 6) ||
                (date("w") == 0)
        ) ? "bg-danger" : "bg-secondary" ?>">
            <div class="card-body tx-center">
                <span class="tx-20 tx-bold">SESI X</span><br>
                <span class="tx-12">diluar waktu piket</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2 mg-b-10">
        <div class="card shadow-none tx-white
        <?= (
                (strtotime("07:00:01") <= time()) &&
                (strtotime("10:00:00") >= time()) &&
                (date("w") != 6) &&
                (date("w") != 0)
        ) ? "bg-success" : "bg-secondary" ?>">
            <div class="card-body tx-center">
                <span class="tx-20 tx-bold">SESI 1</span><br>
                <span class="tx-12">07.00 - 10.00</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2 mg-b-10">
        <div class="card shadow-none tx-white
        <?= (
                (strtotime("10:00:01") <= time()) &&
                (strtotime("13:00:00") >= time()) &&
                (date("w") != 6) &&
                (date("w") != 0)
        ) ? "bg-success" : "bg-secondary" ?>">
            <div class="card-body tx-center">
                <span class="tx-20 tx-bold">SESI 2</span><br>
                <span class="tx-12">10.00 - 13.00</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2 mg-b-10">
        <div class="card shadow-none tx-white
        <?= (
                (strtotime("13:00:01") <= time()) &&
                (strtotime("16:00:00") >= time()) &&
                (date("w") != 6) &&
                (date("w") != 0)
        ) ? "bg-success" : "bg-secondary" ?>">
            <div class="card-body tx-center">
                <span class="tx-20 tx-bold">SESI 3</span><br>
                <span class="tx-12">13.00 - 16.00</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2 mg-b-10">
        <div class="card shadow-none tx-white
        <?= (
                (strtotime("16:00:01") <= time()) &&
                (strtotime("19:00:00") >= time()) &&
                (date("w") != 6) &&
                (date("w") != 0)
        ) ? "bg-success" : "bg-secondary" ?>">
            <div class="card-body tx-center">
                <span class="tx-20 tx-bold">SESI 4</span><br>
                <span class="tx-12">16.00 - 19.00</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2 mg-b-10">
        <div class="card shadow-none tx-white
        <?= (
                (strtotime("19:00:01") <= time()) &&
                (strtotime("22:00:00") >= time()) &&
                (date("w") != 6) &&
                (date("w") != 0)
        ) ? "bg-success" : "bg-secondary" ?>">
            <div class="card-body tx-center">
                <span class="tx-20 tx-bold">SESI 5</span><br>
                <span class="tx-12">19.00 - 22.00</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <form action="<?= base_url("admin/sekre/piket/hadir") ?>" method="post" data-parsley-validate class="col-md-6 col-lg-4 mg-b-10">
        <div class="card card-body">
            <div class="marker marker-ribbon marker-primary pos-absolute t-10 l-0">Mulai piket RK<br></div>
            <p class="mg-t-30">
                <span class="tx-gray-700">Status Piket:</span><br><b>
                    <?= ($data2->jadwal_wajib == date("Y-m-d")) ? "Jadwal piket wajib" : "Bukan jadwal piket wajib" ?></b>
            </p>
            <p>
                <span class="tx-gray-700">Waktu Mulai:</span><br><b>
                    <?= $data3->waktu_datang ?? "-" ?></b>
            </p>
            <button type="submit" class="btn btn-primary btn-icon btn-sm mg-l-auto"
                <?= (
                        ($data3 !== null) ||
                        (date("w") == 6) ||
                        (date("w") == 0) ||
                        (strtotime("22:00:01") <= time()) ||
                        (strtotime("07:00:00") >= time())
                ) ? "disabled" : "" ?>>
                <i data-feather="check-circle"></i> <span>Tekan untuk Hadir</span>
            </button>
        </div>
    </form>

    <form action="<?= base_url("admin/sekre/piket/pulang") ?>" method="post" data-parsley-validate class="col-md-6 col-lg-4 mb-b-10">
        <div class="card card-body">
            <div class="marker marker-ribbon marker-primary pos-absolute t-10 l-0">Selesai piket RK<br></div>
            <p class="mg-t-30">
                <span class="tx-gray-700">Status Piket:</span><br><b>
                    <?= ($data2->jadwal_wajib == date("Y-m-d")) ? "Jadwal piket wajib" : "Bukan jadwal piket wajib" ?></b>
            </p>
            <p>
                <span class="tx-gray-700">Waktu Selesai:</span><br><b>
                    <?= $data3->waktu_keluar ?? "-" ?></b>
            </p>
            <button type="submit" class="btn btn-primary btn-icon btn-sm mg-l-auto" <?= ($data3 === null || $data3->waktu_keluar !== null) ? "disabled" : "" ?>>
                <i data-feather="check-circle"></i> <span>Tekan untuk Selesai</span>
            </button>
        </div>
    </form>

    <div class="col-md-6 col-lg-4">
        <div class="card shadow-none bg-light">
            <div class="card-body tx-center">
                <span class="tx-20 tx-bold tx-primary">Statistik</span><br><br>
                <span class="tx-bold">Status Piket Wajib</span><br>
                <span class="">
                    <?php
                    $status = $data2->status ?? 0;
                    if($status === "0") echo "Belum Melaksanakan (" . $data2->jadwal_wajib . ")";
                    if($status === "1") echo "Sudah Melaksanakan";
                    if($status === "2") echo "Piket diulang karena durasi kurang dari 2 jam";
                    ?>
                </span><br><br>
                <span class="tx-bold">Jumlah Piket Tidak Wajib</span><br>
                <span class=""><?= $data1 ?> kali</span><br><br>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6">
        <span class="tx-danger">
            <b>Catatan:</b><br>
            Bagian <b>Selesai Piket RK</b> hanya wajib diisi untuk yang dijadwalkan piket wajib.
        </span>
    </div>
</div>

<div class="row mg-t-30">
    <div class="col-12">
        <hr>
        <p class="tx-20 tx-bold">Riwayat Kehadiran Piket</p>
        <table id="rekap-piket" class="table table-hover">
            <thead>
            <tr class="tx-center">
                <th class="wd-10p">No</th>
                <th class="wd-30p">Hari / Tanggal</th>
                <th class="wd-20p">Waktu Mulai</th>
                <th class="wd-20p">Waktu Selesai</th>
                <th class="wd-20p">Jenis Piket</th>
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
                    <td class="align-middle tx-center"><?= ($d->status === '0') ? "Wajib" : "Tidak Wajib" ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("js") ?>
<script>
    $('#rekap-piket').DataTable({
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