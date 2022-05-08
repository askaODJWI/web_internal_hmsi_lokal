<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
Admin HMSI | Tautan | Dashboard
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
Daftar Peringkas Tautan
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<?php $total = array_key_last($data); ?>
<?php for($i = 0 ; $i <= $total ; $i++): ?>
    <?php if($i % 3 === 0): ?>
    <div class="row">
    <?php endif; ?>

    <div class="col-12 col-md-6 col-lg-4 mg-t-20 mg-t-lg-0">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><u><a href="https://tekan.id/<?= $data[$i]->pendek ?>"><?= $data[$i]->pendek ?></a></u></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $data[$i]->panjang ?></h6>
                <p class="card-text">
                    Dibuat oleh <?= $data[$i]->nama ?><br>
                    pada <?php setlocale(LC_ALL,'id_ID.utf8', 'id-ID'); echo strftime("%A, %d %B %Y",strtotime($data[$i]->waktu)) .
                        " pukul " . date_format(date_create($data[$i]->waktu),"H.i.s") . " WIB"?>
                </p>
                <a href="<?= base_url("admin/tautan/ubah/" . $data[$i]->id_tautan)?>" class="card-link">Ubah Tautan</a>
                <a href="#" onclick="deleteConfirm('<?= base_url('admin/hapus/' . $data[$i]->id_tautan) ?>')" class="card-link tx-danger">Hapus Tautan</a>
            </div>
        </div>
    </div>

    <?php if($i % 3 === 2 || $i === $total): ?>
    </div>
    <div class="mg-t-0 mg-t-lg-20"></div>
    <?php endif; ?>
<?php endfor; ?>

<?= $this->endSection() ?>
