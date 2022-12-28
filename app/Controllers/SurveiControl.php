<?php

namespace App\Controllers;

use App\Models\Pengurus;
use App\Models\Rekap;
use App\Models\Survei;
use App\Modules\Breadcrumbs\Breadcrumbs;

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

        $query1 = $this->pengurus->select("nrp")
            ->where("id_pengurus",$this->id_pengurus)
            ->first();
        $nrp = $query1->nrp;

        $query2 = $this->survei->select(["(SELECT EXISTS(SELECT id_rekap FROM rekap WHERE rekap.id_survei = survei.id_survei AND nrp = $nrp)) as cek"])
            ->select(["id_survei","nama_survei","tautan"])
            ->orderBy("id_survei")
            ->get()
            ->getResult();

        return view("admin/survei/index",
            ["data" => $query2, "data2" => $nrp, "breadcrumbs" => $breadcrumbs]);
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
}
