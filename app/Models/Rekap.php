<?php

namespace App\Models;

use CodeIgniter\Model;

class Rekap extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rekap';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_rekap','id_survei','nrp'];
}
