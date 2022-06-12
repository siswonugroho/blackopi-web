<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Produk;
use App\Models\TransaksiReseller;
use App\Models\TransaksiToko;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class TokoController extends Controller
{
  public function history()
  {
    $data = TransaksiToko::all();
    return view('historystore', [
      'title' => 'Riwayat Transaksi Toko',
      'list' => $data
    ]);
  }
  public function json_get_notif()
  {
    $user = Admin::find(auth('admin')->user()->getAuthIdentifier());

    $notif_collection = [];
    foreach ($user->notifications as $key => $notification) {
      $notif_collection[$key] = $notification->data;
      $notif_collection[$key]['id'] = $notification->id;
      $notif_collection[$key]['read_at'] = $notification->read_at;
      $notif_collection[$key]['created_at'] = $notification->created_at;
    }
    return response()->json($notif_collection);
  }
  public function json_count_notif()
  {
    $user = Admin::find(auth('admin')->user()->getAuthIdentifier());
    $notif_count_unread = count($user->unreadNotifications);
    return response()->json(['unread' => $notif_count_unread]);
  }
  public function json_detail_history(TransaksiToko $item)
  {
    $item->nama_produk = $item->produk()->first(['nama_produk'])->nama_produk;
    return response()->json($item);
  }
  public function json_all_history()
  {
    $data = TransaksiToko::all();
    foreach ($data as $key => $value) {
      $value->nama_produk = $value->produk()->first(['nama_produk'])->nama_produk;
    }
    return DataTables::collection($data)->toJson();
  }
  public function json_chart_history($year, $month)
  {
    $dataToko = TransaksiToko::whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
    $dataReseller = TransaksiReseller::where('status', '!=', 'cancel')->whereMonth('tanggal', $month)->whereYear('tanggal', $year)->get(['tanggal', 'kuantitas']);
    $data1 = [
      'tanggal' => [],
      'toko' => [],
      'reseller' => [],
    ];
    $dayOfMonth = Carbon::parse("$year-$month")->daysInMonth;
    $valueToko = [];
    $valueReseller = [];
    foreach ($dataToko as $value) {
      $day = Carbon::parse($value->created_at)->day;
      if (!isset($valueToko[$day])) {
        $valueToko[$day] = floatval($value->kuantitas);
      } else {
        $valueToko[$day] += $value->kuantitas;
      }
    }
    foreach ($dataReseller as $value) {
      $day = Carbon::parse($value->tanggal)->day;
      if (!isset($valueReseller[$day])) {
        $valueReseller[$day] = intval($value->kuantitas);
      } else {
        $valueReseller[$day] += $value->kuantitas;
      }
    }
    for ($i = 1; $i <= $dayOfMonth; $i++) {
      $data1['tanggal'][] = $i;
      if (array_key_exists($i, $valueToko)) {
        $data1['toko'][] = $valueToko[$i];
      } else {
        $data1['toko'][] = 0;
      }
      if (array_key_exists($i, $valueReseller)) {
        $data1['reseller'][] = $valueReseller[$i];
      } else {
        $data1['reseller'][] = 0;
      }
    }
    

    return response()->json($data1);
    die;
  }
  public function save_transaction(Request $request)
  {
    $validatedData = $request->validate([
      'id_produk' => 'required',
      'kuantitas' => 'numeric|required',
      'total_harga' => 'numeric|required',
      'jumlah_bayar' => 'numeric|required',
      'kembalian' => 'numeric|required',
    ]);
    $product_selected = Produk::find($validatedData['id_produk']);

    if ($product_selected->stok < $validatedData['kuantitas']) {
      return back()->with('sidebar_msg_ok', 'Kuantitas yang dimasukkan melebihi stok.');
    }
    $stok_baru = $product_selected->stok - $validatedData['kuantitas'];

    $transaksi = new TransaksiToko();
    $transaksi->id_produk = $validatedData['id_produk'];
    $transaksi->kuantitas = $validatedData['kuantitas'];
    $transaksi->total_harga = $validatedData['total_harga'];
    $transaksi->jumlah_bayar = $validatedData['jumlah_bayar'];
    $transaksi->kembalian = $validatedData['kembalian'];
    if ($transaksi->save()) {
      $product_selected->stok = $stok_baru;
      $product_selected->save();
      return back()->with('sidebar_msg_ok', 'Transaksi berhasil disimpan.');
    } else {
      return back()->with('sidebar_msg_error', 'Transaksi gagal disimpan.');
    }
  }
  public function view_report()
  {
    $months = [
      '1' => 'Januari',
      '2' => 'Februari',
      '3' => 'Maret',
      '4' => 'April',
      '5' => 'Mei',
      '6' => 'Juni',
      '7' => 'Juli',
      '8' => 'Agustus',
      '9' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember',
    ];
    $year = Carbon::now()->year;
    $years = [];
    for ($i=$year; $i > ($year-5); $i--) { 
      $years[] = $i;
    }
    $totals = [
      'sold_store' => TransaksiToko::sum('kuantitas'),
      'sold_reseller' => TransaksiReseller::where('status', 'selesai')->sum('kuantitas'),
      'total_rp_store' => number_format(TransaksiToko::sum('total_harga'), 0, ',', '.'),
      'total_rp_reseller' => number_format(TransaksiReseller::where('status', 'selesai')->sum('total_harga'), 0, ',', '.'),
    ];
    return view('report', [
      'title' => 'Laporan Penjualan',
      'months' => $months,
      'years' => $years,
      'total' => $totals
    ]);
  }
}
