<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Acara;
use App\Models\Hadir;
use App\Models\Pengurus;

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
            4 => "#E4E378",
            5 => "#87A2E8",
            6 => "#45BCA8",
            7 => "#5C86F2",
            8 => "#45BCA8",
            9 => "#2052D3",
            10 => "#359388",
            11 => "#0A5950",
            12 => "#2C427A"
        ];
        return view("admin/index",["data" => $query1, "data1" => $query2, "data2" => $data2]);
    }

    public function hadir_dashboard()
    {
        $id_pengurus = session()->get("id_pengurus");

        $pengurus = new Pengurus();
        $query1 = $pengurus->where("id_pengurus",$id_pengurus)
            ->first();

        $acara = new Acara();
        if($id_pengurus <= 2000)
        {
            $query2 = $acara
                ->join("pengurus","acara.pembuat = pengurus.id_pengurus")
                ->join("mhs","pengurus.nrp = mhs.nrp")
                ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
                ->get()
                ->getResult();
            return view("admin/hadir/dashboard",["data" => $query2]);
        }
        $query3 = $acara->where("acara.id_departemen",$query1->id_departemen)
            ->join("pengurus","acara.pembuat = pengurus.id_pengurus")
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
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
        $kode_acara = $this->request->getPost("kode_acara");
        $nama_acara = $this->request->getPost("nama_acara");
        $tanggal = $this->request->getPost("tanggal");
        $lokasi = $this->request->getPost("lokasi");
        $narahubung1 = $this->request->getPost("narahubung1");
        $no_wa1 = $this->request->getPost("no_wa1");
        $id_line1 = $this->request->getPost("id_line1");

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
            "kode_acara" => $kode_acara,
            "nama_acara" => $nama_acara,
            "id_departemen" => $id_departemen,
            "tanggal" => $tanggal,
            "lokasi" => $lokasi,
            "pembuat" => $pembuat,
            "narahubung" => $narahubung1
        ];
        $query2 = $acara->insert($data);

        if($query2 > 0) return redirect()->to(base_url("admin/hadir/dashboard"))->with("berhasil","Data berhasil disimpan");

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
            "narahubung" => $narahubung1
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
        $hadir = new Hadir();

        if($id_pengurus <= 2000)
        {
            $query2 = $acara->select(["nama","jabatan","nama_departemen","nama_acara","acara.kode_acara","tanggal","COUNT(hadir.kode_acara) as peserta"])
                ->join("hadir","acara.kode_acara = hadir.kode_acara")
                ->join("pengurus","acara.pembuat = pengurus.id_pengurus")
                ->join("mhs","pengurus.nrp = mhs.nrp")
                ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
                ->groupBy("acara.kode_acara")
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

                if($query2 > 0) return redirect()->to(base_url("admin/akun/ubah"))->with("berhasil","Kata Sandi berhasil diperbarui");
            }
            return redirect()->to(base_url("admin/akun/ubah"))->with("error","Kata Sandi yang dimasukkan <b>SALAH</b>");
        }
        return redirect()->to(base_url("admin/akun/ubah"))->with("error","Kata Sandi baru <b>TIDAK COCOK</b>");
    }
}
