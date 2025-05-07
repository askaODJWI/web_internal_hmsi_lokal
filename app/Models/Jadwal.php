<?php

namespace App\Models;

use CodeIgniter\Model;

class Jadwal extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jadwal';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_pengurus','jadwal_wajib','status'];
}
