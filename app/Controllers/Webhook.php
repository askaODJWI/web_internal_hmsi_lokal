<?php

namespace App\Controllers;

use App\Models\Rekap;

class Webhook extends BaseController
{
    public function survei()
    {
        $nrp = $this->request->getVar("nrp");
        $id_survei = $this->request->getVar("id_survei");

        $rekap = new Rekap();
        $query1 = $rekap->insert([
            "nrp" => $nrp,
            "id_survei" => $id_survei
        ]);
    }
}
