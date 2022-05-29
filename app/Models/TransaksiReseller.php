<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiReseller extends Model
{
  use HasFactory;
  protected $table = 'transaksi_reseller';
  public function reseller()
  {
    return $this->belongsTo(Reseller::class, 'id_reseller');
  }
  public function produk()
  {
    return $this->belongsTo(Produk::class, 'id_produk');
  }
  public function pembayaran()
  {
    return $this->belongsTo(Pembayaran::class, 'id_metode_bayar');
  }
  public function kurir()
  {
    return $this->belongsTo(Kurir::class, 'id_kurir');
  }
}
