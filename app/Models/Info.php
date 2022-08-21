<?php

namespace App\Models;

use CodeIgniter\Model;

class Info extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'info';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_info','detail_info'];
}
