<?php

namespace App\Models;

use CodeIgniter\Model;

class Hadir extends Model
{
    protected $DBGroup       = 'default';
    protected $table         = 'hadir';
    protected $returnType    = 'object';
    protected $allowedFields = ['id','waktu','kode_acara','nrp','keterangan'];
}
