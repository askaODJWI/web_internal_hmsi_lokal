<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use App\Controllers\Presensi;

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
        $routes->get("dashboard","Admin::hadir_dashboard");

        $routes->get("tambah","Admin::hadir_tambah");
        $routes->post("tambah","Admin::hadir_tambah_kirim");

        $routes->get("rekap","Admin::hadir_rekap");
        $routes->post("rekap/detail","Admin::hadir_rekap_detail");

        $routes->get("ubah/(:num)","Admin::hadir_ubah/$1");
        $routes->post("ubah","Admin::hadir_ubah_kirim");

        $routes->get("hapus/(:num)","Admin::hadir_hapus/$1");

        $routes->get("tutup/(:num)","Admin::hadir_tutup/$1");
        $routes->get("buka/(:num)","Admin::hadir_buka/$1");
    });

    $routes->group("akun",function ($routes)
    {
        $routes->get("ubah","Admin::akun_ubah");
        $routes->post("ubah","Admin::akun_ubah_kirim");
        $routes->post("ubah_pass","Admin::akun_ubah_pass");
    });

    $routes->group("rapor", function ($routes)
    {
        $routes->get("dashboard","Admin::rapor_dashboard");

        $routes->get("isi","Admin::rapor_isi");
        $routes->get("isi/auto/(:num)/(:num)","Admin::rapor_isi_auto/$1/$2");
        $routes->get("isi/detail/(:num)","Admin::rapor_isi_detail/$1");
        $routes->post("isi/kirim","Admin::rapor_isi_kirim");

        $routes->get("hasil","Admin::rapor_hasil");
        $routes->post("hasil","Admin::rapor_hasil_post");
    });

    $routes->group("data", function ($routes)
    {
        $routes->get("nama","Admin::data_nama");
        $routes->post("nama","Admin::data_nama_kirim");

        $routes->get("nrp","Admin::data_nrp");
        $routes->post("nrp","Admin::data_nrp_kirim");
    });

    $routes->group("survei", function ($routes)
    {
        $routes->get("dashboard","Admin::survei_dashboard");

        $routes->get("detail/(:num)","Admin::survei_detail/$1");
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
