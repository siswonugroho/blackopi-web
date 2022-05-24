<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
  use HasFactory;
  protected $table = 'provinsi';
  protected $primaryKey = 'province_id';

  public function kota()
  {
    return $this->hasMany(Kota::class, 'province_id');
  }
}
