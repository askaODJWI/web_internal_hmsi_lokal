<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
Admin HMSI | Beranda
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Selamat Datang
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<style>
    .chart-thirteen {
        height: 220px; }
    @media (min-width: 768px) and (max-width: 991.98px) {
        .chart-thirteen {
            height: 143px; } }
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .chart-thirteen {
            height: 160px; } }
</style>

<div class="row">
    <div class="col-sm-12 col-lg-5">
        <div class="card">
            <div class="card-header">
                <span class="tx-bold">Persentase Departemen Pelaksana Acara</span>
            </div>
            <div class="card-body pd-y-25">
                <div class="row">
                    <div class="col-12">
                        <div class="chart-thirteen"><canvas id="chartDonut"></canvas></div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <table class="table table-hover">
                            <thead>
                            <tr class="tx-center">
                                <th class="wd-70p">Nama Departemen</th>
                                <th class="wd-30p">Jumlah Acara</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data1 as $i): ?>
                                <tr>
                                    <td class="align-middle"><?= $i->nama_departemen ?></td>
                                    <td class="align-middle tx-center"><?= $i->jumlah ?> acara</td>
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
                    <?php foreach($data as $d): ?>
                        <li class="media">
                            <div class="media-left">
                                <label><?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID');echo substr(strftime("%A",strtotime($d->tanggal)),0,3) ?></label>
                                <p><?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%d",strtotime($d->tanggal)) ?></p>
                            </div>
                            <div class="media-body event-panel-primary">
                                <span class="event-desc"><?= date_format(date_create($d->tanggal),"H.i") . " WIB" ?></span><br>
                                <span class="event-title tx-bold"><?= $d->nama_acara ?></span><br>
                                <span class="event-desc tx-medium"><?= $d->nama_departemen ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
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
        labels: [
            <?php foreach($data1 as $i){
                echo "'" . $i->nama_departemen . "',";
            }?>
        ],
        datasets: [{
            data: [
                <?php foreach($data1 as $i){
                echo "'" . $i->jumlah . "',";
            }?>
            ],
            backgroundColor: ['#66a4fb', '#4cebb5','#fec85e','#ff7c8f','#a4e063','#a5d7fd','#b2bece']
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

