<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | Survei | Dashboard
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Daftar Survei Tersedia
<?= $this->endSection() ?>

<?= $this->section("konten") ?>
<table id="daftar-survei" class="table table-hover">
    <thead>
    <tr class="tx-center">
        <th class="wd-5p">No.</th>
        <th class="wd-10p">Kode</th>
        <th class="wd-65p">Nama Survei</th>
        <th class="wd-20p">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $i=>$d): ?>
    <tr>
        <td class="align-middle tx-center"><?= $i+1 ?></td>
        <td class="align-middle tx-center tx-bold"><?= $d->id_survei ?></td>
        <td class="align-middle"><?= $d->nama_survei ?></td>
        <td class="align-middle tx-center">
            <?php
            $id_pengurus = str_replace("id-pengurus",session()->get("id_pengurus"),$d->tautan);
            $nrp = str_replace("nrp",$data2,$id_pengurus);
            $id_survei = str_replace("id-survei",$d->id_survei,$nrp);

            if($d->cek === '0'): ?>
                <a href="<?= $id_survei ?>" class="btn btn-success btn-xs btn-block">
                    <i data-feather="edit-2"></i> Mulai Isi Survei
                </a>
            <?php else: ?>
                <a href="#" class="btn btn-secondary btn-xs btn-block">
                    <i data-feather="x-octagon"></i> Survei Sudah Diisi
                </a>
            <?php endif; ?>

            <?php
            $id = $d->id_survei;
            if(session()->get("id_pengurus") < 2000):
            ?>
                <a href="<?= base_url("admin/survei/detail/$id") ?>" class="btn btn-primary btn-xs btn-block">
                    <i data-feather="pie-chart"></i> Rekap Pengisian</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#daftar-survei').DataTable({
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
