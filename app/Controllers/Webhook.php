<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Rekap;

class Webhook extends BaseController
{
    public function survei()
    {
        $request = service("request");
        $id_pengurus = $request->getVar("id_pengurus");
        $id_survei = $request->getVar("id_survei");

        $rekap = new Rekap();
        $query1 = $rekap->insert([
            "id_pengurus" => $id_pengurus,
            "id_survei" => $id_survei
        ]);
    }
}
