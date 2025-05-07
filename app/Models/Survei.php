<?php

namespace App\Models;

use CodeIgniter\Model;

class Survei extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'survei';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_survei','id_departemen','nama_survei','tautan','pembuat'];
}
