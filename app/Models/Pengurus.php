<?php

namespace App\Models;

use CodeIgniter\Model;

class Pengurus extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pengurus';
    protected $returnType       = 'object';
    protected $allowedFields    = ['nama_panggilan','no_wa','id_line','password'];
}
