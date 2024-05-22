<?php

namespace App\Controllers;

use App\Models\Jadwal;
use App\Models\Piket;
use App\Modules\Breadcrumbs\Breadcrumbs;
use CodeIgniter\HTTP\RedirectResponse;
use DateTime;
use DateTimeZone;

class PiketControl extends BaseController
{
    public Breadcrumbs $breadcrumbs;
    public Piket $piket;
    public Jadwal $jadwal;
    public int $id_pengurus;
    public array $batas;

    public function __construct()
    {
        $this->breadcrumbs = new Breadcrumbs();
        $this->piket = new Piket();
        $this->jadwal = new Jadwal();
        $this->id_pengurus = session("id_pengurus");
    }

    public function index(): string
    {
        $this->breadcrumbs->add("Beranda", "/admin/beranda");
        $this->breadcrumbs->add("Kehadiran Piket", "/admin/sekre/piket/dashboard");
        $breadcrumbs = $this->breadcrumbs->render();

        $query1 = $this->piket->where("id_pengurus",$this->id_pengurus)
            ->where("status",1)
            ->countAllResults();

        $query2 = $this->jadwal->where("id_pengurus",$this->id_pengurus)
            ->first();

        $this->cek_tanggal();
        [$bawah, $atas] = $this->batas;

        $query3 = $this->piket->where("id_pengurus",$this->id_pengurus)
            ->where("waktu_datang >=",$bawah)
            ->where("waktu_datang <=",$atas)
            ->first();

        return view("admin/sekre/piket/index",
            ["data1" => $query1, "data2" => $query2, "data3" => $query3, "breadcrumbs" => $breadcrumbs]);
    }

    public function riwayat(): string
    {
        $this->breadcrumbs->add("Beranda", "/admin/beranda");
        $this->breadcrumbs->add("Riwayat Piket", "/admin/sekre/piket/riwayat");
        $breadcrumbs = $this->breadcrumbs->render();

        $this->cek_tanggal();
        [$bawah,] = $this->batas;

        $query4 = $this->piket->where("id_pengurus",$this->id_pengurus)
            ->where("waktu_datang <=",$bawah)
            ->orderBy("waktu_datang","desc")
            ->get()
            ->getResult();

        return view("admin/sekre/piket/riwayat",
            ["data4" => $query4, "breadcrumbs" => $breadcrumbs]);
    }

    public function kontrol(): string
    {
        $this->breadcrumbs->add("Beranda", "/admin/beranda");
        $this->breadcrumbs->add("Kontrol Piket", "/admin/sekre/piket/kontrol");
        $breadcrumbs = $this->breadcrumbs->render();

        $query5 = $this->jadwal->select(["(CASE WHEN jadwal.status = 0 THEN 'Belum' ELSE 'Selesai' END) as 'status'"])
            ->select(["pengurus.id_pengurus","jadwal_wajib","nama","nama_departemen"])
            ->join("pengurus", "jadwal.id_pengurus = pengurus.id_pengurus")
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->join("departemen","pengurus.id_departemen = departemen.id_departemen")
            ->orderBy("pengurus.id_departemen")
            ->orderBy("jadwal_wajib")
            ->orderBy("nama")
            ->where("jadwal_wajib >","2024-01-01")
            ->get()
            ->getResult();

        return view("admin/sekre/piket/kontrol",
            ["data5" => $query5, "breadcrumbs" => $breadcrumbs]);
    }

    public function hadir(): RedirectResponse
    {
        $waktu = (new DateTime('now'))
            ->setTimezone(new DateTimeZone('Asia/Jakarta'))
            ->format('Y-m-d H:i:s');
        $tanggal = date("Y-m-d");

        $jadwal = new Jadwal();
        $query1 = $jadwal->where("id_pengurus",$this->id_pengurus)
            ->first();
        ($query1->jadwal_wajib === $tanggal) ? $status = 0 : $status = 1;

        if($this->cek_ip() === 1)
        {
            $piket = new Piket();
            $data = [
                "id_pengurus" => $this->id_pengurus,
                "waktu_datang" => $waktu,
                "status" => $status
            ];
            $piket->insert($data);

            return redirect()->to(base_url("admin/sekre/piket/dashboard"))
                ->with("berhasil","Data kehadiran berhasil disimpan");
        }
        return redirect()->to(base_url("admin/sekre/piket/dashboard"))
            ->with("error","Kamu sedang tidak menggunakan internet lokal ITS. Gunakan <b>internet lokal ITS</b> untuk melakukan piket!");
    }

    public function pulang(): RedirectResponse
    {
        $waktu = (new DateTime('now'))
            ->setTimezone(new DateTimeZone('Asia/Jakarta'))
            ->format('Y-m-d H:i:s');
        $tanggal = date("Y-m-d");
        $bawah = (new DateTime($tanggal . "00:00:01"))
            ->setTimezone(new DateTimeZone('Asia/Jakarta'))
            ->format('Y-m-d H:i:s');
        $atas = (new DateTime($tanggal . "23:59:59"))
            ->setTimezone(new DateTimeZone('Asia/Jakarta'))
            ->format('Y-m-d H:i:s');

        $piket = new Piket();
        $query1 = $piket->where("id_pengurus",$this->id_pengurus)
            ->where("waktu_datang >=",$bawah)
            ->where("waktu_datang <=",$atas)
            ->first();

        if($query1 !== null)
        {
            if($this->cek_ip() === 1)
            {
                $jadwal = new Jadwal();
                $query2 = $jadwal->where("id_pengurus",$this->id_pengurus)
                    ->first();

                $piket->set(["waktu_keluar" => $waktu])
                    ->where("id_piket",$query1->id_piket)
                    ->update();

                if($query2->jadwal_wajib === $tanggal)
                {
                    $mulai = $query1->waktu_datang;
                    $durasi = strtotime($waktu) - strtotime($mulai);

                    if($durasi < 7200)
                    {
                        $piket->set(["waktu_keluar" => null])
                            ->where("id_piket",$query1->id_piket)
                            ->update();

                        return redirect()->to(base_url("admin/sekre/piket"))
                            ->with("error","Durasi piket belum mencapai <b>2 jam</b>. Silakan tunggu hingga 2 jam.");
                    }
                    $jadwal->set(["status" => 1])
                        ->where("id_pengurus",$this->id_pengurus)
                        ->update();

                    return redirect()->to(base_url("admin/sekre/piket/dashboard"))
                        ->with("berhasil","Terima kasih sudah melaksanakan Piket Wajib sesuai jadwal 😊");
                }
                return redirect()->to(base_url("admin/sekre/piket/dashboard"))
                    ->with("berhasil","Data kepulangan berhasil disimpan");
            }
            return redirect()->to(base_url("admin/sekre/piket/dashboard"))
                ->with("error","Kamu sedang tidak menggunakan internet lokal ITS. Gunakan <b>internet lokal ITS</b> untuk melakukan piket!");
        }
        return redirect()->to(base_url("admin/sekre/piket/dashboard"))
            ->with("error","Data kehadiran wajib diisi terlebih dahulu!");
    }

    public function ubah(): RedirectResponse
    {
        $id_pengurus = $this->request->getPost("id_pengurus");
        $tanggal = $this->request->getPost("tanggal");

        $jadwal = new Jadwal();
        $jadwal->set(["jadwal_wajib" => $tanggal])
            ->where("id_pengurus",$id_pengurus)
            ->update();

        return redirect()->to(base_url("admin/sekre/piket"))
            ->with("berhasil","Perubahan jadwal piket berhasil disimpan");
    }

    public function cek_ip()
    {
        $ip_klien = $_SERVER['HTTP_CLIENT_IP'] ?? ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']);
        $ip_valid = '/^103\.94\.(18[89]|19[01])\.([1-9]?\d|[12]\d\d)$/';

        return preg_match($ip_valid,$ip_klien);
    }

    public function cek_tanggal(): void
    {
        $tanggal = date("Y-m-d");
        $bawah = (new DateTime($tanggal . "00:00:01"))
            ->setTimezone(new DateTimeZone('Asia/Jakarta'))
            ->format('Y-m-d H:i:s');
        $atas = (new DateTime($tanggal . "23:59:59"))
            ->setTimezone(new DateTimeZone('Asia/Jakarta'))
            ->format('Y-m-d H:i:s');

        $this->batas = array($bawah, $atas);
    }
}
