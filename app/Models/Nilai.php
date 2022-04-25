<?php

namespace App\Models;

use CodeIgniter\Model;

class Nilai extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'nilai';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_nilai','id_bulan','id_pengurus','id_indikator','nilai','nilai_a','nilai_b'];
}
