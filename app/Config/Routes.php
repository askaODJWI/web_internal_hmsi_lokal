<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use App\Controllers\HadirControl;
use App\Controllers\PiketControl;
use App\Controllers\Presensi;
use App\Controllers\RaporControl;
use App\Controllers\SurveiControl;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('BaseController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function(){ return view("errors/404"); });
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group("/", function ($routes)
{
    $routes->get("", "Presensi::index");
    $routes->post("cek", "Presensi::index_kirim");
    $routes->post("hadir","Presensi::hadir");
    $routes->post("hadir_manual","Presensi::hadir_manual");
    $routes->get("sukses","Presensi::sukses");

    $routes->group("/",["filter" => "auth"],function ($routes){
        $routes->post("hadir_panitia","Presensi::hadir_panitia");
        $routes->get("p/(:num)","Presensi::acara_panitia/$1");
    });

    $routes->get("/(:num)","Presensi::acara/$1");
    $routes->get("/(:segment)","Admin::tautan_alih/$1");
});

$routes->group("ajax", function ($routes)
{
    $routes->get("cek_nrp/(:num)","Ajax::cek_nrp/$1");
    $routes->get("cek_narahubung","Ajax::cek_narahubung");
    $routes->get("cek_pengurus/(:num)","Ajax::cek_pengurus/$1");
    $routes->get("cek_password/(:num)","Ajax::cek_password/$1");
    $routes->get("cek_barang","Ajax::cek_barang");
    $routes->get("cek_info","Ajax::cek_info");
});

$routes->group("webhook", function ($routes)
{
    $routes->post("survei","Webhook::survei");
});

$routes->get("admin/login","Admin::login");
$routes->post("admin/login","Admin::login_cek");

$routes->group("admin", ['filter' => 'auth'] ,function ($routes)
{
    $routes->get("beranda","Admin::beranda");

    $routes->group("hadir", function ($routes)
    {
        $routes->get("dashboard",[HadirControl::class, "index"]);
        $routes->get("tambah",[HadirControl::class, "tambah"]);
        $routes->post("tambah",[HadirControl::class, "tambah_kirim"]);
        $routes->get("detail/(:num)",[HadirControl::class, "detail"]);
        $routes->get("rekap",[HadirControl::class, "rekap"]);
        $routes->post("rekap/detail",[HadirControl::class, "rekap_detail"]);
        $routes->get("ubah/(:num)",[HadirControl::class, "ubah"]);
        $routes->post("ubah",[HadirControl::class, "ubah_kirim"]);
        $routes->get("hapus/(:num)",[HadirControl::class, "hapus"]);
        $routes->get("tutup/(:num)",[HadirControl::class, "tutup"]);
        $routes->get("buka/(:num)",[HadirControl::class, "buka"]);
    });

    $routes->group("akun",function ($routes)
    {
        $routes->get("ubah","Admin::akun_ubah");
        $routes->post("ubah","Admin::akun_ubah_kirim");
        $routes->post("ubah_pass","Admin::akun_ubah_pass");
    });

    $routes->group("rapor", function ($routes)
    {
        $routes->get("dashboard",[RaporControl::class, "index"]);
        $routes->get("isi",[RaporControl::class, "isi"]);
        $routes->get("isi/auto/(:num)/(:num)",[RaporControl::class, "isi_auto"]);
        $routes->get("isi/detail/(:num)",[RaporControl::class, "isi_detail"]);
        $routes->post("isi/kirim",[RaporControl::class,"isi_kirim"]);
        $routes->get("hasil",[RaporControl::class, "hasil"]);
        $routes->post("hasil",[RaporControl::class, "hasil_post"]);
    });

    $routes->group("survei", function ($routes)
    {
        $routes->get("dashboard",[SurveiControl::class, "index"]);
        $routes->get("detail/(:num)",[SurveiControl::class, "detail"]);
    });

    $routes->group("sekre", function ($routes){
        $routes->group("piket", function ($routes){
            $routes->get("dashboard",[PiketControl::class,"index"]);
            $routes->get("riwayat",[PiketControl::class,"riwayat"]);
            $routes->get("kontrol",[PiketControl::class,"kontrol"]);
            $routes->post("hadir",[PiketControl::class,"hadir"]);
            $routes->post("pulang",[PiketControl::class,"pulang"]);
            $routes->post("ubah",[PiketControl::class,"ubah"]);
        });

        $routes->group("data", function ($routes){
            $routes->get("dashboard","Admin::sekre_data_dashboard");
        });
    });
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
