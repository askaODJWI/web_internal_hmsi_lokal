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
$routes->set404Override(function(){
    return view("errors/404");
});
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
    $routes->post("cek", "Presensi::cek_acara");
    $routes->post("hadir","Presensi::hadir");
    $routes->post("hadir_manual","Presensi::hadir_manual");
    $routes->get("sukses","Presensi::sukses");

    $routes->get("/(:num)","Presensi::acara/$1");
    $routes->get("/(:segment)","Admin::tautan_alih/$1");
});

$routes->group("ajax", function ($routes)
{
    $routes->get("cek_nrp/(:num)","Ajax::cek_nrp/$1");
    $routes->get("cek_pengurus/(:num)","Ajax::cek_pengurus/$1");
    $routes->get("cek_password/(:num)","Ajax::cek_password/$1");
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

    $routes->group("akun",function ($routes){
        $routes->get("ubah","Admin::akun_ubah");
        $routes->post("ubah","Admin::akun_ubah_kirim");
        $routes->post("ubah_pass","Admin::akun_ubah_pass");
    });

    $routes->group("rapor", function ($routes){
        $routes->get("dashboard","Admin::rapor_dashboard");

        $routes->get("isi","Admin::rapor_isi");
        $routes->get("isi/auto/(:num)/(:num)","Admin::rapor_isi_auto/$1/$2");
        $routes->post("isi/detail","Admin::rapor_isi_detail");
        $routes->post("isi/kirim","Admin::rapor_isi_kirim");

        $routes->get("hasil","Admin::rapor_hasil");
        $routes->post("hasil","Admin::rapor_hasil_post");
    });

    $routes->group("tautan", function ($routes){
        $routes->get("dashboard","Admin::tautan_dashboard");

        $routes->get("buat","Admin::tautan_buat");
        $routes->post("buat","Admin::tautan_buat_kirim");
    });

    $routes->group("hima",function ($routes){
        $routes->get("jadwal","Admin::hima_jadwal");
        $routes->post("jadwal/buat","Admin::hima_jadwal_buat");

        $routes->get("titip","Admin::hima_titip");
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
