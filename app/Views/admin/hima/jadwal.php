<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
Admin HMSI | Hima | Pinjam Ruangan
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Jadwal Pemakaian Ruang Kesekretariatan
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<link href="<?= base_url("main/lib/fullcalendar/fullcalendar.min.css") ?>" rel="stylesheet">
<link href="<?= base_url("main/assets/css/dashforge.calendar.css") ?>" rel="stylesheet" >

<div class="calendar-wrapper">
    <div class="calendar-content">
        <div class="d-block d-lg-none tx-center mg-t-20 mg-lg-t-0">
            <a href="" class="btn btn-sm btn-primary btn-icon calendar-add">
                <i data-feather="plus"></i> Buat Peminjaman Baru
            </a>
        </div>
        <div id="calendar" class="calendar-content-body"></div>
    </div>
</div>

<div class="modal calendar-modal-create fade effect-scale" id="modalCreateEvent" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formCalendar" method="post" action="<?= base_url("admin/hima/jadwal/buat") ?>">
                <div class="modal-body pd-20">
                    <button type="button" class="close pos-absolute t-20 r-20" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                    <h5 class="tx-18 tx-sm-20 mg-b-20 mg-sm-b-30">Jadwalkan Peminjaman Ruangan</h5>

                    <div class="form-group">
                        <input id="nama_kegiatan" name="nama_kegiatan" type="text" class="form-control" placeholder="Masukkan nama acara atau kegiatan">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="tx-uppercase tx-sans tx-10 tx-spacing-1 tx-color-03">Waktu Mulai</label>
                                <input id="waktu_mulai" name="waktu_mulai" type="datetime-local" value="" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="tx-uppercase tx-sans tx-10 tx-spacing-1 tx-color-03">Waktu Selesai</label>
                                <input id="waktu_selesai" name="waktu_selesai" type="datetime-local" value="" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ml-auto">Jadwalkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal calendar-modal-event fade effect-scale" id="modalCalendarEvent" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="event-title"></h6>
                <nav class="nav nav-modal-event">
                    <a href="#" class="nav-link" data-dismiss="modal"><i data-feather="x"></i></a>
                </nav>
            </div>
            <div class="modal-body">
                <div class="row row-sm">
                    <div class="col-sm-6">
                        <label class="tx-uppercase tx-sans tx-10 tx-spacing-1 tx-color-03">Waktu Mulai</label>
                        <p class="event-start-date"></p>
                    </div>
                    <div class="col-sm-6">
                        <label class="tx-uppercase tx-sans tx-10 tx-spacing-1 tx-color-03">Waktu Selesai</label>
                        <p class="event-end-date"></p>
                    </div>
                    <div class="col-sm-12">
                        <label class="tx-uppercase tx-sans tx-10 tx-spacing-1 tx-color-03">Pembuat</label>
                        <p class="event-desc"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script src="<?= base_url("main/lib/moment/min/moment.min.js") ?>"></script>
<script src="<?= base_url("main/lib/fullcalendar/fullcalendar.min.js") ?>"></script>
<script src="<?= base_url("main/lib/fullcalendar/locale/id.js") ?>"></script>
<script src="<?= base_url("main/assets/js/dashforge.calendar.js") ?>"></script>

<script>
    const curYear = moment().format('YYYY');
    const curMonth = moment().format('MM');

    // BPH
    let calendarEvents = {
        id: 1,
        backgroundColor: '#d9e8ff',
        borderColor: '#0168fa',
        events: [
            <?php foreach($data1 as $ka=>$da): ?>
            {
                id: '1<?= ($ka+1 <= 9) ? "0" . ($ka+1) : $ka+1 ?>',
                start: '<?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%F",strtotime($da->waktu_mulai)) . "T" .
                    date_format(date_create($da->waktu_mulai),"H:i:s")?>',
                end: '<?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%F",strtotime($da->waktu_selesai)) . "T" .
                    date_format(date_create($da->waktu_selesai),"H:i:s")?>',
                title: '<?= $da->nama_kegiatan ?>',
                description: '<?= $da->nama . " - " . $da->jabatan . " - " . $da->nama_departemen ?>',
            },
            <?php endforeach; ?>
        ]
    };

    // Eksternal
    let birthdayEvents = {
        id: 2,
        backgroundColor: '#c3edd5',
        borderColor: '#10b759',
        events: [
            <?php foreach($data2 as $kb=>$db): ?>
            {
                id: '2<?= ($kb+1 <= 9) ? "0" . ($kb+1) : $kb+1 ?>',
                start: '<?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%F",strtotime($db->waktu_mulai)) . "T" .
                    date_format(date_create($db->waktu_mulai),"H:i:s")?>',
                end: '<?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%F",strtotime($db->waktu_selesai)) . "T" .
                    date_format(date_create($db->waktu_selesai),"H:i:s")?>',
                title: '<?= $db->nama_kegiatan ?>',
                description: '<?= $db->nama . " - " . $db->jabatan . " - " . $db->nama_departemen ?>',
            },
            <?php endforeach; ?>
        ]
    };

    // Internal
    let holidayEvents = {
        id: 3,
        backgroundColor: '#fcbfdc',
        borderColor: '#f10075',
        events: [
            <?php foreach($data3 as $kc=>$dc): ?>
            {
                id: '1<?= ($kc+1 <= 9) ? "0" . ($kc+1) : $kc+1 ?>',
                start: '<?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%F",strtotime($dc->waktu_mulai)) . "T" .
                    date_format(date_create($dc->waktu_mulai),"H:i:s")?>',
                end: '<?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%F",strtotime($dc->waktu_selesai)) . "T" .
                    date_format(date_create($dc->waktu_selesai),"H:i:s")?>',
                title: '<?= $dc->nama_kegiatan ?>',
                description: '<?= $dc->nama . " - " . $dc->jabatan . " - " . $dc->nama_departemen ?>',
            },
            <?php endforeach; ?>
        ]
    };

    let discoveredEvents = {

    };

    let meetupEvents = {

    };

    let otherEvents = {

    };
</script>

<?= $this->endSection() ?>
