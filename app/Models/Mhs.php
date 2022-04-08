<?php

namespace App\Models;

use CodeIgniter\Model;

class Mhs extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'mhs';
    protected $returnType       = 'object';
    protected $allowedFields    = ['nrp','nama','angkatan','prodi'];
}
