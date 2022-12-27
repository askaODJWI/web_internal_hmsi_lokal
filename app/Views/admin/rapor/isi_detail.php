<?= $this->extend("layout/master-admin") ?>

<?= $this->section("title") ?>
    Admin HMSI | Rapor | Isi Detail
<?= $this->endSection() ?>

<?= $this->section("breadcrumb") ?>
<?= $breadcrumb ?>
<?= $this->endSection() ?>

<?= $this->section("halaman") ?>
    Isi Detail Nilai Rapor Fungsionaris
    <p class="tx-16 tx-bold tx-primary"><?= $data[0]->nama ?> - <?= $data[0]->nama_departemen ?></p>
<?= $this->endSection() ?>

<?= $this->section("tambah") ?>
<a href="<?= base_url("admin/rapor/isi") ?>" class="btn btn-secondary btn-sm"><i data-feather="arrow-left"></i> Kembali</a>
<?= $this->endSection() ?>

<?= $this->section("konten") ?>

<div id="accordion" class="accordion">
    <?php
    $total = array_key_last($data);
    $cek = (session()->get("id_pengurus") <= 2000) ? "" : "readonly";

    for($i = 0 ; $i <= $total ; $i+=5 ): ?>

        <h4 class="accordion-title tx-bold tx-20">
            <?php switch($data[$i]->id_bulan){
                        case(1): echo "APRIL"; break;
                        case(2): echo "JULI"; break;
                        case(3): echo "OKTOBER"; break;
            } ?>
        </h4>

        <div class="accordion-body">
            <p class="tx-16 tx-bold tx-primary">Hasil Penilaian:</p>

            <div class="row">
                <?php for($j = $i ; $j < $i+5 ; $j++): ?>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="form-group">
                            <label for="indikator<?= $j % 5 + 1 ?>" class="tx-bold">Indikator <?= $j % 5 + 1 ?></label>
                            <input id="indikator<?= $j % 5 + 1 ?>" name="indikator<?= $j % 5 + 1 ?>" type="text" value="<?= $data[$j]->nilai ?>" class="form-control" readonly>
                            <label for="kode_acara" class="tx-10 tx-gray-600"><?= $data[$j]->deskripsi ?></label>
                        </div>
                    </div>
                <?php endfor; ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <label class="tx-bold tx-danger">Auto-Grading</label>
                    <a class="btn btn-primary"
                       href="<?= base_url("admin/rapor/isi/auto/" . $data[$i]->id_pengurus . "/" . $data[$i]->id_bulan) ?>">
                        <i data-feather="play"></i> Jalankan</a>
                    <label class="tx-10 tx-danger">Tekan tombol ini sebelum melakukan pengisian nilai!</label>
                </div>
            </div>

            <hr>

            <form action="<?= base_url("admin/rapor/isi/kirim/") ?>" method="post" data-parsley-validate>
                <span class="tx-16 tx-bold tx-primary">Kolom Penilaian:</span><br>
                <p class="tx-danger">Pastikan kamu telah menekan tombol <b>Auto-Grading</b> sebelum melakukan penilaian!</p>

                <div class="row">
                    <input type="hidden" id="id_bulan" name="id_bulan" value="<?= $data[$i]->id_bulan ?>">
                    <input type="hidden" id="id_pengurus" name="id_pengurus" value="<?= $data[$i]->id_pengurus ?>">
                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="wd-20p"></td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah menjadi panitia inti (dalam kali)</td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah proker dan agenda sudah terlaksana (dalam kali)</td>
                            </tr>
                            <tr>
                                <td class="align-middle"><label for="indikator1" class="tx-bold">Indikator 1 <span class="tx-danger">*</span></label></td>
                                <td><input id="indikator1a" name="indikator1a" type="number" value="<?= $data[$i]->nilai_a ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!"></td>
                                <td><input id="indikator1b" name="indikator1b" type="number" value="<?= $data[$i]->nilai_b ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!"></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="wd-20p"></td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah mengikuti acara departemen lain (dalam kali)</td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah acara departemen lain sudah terlaksana (dalam kali)</td>
                            </tr>
                            <tr>
                                <td class="align-middle"><label for="indikator2" class="tx-bold">Indikator 2 <span class="tx-danger">*</span>
                                        <span class="tx-10 tx-normal tx-gray-600">Auto-graded</span></label></td>
                                <td><input id="indikator2a" name="indikator2a" type="number" value="<?= $data[$i+1]->nilai_a ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!" <?= $cek ?>></td>
                                <td><input id="indikator2b" name="indikator2b" type="number" value="<?= $data[$i+1]->nilai_b ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!" <?= $cek ?>></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="wd-20p"></td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah mengikuti rapat departemen (dalam kali)</td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah rapat departemen sudah terlaksana (dalam kali)</td>
                            </tr>
                            <tr>
                                <td class="align-middle"><label for="indikator3" class="tx-bold">Indikator 3 <span class="tx-danger">*</span>
                                    <span class="tx-10 tx-normal tx-gray-600">Auto-graded</span></label></td>
                                <td><input id="indikator3a" name="indikator3a" type="number" value="<?= $data[$i+2]->nilai_a ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!" <?= $cek ?>></td>
                                <td><input id="indikator3b" name="indikator3b" type="number" value="<?= $data[$i+2]->nilai_b ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!" <?= $cek ?>></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="wd-20p"></td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah mengikuti acara dengan terlambat (dalam kali)</td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah acara sudah terlaksana (dalam kali)</td>
                            </tr>
                            <tr>
                                <td class="align-middle"><label for="indikator4" class="tx-bold">Indikator 4 <span class="tx-danger">*</span>
                                        <span class="tx-10 tx-normal tx-gray-600">Auto-graded</span></label></td>
                                <td><input id="indikator4a" name="indikator4a" type="number" value="<?= $data[$i+3]->nilai_a ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!" <?= $cek ?>></td>
                                <td><input id="indikator4b" name="indikator4b" type="number" value="<?= $data[$i+3]->nilai_b ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!" <?= $cek ?>></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="wd-20p"></td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah mengikuti acara wajib (dalam kali)</td>
                                <td class="wd-40p tx-10 align-bottom tx-center tx-gray-600">Jumlah acara wajib sudah terlaksana (dalam kali)</td>
                            </tr>
                            <tr>
                                <td class="align-middle"><label for="indikator5" class="tx-bold">Indikator 5 <span class="tx-danger">*</span>
                                        <span class="tx-10 tx-normal tx-gray-600">Auto-graded</span></label></td>
                                <td><input id="indikator5a" name="indikator5a" type="number" value="<?= $data[$i+4]->nilai_a ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!" <?= $cek ?>></td>
                                <td><input id="indikator5b" name="indikator5b" type="number" value="<?= $data[$i+4]->nilai_b ?>" class="form-control form-control-sm" placeholder="Masukkan nilai" maxlength="3" required data-parsley-required-message="Bagian ini wajib diisi!" <?= $cek ?>></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="wd-20p"></td>
                                <td class="wd-80p"></td>
                            </tr>
                            <tr>
                                <td><label for="umpan_balik" class="tx-bold">Pesan <span class="tx-danger">*</span></label></td>
                                <td><textarea id="umpan_balik" name="umpan_balik" type="text" rows="3" class="form-control form-control-sm" placeholder="Masukkan umpan balik untuk perkembangan staf" required data-parsley-required-message="Bagian ini wajib diisi!"><?= $data2[$i / 5]->umpan_balik ?></textarea></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-12 col-lg-6 mt-auto">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="wd-70p align-middle">
                                    <label for="submit" class="tx-danger">
                                        Apakah pengisian nilai rapor bulan <b><?php switch($data[$i]->id_bulan){
                                                case(1): echo "April"; break;
                                                case(2): echo "Juli"; break;
                                                case(3): echo "Oktober"; break;}
                                            ?></b> sudah benar?
                                    </label>
                                </td>
                                <td class="wd-30p">
                                    <button type="submit" class="btn btn-block btn-primary btn-icon">
                                        <i data-feather="save"></i> <span> Simpan Data</span>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    <?php endfor; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    $('#accordion').accordion({
        heightStyle: 'content',
        collapsible: true,
        active: 2, // 0 -> april, 1 -> juli, 2 -> oktober
    });
</script>

<?= $this->endSection() ?>
