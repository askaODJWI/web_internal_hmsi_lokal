<?php

namespace App\Controllers;

use App\Models\Acara;
use App\Models\Hadir;
use App\Models\Jadwal;
use App\Models\Mhs;
use App\Models\Nilai;
use App\Models\Pengurus;
use App\Models\Piket;
use App\Models\Rapor;
use App\Models\Rekap;
use App\Models\Survei;
use App\Models\Tautan;
use App\Modules\Breadcrumbs\Breadcrumbs;

class Admin extends BaseController
{
    public Breadcrumbs $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = new Breadcrumbs();
    }

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

        if($query1 !== null && password_verify($pass,$query1->password))
        {
            session()->remove("id_pengurus");
            session()->set("id_pengurus",$query1->id_pengurus);

            return redirect()->to(base_url("/admin/beranda"));
        }
        return redirect()->to(base_url("admin/login"))
            ->with("error","Nama Pengguna atau Kata Sandi <b>SALAH</b>");
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

        $sekarang = new \DateTime("now");
        $bulan1_awal = new \DateTime("2022-01-01 00:00:00");
        $bulan1_akhir = new \DateTime("2022-07-24 23:59:59");
        $bulan2_awal = new \DateTime("2022-07-25 00:00:00");
        $bulan2_akhir = new \DateTime("2022-10-24 23:59:59");
        $bulan3_awal = new \DateTime("2022-10-25 00:00:00");
        $bulan3_akhir = new \DateTime("2022-12-31 23:59:59");

        if($sekarang >= $bulan1_awal && $sekarang <= $bulan1_akhir) $id_bulan = 1;
        else if($sekarang >= $bulan2_awal && $sekarang <= $bulan2_akhir) $id_bulan = 2;
        else if($sekarang >= $bulan3_awal && $sekarang <= $bulan3_akhir) $id_bulan = 3;

        $query3 = $nilai->select(["pengurus.id_departemen","CAST((CAST(SUM(nilai.nilai) / (COUNT(nilai.id_pengurus) / 2) AS INT) / 2) AS INT) AS rerata"])
            ->where("nilai.id_indikator <=",2)
            ->where("nilai.id_bulan",$id_bulan)
            ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
            ->groupBy("pengurus.id_departemen")
            ->orderBy("pengurus.id_departemen")
            ->get()
            ->getResult();
        $query4 = $nilai->select(["pengurus.id_departemen","CAST((CAST(SUM(nilai.nilai) / (COUNT(nilai.id_pengurus) / 3) AS INT) / 3) AS INT) AS rerata"])
            ->where("nilai.id_indikator >=",3)
            ->where("nilai.id_bulan",$id_bulan)
            ->join("pengurus","nilai.id_pengurus = pengurus.id_pengurus")
            ->groupBy("pengurus.id_departemen")
            ->orderBy("pengurus.id_departemen")
            ->get()
            ->getResult();
        $query5 = $nilai->select("id_pengurus")
            ->where("id_bulan",$id_bulan)
            ->where("nilai >",0)
            ->get()
            ->getResult();
        return view("admin/index",["data" => $query1, "data1" => $query2, "data2" => $data2, "data3" => $query3, "data4" => $query4, "data5" => $query5]);
    }

    public function sekre_data_dashboard()
    {
        $this->breadcrumbs->add("Beranda", "/admin/beranda");
        $this->breadcrumbs->add("Data Mahasiswa", "/admin/data/nama");
        $breadcrumbs = $this->breadcrumbs->render();

        $mhs = new Mhs();
        $query1 = $mhs->get()
            ->getResult();

        return view("admin/sekre/data/dashboard",["data" => $query1, "breadcrumbs" => $breadcrumbs]);
    }

    public function akun_ubah()
    {
        $this->breadcrumbs->add("Beranda", "/admin/beranda");
        $this->breadcrumbs->add("Ubah Profil", "/admin/akun/ubah");
        $breadcrumbs = $this->breadcrumbs->render();

        $id_pengurus = session()->get("id_pengurus");

        $pengurus = new Pengurus();
        $query1 = $pengurus->where("id_pengurus",$id_pengurus)
            ->first();

        return view("admin/ubah",["data" => $query1, "breadcrumbs" => $breadcrumbs]);
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

        return redirect()->to("admin/akun/ubah")
            ->with("berhasil","Kontak untuk narahubung berhasil diperbarui");
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

                if($query2 > 0)
                {
                    return redirect()->to(base_url("admin/beranda"))
                        ->with("berhasil","Kata Sandi berhasil diperbarui");
                }
            }
            return redirect()->to(base_url("admin/akun/ubah"))
                ->with("error","Kata Sandi yang dimasukkan <b>SALAH</b>");
        }
        return redirect()->to(base_url("admin/akun/ubah"))
            ->with("error","Kata Sandi baru <b>TIDAK COCOK</b>");
    }

    public function tautan_alih($pendek)
    {
        $tautan = new Tautan();
        $query1 = $tautan->select("panjang")
            ->where("pendek",$pendek)
            ->first();

        if($query1 !== null)
        {
            return redirect()->to($query1->panjang);
        }
        return view("errors/404");
    }
}