<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
Admin HMSI | Sekretariat | Piket
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Kehadiran Piket Ruang Kesekretariatan
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

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
            <?php if(
                (strtotime("22:00:01") <= time()) ||
                (strtotime("07:00:00") >= time()) ||
                (date("w") == 6) ||
                (date("w") == 0)):
            ?>
                <button type="button" class="btn btn-danger btn-icon btn-sm mg-l-auto">
                    <span><i data-feather="x-octagon"></i> Bukan Sesi Piket</span>
                </button>
            <?php elseif($data3 !== null): ?>
                <button type="submit" class="btn btn-primary btn-icon btn-sm mg-l-auto" disabled>
                    <span><i data-feather="check-circle"></i> Sudah Hadir</span>
                </button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary btn-icon btn-sm mg-l-auto">
                    <span><i data-feather="check-circle"></i> Tekan untuk Hadir</span>
                </button>
            <?php endif; ?>
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
                <span class="tx-bold">Jadwal Piket Wajib</span><br>
                <span class="">
                    <?php
                    $status = $data2->status ?? 0;
                    echo ($status === "0") ?
                        (new IntlDateFormatter("id_ID",IntlDateFormatter::FULL,IntlDateFormatter::SHORT,"Asia/Jakarta",IntlDateFormatter::GREGORIAN,"eeee, dd MMMM yyyy'"))->format(new DateTime($data2->jadwal_wajib))
                    : "Sudah Melaksanakan";
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

<?php if(session()->get("id_pengurus") < 2000): ?>
<div class="row mg-t-30">
    <div class="col-12">
        <hr>
        <p class="tx-20 tx-bold">Rekap Kehadiran Piket</p>
        <table id="rekap-piket" class="table table-hover">
            <thead>
            <tr class="tx-center">
                <th class="wd-5p">No</th>
                <th class="wd-30p">Nama</th>
                <th class="wd-30p">Departemen</th>
                <th class="wd-10p">Jadwal</th>
                <th class="wd-10p">Status</th>
                <th class="wd-10p">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data5 as $i=>$d): ?>
                <tr>
                    <td class="align-middle tx-center"><?= $i+1 ?></td>
                    <td class="align-middle"><?= $d->nama ?></td>
                    <td class="align-middle"><?= $d->nama_departemen ?></td>
                    <td class="align-middle tx-center"><?= $d->jadwal_wajib ?></td>
                    <td class="align-middle tx-center <?= ($d->status  === "Belum") ? "tx-danger tx-bold" : "" ?>"><?= $d->status ?></td>
                    <td class="align-middle tx-center">
                        <?php if($d->status  === "Belum"): ?>
                            <a onclick="pindahConfirm(<?= $d->id_pengurus ?>)" href="#" class="btn btn-primary btn-xs btn-block"><i data-feather="calendar"></i> Pindah</a>
                        <?php else: ?>
                        -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal_piket" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog wd-sm-400" role="document">
        <div class="modal-content bg-white">
            <form action="<?= base_url("admin/sekre/piket/ubah") ?>" method="post">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Pindah Jadwal Piket</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_pengurus" id="id_pengurus" value="">
                <div class="form-group">
                    <label for="tanggal" class="tx-bold">Tanggal Piket <span class="tx-danger">*</span></label>
                    <input id="tanggal" name="tanggal" type="date" class="form-control" placeholder="Masukkan tanggal acara" required data-parsley-required-message="Tanggal piket wajib diisi!">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-xs btn-danger">
                    <i data-feather="save"></i> <span>Pindah Jadwal</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section("js") ?>
<script>
    function pindahConfirm(id_pengurus)
    {
        $('#id_pengurus').attr("value",id_pengurus);
        $("#modal_piket").modal();
    }

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