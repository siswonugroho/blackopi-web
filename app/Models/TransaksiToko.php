<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiToko extends Model
{
    use HasFactory;
    protected $table = 'transaksi_toko';

    public function produk()
    {
      return $this->belongsTo(Produk::class, 'id_produk');
    }
}
