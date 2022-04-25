<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
Admin HMSI | Beranda
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Selamat Datang <span class="tx-primary">Generasi Pionir ✨</span>
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header bd-b-0 pd-t-20 pd-lg-t-25 pd-l-20 pd-lg-l-25 d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                <div>
                    <h6 class="mg-b-5">Jumlah Penyelenggaraan Acara per Departemen</h6>
                    <p class="tx-12 tx-color-03 mg-b-0">Dihitung berdasarkan jumlah total pranala yang ada di web Admin HMSI</p>
                </div>
            </div>
            <div class="card-body pd-y-25">
                <div class="row">
                    <div class="col-sm-12 col-lg-5">
                        <div class="chart-thirteen" style="height:250px"><canvas id="chartDonut"></canvas></div>
                    </div>
                    <div class="col-sm-12 col-lg-7 tx-10 animated fadeInLeft delay-2s">
                        <table class="table table-striped table-hover table-borderless">
                            <thead>
                            <tr class="tx-center">
                                <th>#</th>
                                <th class="wd-90p">Nama Departemen</th>
                                <th class="wd-10p">Jumlah</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data1 as $i=>$d): ?>
                                <tr>
                                    <td><span style="background-color:<?= $data2[$i] ?>; color:<?= $data2[$i] ?>;font-size:10px;">⠀⠀</span></td>
                                    <td class="align-middle"><?= $d->nama_departemen ?></td>
                                    <td class="align-middle tx-center"><?= $d->jumlah ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-lg-4">
        <div class="card card-widget card-events">
            <div class="card-header">
                <span class="tx-bold">Acara yang Akan Datang</span>
            </div>
            <div class="card-body">
                <ul class="list-unstyled media-list mg-b-0">
                    <?php if(array_key_last($data) === null): ?>
                        <li class="media animated fadeInDown delay-3s">
                            <span class="tx-bold tx-danger">Belum ada kegiatan yang tercatat</span>
                        </li>
                    <?php else: ?>
                        <?php foreach($data as $i=>$d): ?>
                            <li class="media animated fadeInDown delay-<?= $i+3 ?>s">
                                <div class="media-left">
                                    <label><?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID');echo substr(strftime("%A",strtotime($d->tanggal)),0,3) ?></label>
                                    <p><?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%d",strtotime($d->tanggal)) ?></p>
                                </div>
                                <div class="media-body event-panel-<?php switch($d->id_departemen){
                                    case(1):case(2):case(3):case(4): echo "pink"; break;
                                    case(5):case(7):case(9):case(13): echo "primary"; break;
                                    default: echo "green";break;
                                }?>">
                                    <span class="event-desc"><?= date_format(date_create($d->tanggal),"H.i") . " WIB" ?></span><br>
                                    <span class="event-title tx-bold"><?= $d->nama_acara ?></span><br>
                                    <span class="event-desc tx-medium"><?= $d->nama_departemen ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ganti_pass" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog wd-sm-400" role="document">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Ubah Kata Sandi Default</h5>
            </div>
            <form action="<?= base_url("admin/akun/ubah_pass") ?>" method="post" id="form_pass" data-parsley-validate>
                <div class="modal-body">
                    <p class="font-weight-bold tx-12 tx-danger">Ups! kamu harus mengganti password default demi keamanan akunmu!</p>
                    <div id="alert_pass" style="display: none">
                        <div class="alert alert-danger alert-dismissible fade show mt-3 mb-3" role="alert">
                            Kata Sandi yang dimasukkan tidak cocok atau sama dengan password default
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="pass_lama" value="1234">
                    <div class="form-group">
                        <label for="pass_baru1" class="tx-bold">Kata Sandi Baru <span class="tx-danger">*</span></label>
                        <input id="pass_baru1" name="pass_baru1" type="password" class="form-control" placeholder="Masukkan kata sandi baru" required  data-parsley-required-message="Kata sandi Baru wajib diisi!">
                    </div>
                    <div class="form-group">
                        <label for="pass_baru2" class="tx-bold">Ketik Ulang Kata Sandi Baru <span class="tx-danger">*</span></label>
                        <input id="pass_baru2" name="pass_baru2" type="password" class="form-control" placeholder="Masukkan kata sandi baru" required  data-parsley-required-message="Kata sandi Baru wajib diisi!">
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary btn-xs" href="#" id="tombol_pass">Ubah Kata Sandi</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script type="text/javascript">
$(function(){
    var datapie = {
        labels: ["Head of HMSI","Vice Head","General Secretary","General Treasury","Entrepreneurship","External Affairs","Human Resource Development","Information Media","Internal Affairs","Research and Technology Applications","Social Development","Student Welfare","Technology Development"],
        datasets: [{
            data: [
                <?php foreach($data1 as $i){
                echo "'" . $i->jumlah . "',";
            }?>
            ],
            backgroundColor: ["#FFC5D9","#FF8BB3","#FF3178","#B52F5D","#E4E378","#87A2E8","#45BCA8","#5C86F2","#45BCA8","#2052D3","#359388","#0A5950","#2C427A"]
        }]
    };

    var optionpie = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false,
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };

    // For a pie chart
    var ctx2 = document.getElementById('chartDonut');
    var myDonutChart = new Chart(ctx2, {
        type: 'doughnut',
        data: datapie,
        options: optionpie
    });
});
</script>

<script type="text/javascript">
    $("#tombol_pass").on("click", function()
    {
        let pass1 = $("#pass_baru1").val();
        let pass2 = $("#pass_baru2").val();
        return ((pass1 === pass2) && (pass1 !== "1234")) ? document.getElementById('form_pass').submit() : $("#alert_pass").show();
    });

    $.ajax({
        type: "GET",
        url: "/ajax/cek_password/" + <?= session()->get("id_pengurus") ?>,
        dataType: "json",

        success: function (data)
        {
            console.log(data);
            if(data === "ganti")
            {
                $('#ganti_pass').modal();
            }
        }
    });
</script>

<?= $this->endSection() ?>

