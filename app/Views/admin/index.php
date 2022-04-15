<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
Admin HMSI | Beranda
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Selamat Datang
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<div class="row">
    <div class="col-sm-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <span class="tx-bold">Jumlah Acara per Departemen</span>
            </div>
            <div class="card-body pd-y-25">
                <div class="row">
                    <div class="col-sm-12 col-lg-5">
                        <div class="chart-thirteen" style="height:250px"><canvas id="chartDonut"></canvas></div>
                    </div>
                    <div class="col-sm-12 col-lg-7 tx-10 animated fadeInRight delay-2s">
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

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
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

<?= $this->endSection() ?>

