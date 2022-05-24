<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
  use HasFactory;
  protected $table = 'kecamatan';
  protected $primaryKey = 'subdistrict_id';

  public function kota()
  {
    return $this->belongsTo(Kota::class, 'city_id');
  }
}
