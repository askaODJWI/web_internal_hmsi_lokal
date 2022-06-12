<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | Hadir | Dashboard
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Daftar Pranala Kehadiran Acara
<?= $this->endSection() ?>

<?= $this->section("konten") ?>
<div id="copy_link"></div>

<table id="daftar-link-acara" class="table table-hover">
    <thead>
    <tr class="tx-center">
        <th>No.</th>
        <th class="wd-10p">Kode</th>
        <th class="wd-15p">Nama</th>
        <th class="wd-15p">Tanggal</th>
        <th class="wd-15p">Lokasi</th>
        <th class="wd-30p">Pembuat / Pengubah</th>
        <th class="wd-15p">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $i=>$d): ?>
    <tr>
        <td class="align-middle tx-center"><?= $i+1 ?></td>
        <td class="align-middle tx-center tx-bold"><?= $d->kode_acara ?></td>
        <td class="align-middle"><?= $d->nama_acara ?></td>
        <td class="align-middle"><?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%A, %d %B %Y",strtotime($d->tanggal)) .
                "<br>pukul " . date_format(date_create($d->tanggal),"H.i") . " WIB"?></td>
        <td class="align-middle"><?= (strlen($d->lokasi) <= 25) ? $d->lokasi : substr($d->lokasi,0,25) . " ..." ?></td>
        <td class="align-middle">
            <?= $d->nama . "<br><i>" . $d->jabatan . " " . $d->nama_departemen . "</i>" ?><br>
        </td>
        <td class="align-middle tx-center">
            <a onclick="copyLink('<?= base_url("/$d->kode_acara") ?>')"
               class="btn btn-primary btn-xs btn-block" target="_blank">
                <span class="tx-white"><i data-feather="link-2"></i> Salin Tautan</span></a>
            <?php if($d->status === '0'): ?>
                <a onclick="tutupConfirm('<?= base_url('admin/hadir/tutup/'.$d->kode_acara) ?>')" href="#"
                   class="btn btn-danger btn-xs btn-block"><i data-feather="x-octagon"></i> Tutup Akses</a>
            <?php else: ?>
                <a href="<?= base_url("admin/hadir/buka/$d->kode_acara") ?>" class="btn btn-outline-secondary btn-xs btn-block">
                    <i data-feather="eye"></i> Buka Akses</a>
            <?php endif; ?>
            <?php if($d->jumlah === '0'): ?>
                <a href="<?= base_url("admin/hadir/ubah/$d->kode_acara") ?>" class="btn btn-warning btn-xs btn-block">
                    <i data-feather="edit-2"></i> Ubah</a>
                <a onclick="deleteConfirm('<?= base_url('admin/hadir/hapus/'.$d->kode_acara) ?>')" href="#" class="btn btn-dark btn-xs btn-block"><i data-feather="trash-2"></i> Hapus</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="modal_tutup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog wd-sm-400" role="document">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="font-weight-bold tx-14">Apakah kamu yakin ingin MENUTUP AKSES presensi?</p>
                <p class="tx-danger" id="konfirm_tutup">Peserta <b>TIDAK BISA </b>melakukan presensi lagi setelah akses ditutup</p>
                <span>Klik tombol <b>TUTUP</b> untuk melanjutkan.</span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-danger btn-xs" id="btn-tutup" href="#">Tutup</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    function tutupConfirm(url)
    {
        $("#btn-tutup").attr("href", url);
        $("#modal_tutup").modal();
    }

    function copyLink(url)
    {
        navigator.clipboard.writeText(url);
        $("#copy_link").append(
            '<div class="alert alert-success alert-dismissible fade show mt-3 mb-3" role="alert">' +
            'Tautan akses presensi berhasil disalin ke clipboard <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">×</span></button></div>'
        );
    }

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
        drawCallback: function() {
            feather.replace();
        }
    });

    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    $(".select2-container").addClass("tx-12");
</script>

<?= $this->endSection() ?>
