<?php

namespace App\Models;

use CodeIgniter\Model;

class Produk extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'produk';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode_barang','nama_barang','harga_jual','stok'];
}
