<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
  use HasFactory, HasApiTokens, Notifiable;
  protected $guard = 'admin';
  protected $table = 'admin';
  protected $fillable = [
    'nama_admin',
    'email',
    'password',
  ];
}
