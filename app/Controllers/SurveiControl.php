<?php

namespace App\Controllers;

use App\Models\Pengurus;
use App\Models\Rekap;
use App\Models\Survei;
use App\Modules\Breadcrumbs\Breadcrumbs;
use CodeIgniter\HTTP\RedirectResponse;

class SurveiControl extends BaseController
{
    public Breadcrumbs $breadcrumbs;
    public Pengurus $pengurus;
    public Survei $survei;
    public Rekap $rekap;
    public int $id_pengurus;

    public function __construct()
    {
        $this->breadcrumbs = new Breadcrumbs();
        $this->pengurus = new Pengurus();
        $this->survei = new Survei();
        $this->rekap = new Rekap();
        $this->id_pengurus = session("id_pengurus");
    }

    public function index(): string
    {
        $this->breadcrumbs->add("Beranda", "/admin/beranda");
        $this->breadcrumbs->add("Daftar Survei", "/admin/survei/dashboard");
        $breadcrumbs = $this->breadcrumbs->render();

        $query1 = $this->pengurus->select(["nrp", "id_departemen"])
            ->where("id_pengurus",$this->id_pengurus)
            ->first();

        $query2 = $this->survei->select(["(SELECT EXISTS(SELECT id_rekap FROM rekap WHERE rekap.id_survei = survei.id_survei AND nrp = $query1->nrp)) as cek"])
            ->select(["id_survei","nama_survei","tautan", "nama", "jabatan", "nama_departemen", "survei.id_departemen"])
            ->join("pengurus", "survei.pembuat = pengurus.id_pengurus")
            ->join("departemen", "pengurus.id_departemen = departemen.id_departemen")
            ->join("mhs","pengurus.nrp = mhs.nrp")
            ->orderBy("id_survei")
            ->get()
            ->getResult();

        return view("admin/survei/index",
            ["data" => $query2, "data2" => $query1, "breadcrumbs" => $breadcrumbs]);
    }

    public function detail($id_survei): string
    {
        $this->breadcrumbs->add("Beranda", "/admin/beranda");
        $this->breadcrumbs->add("Daftar Survei", "/admin/survei/dashboard");
        $this->breadcrumbs->add("Rekap Pengisian", "/admin/survei/detail/$id_survei");
        $breadcrumbs = $this->breadcrumbs->render();

        $query1 = $this->rekap->select(["mhs.nama","mhs.nrp","departemen.nama_departemen","pengurus.jabatan"])
            ->join("mhs","rekap.nrp = mhs.nrp")
            ->join("pengurus","rekap.nrp = pengurus.nrp","left outer")
            ->join("departemen","pengurus.id_departemen = departemen.id_departemen", "left outer")
            ->where("id_survei",$id_survei)
            ->orderBy("pengurus.id_departemen")
            ->get()
            ->getResult();

        $query2 = $this->survei->select("nama_survei")
            ->where("id_survei",$id_survei)
            ->first();

        return view("admin/survei/rekap",
            ["data" => $query1, "data1" => $query2, "breadcrumbs" => $breadcrumbs]);
    }

    public function tambah(): string
    {
        $this->breadcrumbs->add("Beranda", "/admin/beranda");
        $this->breadcrumbs->add("Daftar Survei", "/admin/survei/dashboard");
        $this->breadcrumbs->add("Buat Survei Baru", "/admin/survei/tambah");
        $breadcrumbs = $this->breadcrumbs->render();

        return view("admin/survei/tambah",
            ["breadcrumbs" => $breadcrumbs]);
    }

    public function tambah_kirim(): RedirectResponse
    {
        $nama_survei = $this->request->getPost("nama_survei");
        $tautan = $this->request->getPost("tautan");

        if(str_contains($tautan,"id-survei") && str_contains($tautan, "nrp"))
        {
            $query1 = $this->pengurus->where("id_pengurus",$this->id_pengurus)->first();
            $id_departemen = $query1->id_departemen;

            $query2 = $this->survei->where("id_departemen",$id_departemen)
                ->orderBy("id_survei","DESC")
                ->first();

            $nomor = (int)substr($query2->id_survei, 2, 2);
            $id_survei = (($id_departemen <= 9) ? "0" . $id_departemen : $id_departemen) . (($nomor + 1 <= 9) ? "0" . ($nomor + 1) : ($nomor + 1));

            $data = [
                "id_survei" => $id_survei,
                "nama_survei" => $nama_survei,
                "tautan" => $tautan,
                "id_departemen" => $id_departemen,
                "pembuat" => $this->id_pengurus
            ];
            $this->survei->insert($data);

            return redirect()->to(base_url("admin/survei/dashboard"))
                    ->with("berhasil","Tautan survei baru berhasil dibuat");
        }
        return redirect()->to(base_url("admin/survei/tambah"))
            ->with("error","Tautan survei harus mengandung bidang <b>'id-survei' dan 'nrp' </b>");
    }

    public function index_publik($id_survei): string
    {
        $query1 = $this->survei->where("id_survei",$id_survei)
            ->join("departemen", "survei.id_departemen = departemen.id_departemen")
            ->first();

        return view("survei/index", ["data" => $query1]);
    }
}
