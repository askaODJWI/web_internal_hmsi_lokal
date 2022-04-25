<?php

namespace App\Models;

use CodeIgniter\Model;

class Rapor extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rapor';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_rapor','id_pengurus','id_bulan','umpan_balik'];
}
