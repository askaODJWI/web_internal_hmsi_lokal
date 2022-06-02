<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Acara;
use App\Models\Hadir;
use App\Models\Nilai;
use App\Models\Pengurus;
use App\Models\Rapor;
use App\Models\Tautan;

class Admin extends BaseController
{
    public function login()
    {
        return view("admin/login");
    }

    public function login_cek()
    {
        $nrp = $this->request->getPost("username");
        $pass = $this->request->getPost("password");

        $pengurus = new Pengurus();
        $query1 = $pengurus->where("nrp",$nrp)
            ->first();

        if(password_verify($pass,$query1->password))
        {
            session()->remove("id_pengurus");
            session()->set("id_pengurus",$query1->id_pengurus);

            return redirect()->to(base_url("/admin/beranda"));
        }
        return redirect()->to(base_url("admin/login"))->with("error","Nama Pengguna atau Kata Sandi <b>SALAH</b>");
    }

    public function logout()
    {
        session()->remove("id_pengurus");
        return redirect()->to(base_url("/admin/login"));
    }

    public function beranda()
    {
        $acara = new Acara();
        $nilai = new Nilai();
        $query1 = $acara->select(["nama_acara","tanggal","nama_departemen","acara.id_departemen"])
            ->where("tanggal >=", date_format(date_create(),"Y-m-d"))
            ->join("pengurus","acara.pembuat = pengurus.id_pengurus")
            ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
            ->orderBy("tanggal")
            ->limit(5)
            ->get()
            ->getResult();
        $query2 = $acara->select(["nama_departemen","COUNT(acara.id_departemen) as jumlah"])
            ->join("departemen","acara.id_departemen = departemen.id_departemen","right")
            ->groupBy("departemen.id_departemen")
            ->orderBy("departemen.id_departemen")
            ->get()
            ->getResult();
        $data2 = [
            0 => "#FFC5D9",
            1 => "#FF8BB3",
            2 => "#FF3178",
            3 => "#B52F5D",
            4 => "#87A2E8",
            5 => "#E4E378",
            6 => "#5C86F2",
            7 => "#75E0CF",
            8 => "#2052D3",
            9 => "#45BCA8",
            10 => "#359388",
            11 => "#095950",
            12 => "#2C427A"
        ];
        $query3 = $nilai->select(["pengurus.id_departemen","CAST((CAST(SUM(nilai.nilai) / (COUNT(nilai.id_pengurus) / 2) AS INT) / 2) AS INT) AS rerata"])
            ->where("nilai.id_indikator <=",2)
            ->where("nilai.id_bulan",1)
            ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
            ->groupBy("pengurus.id_departemen")
            ->orderBy("pengurus.id_departemen")
            ->get()
            ->getResult();
        $query4 = $nilai->select(["pengurus.id_departemen","CAST((CAST(SUM(nilai.nilai) / (COUNT(nilai.id_pengurus) / 3) AS INT) / 3) AS INT) AS rerata"])
            ->where("nilai.id_indikator >=",3)
            ->where("nilai.id_bulan",1)
            ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
            ->groupBy("pengurus.id_departemen")
            ->orderBy("pengurus.id_departemen")
            ->get()
            ->getResult();
        $query5 = $nilai->select("id_pengurus")
            ->where("id_bulan",1)
            ->where("nilai >",0)
            ->get()
            ->getResult();
        return view("admin/index",["data" => $query1, "data1" => $query2, "data2" => $data2, "data3" => $query3, "data4" => $query4, "data5" => $query5]);
    }

    public function hadir_dashboard()
    {
        $id_pengurus = session()->get("id_pengurus");

        $pengurus = new Pengurus();
        $query1 = $pengurus->where("id_pengurus",$id_pengurus)
            ->first();

        $acara = new Acara();
        if($id_pengurus < 2000)
        {
            $query2 = $acara
                ->join("pengurus","acara.pembuat = pengurus.id_pengurus")
                ->join("mhs","pengurus.nrp = mhs.nrp")
                ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
                ->orderBy("tanggal","desc")
                ->get()
                ->getResult();
            return view("admin/hadir/dashboard",["data" => $query2]);
        }
        $query3 = $acara->where("acara.id_departemen",$query1->id_departemen)
            ->join("pengurus","acara.pembuat = pengurus.id_pengurus")
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
            ->orderBy("tanggal","desc")
            ->get()
            ->getResult();
        return view("admin/hadir/dashboard",["data" => $query3]);
    }

    public function hadir_tambah()
    {
        return view("admin/hadir/tambah");
    }

    public function hadir_tambah_kirim()
    {
        $nama_acara = $this->request->getPost("nama_acara");
        $tanggal = $this->request->getPost("tanggal");
        $lokasi = $this->request->getPost("lokasi");
        $narahubung1 = $this->request->getPost("narahubung1");
        $no_wa1 = $this->request->getPost("no_wa1");
        $id_line1 = $this->request->getPost("id_line1");
        $tipe = $this->request->getPost("tipe");

        $pengurus = new Pengurus();
        $pembuat = session()->get("id_pengurus");
        $query1 = $pengurus->where("id_pengurus",$pembuat)->first();
        $id_departemen = $query1->id_departemen;

        if($no_wa1 === "" || $id_line1 === "")
        {
            return redirect()->to(base_url("admin/hadir/tambah"))
                ->with("error","Data Narahubung belum lengkap. Silakan melengkapi terlebih dahulu.");
        }

        $acara = new Acara();
        $query2 = $acara->where("id_departemen",$id_departemen)
            ->orderBy("kode_acara","DESC")
            ->first();
        $nomor = (int)substr($query2->kode_acara, 2, 2);
        $kode_acara = (($id_departemen <= 9) ? "0" . $id_departemen : $id_departemen) . (($nomor + 1 <= 9) ? "0" . ($nomor + 1) : ($nomor + 1));

        $data = [
            "kode_acara" => $kode_acara,
            "nama_acara" => $nama_acara,
            "id_departemen" => $id_departemen,
            "tanggal" => $tanggal,
            "lokasi" => $lokasi,
            "pembuat" => $pembuat,
            "narahubung" => $narahubung1,
            "tipe" => $tipe
        ];
        $query3 = $acara->insert($data);

        if($query3 > 0) return redirect()->to(base_url("admin/hadir/dashboard"))->with("berhasil","Data berhasil disimpan");

        return redirect()->to(base_url("admin/hadir/tambah"))->with("error","Data gagal disimpan ke Database");
    }

    public function hadir_ubah($kode_acara)
    {
        $acara = new Acara();
        $query1 = $acara->where("kode_acara", $kode_acara)
            ->join("pengurus","acara.narahubung = pengurus.id_pengurus")
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->first();

        return view("admin/hadir/ubah",["data" => $query1]);
    }

    public function hadir_ubah_kirim()
    {
        $kode_acara = $this->request->getPost("kode_acara");
        $nama_acara = $this->request->getPost("nama_acara");
        $tanggal = $this->request->getPost("tanggal");
        $lokasi = $this->request->getPost("lokasi");
        $narahubung1 = $this->request->getPost("narahubung1");
        $no_wa1 = $this->request->getPost("no_wa1");
        $id_line1 = $this->request->getPost("id_line1");
        $tipe = $this->request->getPost("tipe");

        $pengurus = new Pengurus();
        $pembuat = session()->get("id_pengurus");
        $query1 = $pengurus->where("id_pengurus",$pembuat)->first();
        $id_departemen = $query1->id_departemen;

        if($no_wa1 === "" || $id_line1 === "")
        {
            return redirect()->to(base_url("admin/hadir/tambah"))
                ->with("error","Data Narahubung belum lengkap. Silakan melengkapi terlebih dahulu.");
        }

        $acara = new Acara();
        $data = [
            "nama_acara" => $nama_acara,
            "id_departemen" => $id_departemen,
            "tanggal" => $tanggal,
            "lokasi" => $lokasi,
            "pembuat" => $pembuat,
            "narahubung" => $narahubung1,
            "tipe" => $tipe
        ];
        $query2 = $acara->set($data)
            ->where("kode_acara",$kode_acara)
            ->update();

        if($query2 > 0) return redirect()->to(base_url("admin/hadir/dashboard"))->with("berhasil","Data berhasil diperbarui");

        return redirect()->to(base_url("admin/hadir/tambah"))->with("error","Data gagal disimpan ke Database");
    }

    public function hadir_rekap()
    {
        $id_pengurus = session()->get("id_pengurus");

        $pengurus = new Pengurus();
        $query1 = $pengurus->where("id_pengurus",$id_pengurus)
            ->first();

        $acara = new Acara();

        if($id_pengurus < 2000)
        {
            $query2 = $acara->select(["nama","jabatan","nama_departemen","nama_acara","acara.kode_acara","tanggal","COUNT(hadir.kode_acara) as peserta"])
                ->join("hadir","acara.kode_acara = hadir.kode_acara")
                ->join("pengurus","acara.pembuat = pengurus.id_pengurus")
                ->join("mhs","pengurus.nrp = mhs.nrp")
                ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
                ->groupBy("acara.kode_acara")
                ->orderBy("tanggal","desc")
                ->get()
                ->getResult();
            return view("admin/hadir/rekap",["data" => $query2]);
        }
        $query3 = $acara->select(["nama","jabatan","nama_departemen","nama_acara","acara.kode_acara","tanggal","COUNT(hadir.kode_acara) as peserta"])
            ->where("acara.id_departemen",$query1->id_departemen)
            ->join("hadir","acara.kode_acara = hadir.kode_acara")
            ->join("pengurus","acara.pembuat = pengurus.id_pengurus")
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
            ->groupBy("acara.kode_acara")
            ->orderBy("tanggal","desc")
            ->get()
            ->getResult();
        return view("admin/hadir/rekap",["data" => $query3]);
    }

    public function hadir_rekap_detail()
    {
        $kode_acara = $this->request->getPost("kode_acara");
        $hadir = new Hadir();

        $query1 = $hadir->select(["mhs.nama","mhs.nrp","waktu","departemen.nama_departemen","pengurus.jabatan"])
            ->where("kode_acara", $kode_acara)
            ->join("mhs","hadir.nrp = mhs.nrp")
            ->join("pengurus","hadir.nrp = pengurus.nrp","left outer")
            ->join("departemen","pengurus.id_departemen = departemen.id_departemen","left outer")
            ->get()
            ->getResult();

        $acara = new Acara();
        $query2 = $acara->where("kode_acara", $kode_acara)
            ->first();

        return view("admin/hadir/rekap_detail",["data" => $query1, "data1" => $query2]);
    }

    public function hadir_hapus($kode_acara)
    {
        $hadir = new Hadir();
        $query1 = $hadir->where("kode_acara",$kode_acara)
            ->countAllResults();

        if($query1 === 0)
        {
            $acara = new Acara();
            $query2 = $acara->where("kode_acara", $kode_acara)
                ->delete();
            return redirect()->to(base_url("admin/hadir/dashboard"))->with('berhasil',"Acara berhasil dibatalkan");
        }
        return redirect()->to(base_url("admin/hadir/dashboard"))->with("error","Maaf, acara ini sedang berjalan sehingga tidak dapat dihapus");
    }

    public function rapor_dashboard()
    {
        $id_pengurus = session()->get("id_pengurus");

        $pengurus = new Pengurus();
        $query1 = $pengurus->where("id_pengurus",$id_pengurus)
            ->first();

        $nilai = new Nilai();

        if($id_pengurus < 2000)
        {

            $query2 = $nilai->select(["nilai.id_pengurus","nama","jabatan","nama_departemen","nilai.id_bulan","jenis","CAST(AVG(nilai) AS DOUBLE) AS nilai"])
                ->join("indikator","nilai.id_indikator = indikator.id_indikator")
                ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
                ->join("mhs","pengurus.nrp = mhs.nrp")
                ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
                ->groupBy("jenis")
                ->groupBy("nilai.id_pengurus")
                ->groupBy("nilai.id_bulan")
                ->orderBy("pengurus.id_departemen")
                ->orderBy("nama")
                ->orderBy("nilai.id_bulan")
                ->orderBy("jenis")
                ->get()
                ->getResult();
            return view("admin/rapor/dashboard",["data" => $query2]);
        }

        if($id_pengurus < 4000)
        {
            $query3 = $nilai->select(["nilai.id_pengurus","nama","jabatan","nama_departemen","nilai.id_bulan","jenis","CAST(AVG(nilai) AS DOUBLE) AS nilai"])
                ->where("pengurus.id_departemen",$query1->id_departemen)
                ->join("indikator","nilai.id_indikator = indikator.id_indikator")
                ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
                ->join("mhs","pengurus.nrp = mhs.nrp")
                ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
                ->groupBy("jenis")
                ->groupBy("nilai.id_pengurus")
                ->groupBy("nilai.id_bulan")
                ->orderBy("pengurus.id_departemen")
                ->orderBy("nama")
                ->orderBy("nilai.id_bulan")
                ->orderBy("jenis")
                ->get()
                ->getResult();
            return view("admin/rapor/dashboard",["data" => $query3]);
        }

        return view("errors/404");
    }

    public function rapor_isi()
    {
        $id_pengurus = session()->get("id_pengurus");

        $pengurus = new Pengurus();
        $query1 = $pengurus->where("id_pengurus",$id_pengurus)
            ->first();

        $nilai = new Nilai();
        if($id_pengurus < 2000)
        {
            $query2 = $nilai->select(["nama", "nilai.id_pengurus", "nama_departemen", "nilai.id_indikator", "nilai.id_bulan", "nilai"])
                ->join("indikator", "nilai.id_indikator = indikator.id_indikator")
                ->join("pengurus", "nilai.id_pengurus = pengurus.id_pengurus")
                ->join("departemen", "pengurus.id_departemen = departemen.id_departemen")
                ->join("mhs", "pengurus.nrp = mhs.nrp")
                ->orderBy("pengurus.id_departemen")
                ->orderBy("nama")
                ->orderBy("nilai.id_bulan")
                ->orderBy("id_indikator")
                ->get()
                ->getResult();

            return view("admin/rapor/isi", ["data" => $query2]);
        }

        if($id_pengurus < 4000)
        {
            $query3 = $nilai->select(["nama", "nilai.id_pengurus", "nama_departemen", "nilai.id_indikator", "nilai.id_bulan", "nilai"])
                ->where("pengurus.id_departemen",$query1->id_departemen)
                ->join("indikator", "nilai.id_indikator = indikator.id_indikator")
                ->join("pengurus", "nilai.id_pengurus = pengurus.id_pengurus")
                ->join("departemen", "pengurus.id_departemen = departemen.id_departemen")
                ->join("mhs", "pengurus.nrp = mhs.nrp")
                ->orderBy("pengurus.id_departemen")
                ->orderBy("nama")
                ->orderBy("nilai.id_bulan")
                ->orderBy("id_indikator")
                ->get()
                ->getResult();

            return view("admin/rapor/isi", ["data" => $query3]);
        }

        return view("errors/404");
    }

    public function rapor_isi_auto($id_pengurus,$id_bulan)
    {
        $pengurus = new Pengurus();
        $acara = new Acara();
        $hadir = new Hadir();
        $nilai = new Nilai();

        $query1 = $pengurus->select(["id_departemen","nama","mhs.nrp"])
            ->where("id_pengurus",$id_pengurus)
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->first();

        $nilai2a = $hadir->where("nrp",$query1->nrp)
            ->where("tipe","1")
            ->join("acara","hadir.kode_acara = acara.kode_acara")
            ->countAllResults();
        $nilai2b = $acara->where("id_departemen !=",$query1->id_departemen)
            ->where("tipe","1")
            ->countAllResults();

        $total_hadir = $hadir->where("nrp",$query1->nrp)
            ->where("tipe","1")
            ->join("acara","hadir.kode_acara = acara.kode_acara")
            ->get()
            ->getResult();

        $nilai4a = 0;
        foreach($total_hadir as $h)
        {
            $pertama = $hadir->where("kode_acara",$h->kode_acara)
                ->orderBy("waktu","asc")
                ->first();

            $waktu_telat = date("H:i", strtotime('+15 minutes', strtotime($pertama->waktu)));
            $waktu_asli = date("H:i", strtotime($h->waktu));

            if($waktu_asli > $waktu_telat) ++$nilai4a;
        }
        $nilai4b = array_key_last($total_hadir) + 1;

        $nilai5a = $hadir->where("nrp",$query1->nrp)
            ->where("tipe","0")
            ->join("acara","hadir.kode_acara = acara.kode_acara")
            ->countAllResults();
        $nilai5b = $acara->where("tipe","0")
            ->countAllResults();

        $data2 = [
            "nilai_a" => $nilai2a,
            "nilai_b" => $nilai2b,
        ];
        $query2 = $nilai->set($data2)
            ->where("id_indikator",2)
            ->where("id_bulan",$id_bulan)
            ->where("id_pengurus",$id_pengurus)
            ->update();

        $data4 = [
            "nilai_a" => $nilai4a,
            "nilai_b" => $nilai4b,
        ];
        $query4 = $nilai->set($data4)
            ->where("id_indikator",4)
            ->where("id_bulan",$id_bulan)
            ->where("id_pengurus",$id_pengurus)
            ->update();

        $data5 = [
            "nilai_a" => $nilai5a,
            "nilai_b" => $nilai5b,
        ];
        $query5 = $nilai->set($data5)
            ->where("id_indikator",5)
            ->where("id_bulan",$id_bulan)
            ->where("id_pengurus",$id_pengurus)
            ->update();

        if($query2 > 0 && $query4 > 0 && $query5 > 0) return redirect()->to(base_url("admin/rapor/isi"))
            ->with("berhasil","Penilaian secara auto-grading berhasil dilakukan");
        return redirect()->to(base_url("admin/rapor/isi"))
            ->with("error","Penilaian secara auto-grading gagal dilakukan. Ulangi lagi proses auto-grading!");
    }

    public function rapor_isi_detail()
    {
        $id_pengurus = $this->request->getPost("id_pengurus");

        $nilai = new Nilai();
        $rapor = new Rapor();

        $query1 = $nilai->select(["nama","nilai.id_pengurus","nilai.id_indikator","nilai.id_bulan","nilai","nilai_a","nilai_b","deskripsi","nama_departemen"])
            ->where("nilai.id_pengurus",$id_pengurus)
            ->join("indikator","nilai.id_indikator = indikator.id_indikator")
            ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
            ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->orderBy("pengurus.id_departemen")
            ->orderBy("nama")
            ->orderBy("nilai.id_bulan")
            ->orderBy("id_indikator")
            ->get()
            ->getResult();
        $query2 = $rapor->where("id_pengurus",$id_pengurus)
            ->get()
            ->getResult();

        return view("admin/rapor/isi_detail",["data" => $query1, "data2" => $query2]);
    }

    public function rapor_isi_kirim()
    {
        $id_bulan = $this->request->getPost("id_bulan");
        $id_pengurus = $this->request->getPost("id_pengurus");
        $indikator1a = $this->request->getPost("indikator1a");
        $indikator1b = $this->request->getPost("indikator1b");
        $indikator2a = $this->request->getPost("indikator2a");
        $indikator2b = $this->request->getPost("indikator2b");
        $indikator3a = $this->request->getPost("indikator3a");
        $indikator3b = $this->request->getPost("indikator3b");
        $indikator4a = $this->request->getPost("indikator4a");
        $indikator4b = $this->request->getPost("indikator4b");
        $indikator5a = $this->request->getPost("indikator5a");
        $indikator5b = $this->request->getPost("indikator5b");
        $umpan_balik = $this->request->getPost("umpan_balik");

        switch($indikator1a)
        {
            case(0):
                $nilai1 = 50; break;
            case(1):
                $nilai1 = 75; break;
            default:
                $nilai1 = 100; break;
        }
        switch($indikator2a)
        {
            case(0):
                $nilai2 = 50; break;
            case(1):
                $nilai2 = 67; break;
            case(2):
                $nilai2 = 84; break;
            default:
                $nilai2 = 100; break;
        }
        $nilai3 = ($indikator3b === "0") ?  50 : max((ceil(($indikator3a / $indikator3b) * 100)),50);
        switch($indikator4a)
        {
            case(0):
                $nilai4 = 100; break;
            case(1):
                $nilai4 = 90; break;
            case(2):
                $nilai4 = 80; break;
            case(3):
                $nilai4 = 70; break;
            case(4):
                $nilai4 = 60; break;
            default:
                $nilai4 = 50; break;
        }
        switch($indikator5a)
        {
            case(0):
                $nilai5 = 50; break;
            case(1):
                $nilai5 = 60; break;
            case(2):
                $nilai5 = 70; break;
            case(3):
                $nilai5 = 80; break;
            case(4):
                $nilai5 = 90; break;
            default:
                $nilai5 = 100; break;
        }

        $nilai = new Nilai();
        $data1 = [
            "nilai" => $nilai1,
            "nilai_a" => $indikator1a,
            "nilai_b" => $indikator1b,
        ];
        $query1 = $nilai->set($data1)
            ->where("id_bulan",$id_bulan)
            ->where("id_pengurus",$id_pengurus)
            ->where("id_indikator",1)
            ->update();
        $data2 = [
            "nilai" => $nilai2,
            "nilai_a" => $indikator2a,
            "nilai_b" => $indikator2b,
        ];
        $query2 = $nilai->set($data2)
            ->where("id_bulan",$id_bulan)
            ->where("id_pengurus",$id_pengurus)
            ->where("id_indikator",2)
            ->update();
        $data3 = [
            "nilai" => $nilai3,
            "nilai_a" => $indikator3a,
            "nilai_b" => $indikator3b,
        ];
        $query3 = $nilai->set($data3)
            ->where("id_bulan",$id_bulan)
            ->where("id_pengurus",$id_pengurus)
            ->where("id_indikator",3)
            ->update();
        $data4 = [
            "nilai" => $nilai4,
            "nilai_a" => $indikator4a,
            "nilai_b" => $indikator4b,
        ];
        $query4 = $nilai->set($data4)
            ->where("id_bulan",$id_bulan)
            ->where("id_pengurus",$id_pengurus)
            ->where("id_indikator",4)
            ->update();
        $data5 = [
            "nilai" => $nilai5,
            "nilai_a" => $indikator5a,
            "nilai_b" => $indikator5b,
        ];
        $query5 = $nilai->set($data5)
            ->where("id_bulan",$id_bulan)
            ->where("id_pengurus",$id_pengurus)
            ->where("id_indikator",5)
            ->update();

        $rapor = new Rapor();
        $query6 = $rapor->set(["umpan_balik" => $umpan_balik])
            ->where("id_pengurus",$id_pengurus)
            ->where("id_bulan",$id_bulan)
            ->update();

        if($query1 > 0 && $query2 > 0 && $query3 > 0 && $query4 > 0 && $query5 > 0 && $query6 > 0)
            return redirect()->to(base_url("admin/rapor/isi"))->with("berhasil","Pengisian nilai rapor berhasil disimpan");

        return redirect()->to(base_url("admin/rapor/isi"))->with("error","Pengisian nilai rapor gagal disimpan");
    }

    public function rapor_hasil()
    {
        $id_pengurus = session()->get("id_pengurus");

        $nilai = new Nilai();
        $rapor = new Rapor();
        $query1 = $nilai->where("nilai.id_pengurus",$id_pengurus)
            ->where("nilai <>",0)
            ->get()
            ->getResult();

        $query2 = $rapor->where("id_pengurus",$id_pengurus)
            ->get()
            ->getResult();

        switch(array_key_last($query1))
        {
            case(4):case(5):case(6):case(7):case(8):
                $query3 = $nilai->select(["nama","nilai.id_pengurus","nilai.id_indikator","nilai.id_bulan","nilai","deskripsi","nama_departemen","jabatan"])
                    ->where("nilai.id_pengurus",$id_pengurus)
                    ->where("nilai.id_bulan",1)
                    ->join("indikator","nilai.id_indikator = indikator.id_indikator")
                    ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
                    ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
                    ->join("mhs","pengurus.nrp = mhs.nrp")
                    ->orderBy("pengurus.id_departemen")
                    ->orderBy("nama")
                    ->orderBy("nilai.id_bulan")
                    ->orderBy("id_indikator")
                    ->get()
                    ->getResult();
                return view("admin/rapor/hasil",["data" => $query3, "data2" => $query2]);
            case(9):case(10):case(11):case(12):case(13):
                $query3 = $nilai->select(["nama","nilai.id_pengurus","nilai.id_indikator","nilai.id_bulan","nilai","deskripsi","nama_departemen","jabatan"])
                    ->where("nilai.id_pengurus",$id_pengurus)
                    ->where("nilai.id_bulan <>",3)
                    ->join("indikator","nilai.id_indikator = indikator.id_indikator")
                    ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
                    ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
                    ->join("mhs","pengurus.nrp = mhs.nrp")
                    ->orderBy("pengurus.id_departemen")
                    ->orderBy("nama")
                    ->orderBy("nilai.id_bulan")
                    ->orderBy("id_indikator")
                    ->get()
                    ->getResult();
                return view("admin/rapor/hasil",["data" => $query3, "data2" => $query2]);
            case(14):
                $query3 = $nilai->select(["nama","nilai.id_pengurus","nilai.id_indikator","nilai.id_bulan","nilai","deskripsi","nama_departemen","jabatan"])
                    ->where("nilai.id_pengurus",$id_pengurus)
                    ->join("indikator","nilai.id_indikator = indikator.id_indikator")
                    ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
                    ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
                    ->join("mhs","pengurus.nrp = mhs.nrp")
                    ->orderBy("pengurus.id_departemen")
                    ->orderBy("nama")
                    ->orderBy("nilai.id_bulan")
                    ->orderBy("id_indikator")
                    ->get()
                    ->getResult();
                return view("admin/rapor/hasil",["data" => $query3, "data2" => $query2]);
            default:
                break;
        }

        return redirect()->to(base_url("admin/beranda"))
            ->with("error","Maaf, Rapor Fungsionaris milikmu belum siap. Hubungi Kepala Departemen untuk <b>simpan permanen</b> nilai!");
    }

    public function rapor_hasil_post()
    {
        $id_pengurus = $this->request->getPost("id_pengurus");
        $id_bulan = $this->request->getPost("id_bulan");

        $nilai = new Nilai();
        $rapor = new Rapor();

        $query1 = $rapor->where("id_pengurus",$id_pengurus)
            ->where("id_bulan",$id_bulan)
            ->get()
            ->getResult();
        $query2 = $nilai->select(["nama","nilai.id_pengurus","nilai.id_indikator","nilai.id_bulan","nilai","deskripsi","nama_departemen","jabatan"])
            ->where("nilai.id_pengurus",$id_pengurus)
            ->where("nilai.id_bulan",$id_bulan)
            ->join("indikator","nilai.id_indikator = indikator.id_indikator")
            ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
            ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->orderBy("pengurus.id_departemen")
            ->orderBy("nama")
            ->orderBy("nilai.id_bulan")
            ->orderBy("id_indikator")
            ->get()
            ->getResult();
        return view("admin/rapor/hasil",["data" => $query2, "data2" => $query1]);
    }

    public function tautan_dashboard()
    {
        $id_pengurus = session()->get("id_pengurus");

        $tautan = new Tautan();
        if($id_pengurus < 2000)
        {
            $query1 = $tautan->join("pengurus","tautan.pembuat = pengurus.id_pengurus")
                ->join("mhs","pengurus.nrp = mhs.nrp")
                ->get()
                ->getResult();
            return view("admin/tautan/dashboard",["data" => $query1]);
        }
        $query2 = $tautan->where("id_pengurus",$id_pengurus)
            ->join("pengurus","tautan.pembuat = pengurus.id_pengurus")
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->get()
            ->getResult();
        return view("admin/tautan/dashboard",["data" => $query2]);
    }

    public function tautan_buat()
    {
        return view("admin/tautan/buat");
    }

    public function tautan_buat_kirim()
    {
        $id_pengurus = session()->get("id_pengurus");
        $panjang = $this->request->getPost("panjang");
        $pendek = $this->request->getPost("pendek");
        $waktu = (new \DateTime('now'))
            ->setTimezone(new \DateTimeZone('Asia/Jakarta'))
            ->format('Y-m-d H:i:s');

        $tautan = new Tautan();
        $query1 = $tautan->where("pendek",$pendek)
            ->countAllResults();

        if($query1 === 0)
        {
            if(filter_var($panjang, FILTER_VALIDATE_URL) === false) $panjang = "https://" . $panjang;
            $data = [
                "panjang" => $panjang,
                "pendek" => $pendek,
                "pembuat" => $id_pengurus,
                "waktu" => $waktu,
            ];
            $query2 = $tautan->insert($data);

            if($query2 > 0) return redirect()->to(base_url("admin/tautan/dashboard"))
                ->with("berhasil","Pembuatan peringkas tautan baru telah berhasil");
            return redirect()->to(base_url("admin/tautan/buat"))
                ->with("error","Pembuatan peringkas tautan baru gagal disimpan");
        }
        return redirect()->to(base_url("admin/tautan/buat"))
            ->with("error","Tautan ini sudah dipakai oleh orang lain. Silakan gunakan tautan lainnya.");
    }

    public function tautan_alih($pendek)
    {
        $tautan = new Tautan();
        $query1 = $tautan->select("panjang")
            ->where("pendek",$pendek)
            ->first();

        if($query1 !== null) return redirect()->to($query1->panjang);
        return view("errors/404");
    }

    public function akun_ubah()
    {
        $id_pengurus = session()->get("id_pengurus");

        $pengurus = new Pengurus();
        $query1 = $pengurus->where("id_pengurus",$id_pengurus)
            ->first();

        return view("admin/ubah",["data" => $query1]);
    }

    public function akun_ubah_kirim()
    {
        $id_pengurus = session()->get("id_pengurus");
        $nama_panggilan = $this->request->getPost("nama_panggilan");
        $id_line = $this->request->getPost("id_line");
        $no_wa = $this->request->getPost("no_wa");

        $pengurus = new Pengurus();
        $data = [
            "nama_panggilan" => $nama_panggilan,
            "id_line" => $id_line,
            "no_wa" => $no_wa
        ];
        $query1 = $pengurus->set($data)
            ->where("id_pengurus",$id_pengurus)
            ->update();

        return redirect()->to("admin/akun/ubah")->with("berhasil","Kontak untuk narahubung berhasil diperbarui");
    }

    public function akun_ubah_pass()
    {
        $id_pengurus = session()->get("id_pengurus");
        $pass_lama = $this->request->getPost("pass_lama");
        $pass_baru1 = $this->request->getPost("pass_baru1");
        $pass_baru2 = $this->request->getPost("pass_baru2");

        if($pass_baru1 === $pass_baru2)
        {
            $pengurus = new Pengurus();
            $query1 = $pengurus->select("password")
                ->where("id_pengurus",$id_pengurus)
                ->first();

            if(password_verify($pass_lama,$query1->password))
            {
                $pass_baru = password_hash($pass_baru1,PASSWORD_DEFAULT);
                $query2 = $pengurus->set("password",$pass_baru)
                    ->where("id_pengurus",$id_pengurus)
                    ->update();

                if($query2 > 0) return redirect()->to(base_url("admin/beranda"))->with("berhasil","Kata Sandi berhasil diperbarui");
            }
            return redirect()->to(base_url("admin/akun/ubah"))->with("error","Kata Sandi yang dimasukkan <b>SALAH</b>");
        }
        return redirect()->to(base_url("admin/akun/ubah"))->with("error","Kata Sandi baru <b>TIDAK COCOK</b>");
    }
}
