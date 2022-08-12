<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | IS Store | Point of Sales
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    IS Store - Point of Sales
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<form action="#" method="post">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nomor Transaksi</span>
                        </div>
                        <input type="text" class="form-control font-weight-bolder" id="no_transaksi" name="no_transaksi" value="yy-mm-dd-id_pengurus-xx" readonly>
                    </div>

                    <div class="mt-3">
                        <a href="#" onclick="$('#tambah_keranjang').modal()" class="btn btn-primary btn-sm">
                            <i data-feather="plus-circle"></i> Tambah Keranjang
                        </a>

                        <a href="#" class="btn btn-outline-primary btn-sm mg-sm-l-0 mg-lg-l-10">
                            <i data-feather="search"></i> Lihat Detail Barang
                        </a>

                        <a href="#" class="btn btn-outline-primary btn-sm mg-sm-l-0 mg-lg-l-10">
                            <i data-feather="percent"></i> Lihat Promo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <span style="font-size:1rem; font-weight:bold;">TOTAL (Rp)</span>
                    <p style="font-size:2rem; text-align: right; font-weight: bold;">15.000</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="text-muted text-center">
                        <tr>
                            <th class="wd-5p">#</th>
                            <th class="wd-55p">Nama Barang</th>
                            <th class="wd-20p">Jumlah</th>
                            <th class="wd-10p">Harga (Rp)</th>
                            <th class="wd-10p">Total (Rp)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="123">
                            <td><a href="#" class="tx-danger"><i data-feather="x"></i></a></td>
                            <td>
                                <input type="hidden" name="sku1" id="sku1" value="123">
                                Miniso Botol Tumblr 300mL Pink
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend d-none d-lg-block">
                                        <button class="btn btn-outline-secondary btn-xs" type="button"><i data-feather="minus"></i></button>
                                    </div>
                                    <input type="text" class="form-control" value="3" style="text-align: center" id="barang1" name="barang1">
                                    <div class="input-group-append d-none d-lg-block">
                                        <button class="btn btn-outline-secondary btn-xs" type="button"><i data-feather="plus"></i></button>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">15.000</td>
                            <td class="text-right font-weight-bolder">75.000</td>
                        </tr>
                        <tr id="456">
                            <td><a href="#" class="tx-danger"><i data-feather="x"></i></a></td>
                            <td>Tangoo Wafer Cokelat 25g Kemasan Khusus Tanpa Merk Tanpa Pengawet Tanpa Pemanis Tanpa Pewarna</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend d-none d-lg-block">
                                        <button class="btn btn-outline-secondary btn-xs" type="button"><i data-feather="minus"></i></button>
                                    </div>
                                    <input type="text" class="form-control" value="1" style="text-align: center">
                                    <div class="input-group-append d-none d-lg-block">
                                        <button class="btn btn-outline-secondary btn-xs" type="button"><i data-feather="plus"></i></button>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">3.000</td>
                            <td class="text-right font-weight-bolder">3.000</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <p style="font-size:1rem; font-weight:bolder;">Metode Pembayaran</p>
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-success btn-block btn-lg">
                                <i data-feather="pocket"></i> Tunai
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-primary btn-block btn-lg">
                                <i data-feather="credit-card"></i> QRIS
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="tambah_keranjang" tabindex="-1" role="dialog" aria-labelledby="modal-tambah-keranjang" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-tambah-keranjang">Tambahkan Barang ke Keranjang</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover" id="cari_barang">
                    <thead class="text-center tx-bolder">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th class="d-none d-md-block">Harga</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("js") ?>
<script>
    $('#cari_barang').DataTable({
        autoWidth: false,
        ajax: {
            type: 'GET',
            url: '/ajax/cek_barang/',
            dataSrc: function (data){
                return data;
            }
        },
        columns: [
            {
                data: 'kode_barang',
                width: '15%',
                className: 'dt-body-center',
            },
            {
                data: 'nama_barang',
                width: '55%',
            },
            {
                data: 'harga_jual',
                render: function (data){
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data);
                },
                width: '15%',
                className: 'dt-body-right d-none d-md-block',
            },
            {
                render: function(){
                    return '<button type="button" class="btn btn-primary btn-xs"><i data-feather="shopping-cart"></i> Tambah</button>'
                },
                width: '15%',
                className: 'dt-body-center',
            },
        ],
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
            zeroRecords: "Tidak ada data yang ditemukan",
        },
        drawCallback: function () {
            feather.replace();
        }
    });

    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity, dropdownParent: $('#tambah_keranjang') });
    $(".select2-container").addClass("tx-12");
</script>
<?= $this->endSection() ?>
