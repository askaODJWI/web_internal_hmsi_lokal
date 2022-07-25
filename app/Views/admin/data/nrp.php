<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
Admin HMSI | Data | Dashboard
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Cari Data dari Nama ke NRP
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<form action="<?= base_url("admin/data/nrp") ?>" method="post" data-parsley-validate>
    <div class="row">
        <div class="col-lg-9">
            <div class="form-group">
                <label for="nama" class="tx-bold">Nama <span class="tx-danger">*</span></label>
                <input id="nama" name="nama" type="text" class="form-control" placeholder="Masukkan nama mahasiswa yang ingin dicari" required data-parsley-required-message="Nama yang ingin dicari wajib diisi!">
            </div>
        </div>
        <div class="col-lg-3 mt-auto">
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary btn-icon">
                    <i data-feather="search"></i> <span>Cari Data</span>
                </button>
            </div>
        </div>
    </div>
</form>

<?php if(service("request")->getMethod() === "post"): ?>
<table id="daftar-nrp" class="table table-hover">
    <thead>
    <tr class="tx-center tx-bold">
        <th class="wd-5p">No.</th>
        <th class="wd-40p">Nama</th>
        <th class="wd-15p">NRP</th>
        <th class="wd-10p">Angkatan</th>
        <th class="wd-30p">Program Studi</th>
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

<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#daftar-nrp').DataTable({
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
