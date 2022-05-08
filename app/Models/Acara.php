<?php

namespace App\Models;

use CodeIgniter\Model;

class Acara extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'acara';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_acara','kode_acara','nama_acara','id_departemen','tanggal','lokasi','pembuat','narahubung','tipe'];
}
