<?php

namespace App\Models;

use CodeIgniter\Model;

class Piket extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'piket';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_piket','id_pengurus','waktu_datang','waktu_keluar','status'];
}
