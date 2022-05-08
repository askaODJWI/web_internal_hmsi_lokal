<?php

namespace App\Models;

use CodeIgniter\Model;

class Tautan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tautan';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_tautan','panjang','pendek','pembuat','waktu'];
}
