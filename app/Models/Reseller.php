<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Reseller extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;
  protected $guard = 'reseller';
  protected $table = 'reseller';
  protected $fillable = [
    'nama_reseller',
    'email',
    'password',
    'telp',
    'is_whatsapp',
    'alamat',
    'foto_profil'
  ];
  public function transaksi()
  {
    return $this->hasMany(TransaksiReseller::class, 'id_reseller');
  }
  public function kecamatan()
  {
    return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
  }
  public function kota()
  {
    return $this->belongsTo(Kota::class, 'id_kota');
  }
  public function provinsi()
  {
    return $this->belongsTo(Provinsi::class, 'id_provinsi');
  }
}
