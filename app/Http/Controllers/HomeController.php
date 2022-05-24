<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Reseller;
use App\Models\TransaksiReseller;
use App\Models\TransaksiToko;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
      $sold_store = TransaksiToko::sum('kuantitas');
      $sold_reseller = TransaksiReseller::sum('kuantitas');
      $count_reseller = TransaksiReseller::count();
      $available = Produk::sum('stok');
      $date_now = Carbon::now();
      $five_recent_resellers = Reseller::orderBy('created_at')->limit(5)->get(['id', 'nama_reseller', 'foto_profil', 'telp']);
      return view('home', [
        'title' => 'Beranda',
        'sold_store' => $sold_store,
        'sold_reseller' => $sold_reseller,
        'count_reseller' => $count_reseller,
        'available' => $available,
        'date_now' => [$date_now->month, $date_now->year],
        'month_name' => $date_now->locale('id_ID')->monthName,
        'five_recent_resellers' => $five_recent_resellers
      ]);
    }
}
