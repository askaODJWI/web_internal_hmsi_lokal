<?php

namespace App\Controllers;

use App\Models\Rekap;

class Webhook extends BaseController
{
    public function survei(): void
    {
        $nrp = $this->request->getVar("nrp");
        $id_survei = $this->request->getVar("id_survei");

        $rekap = new Rekap();
        $rekap->insert([
            "nrp" => $nrp,
            "id_survei" => $id_survei
        ]);
    }
}
