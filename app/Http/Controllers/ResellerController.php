<?php

namespace App\Http\Controllers;

use App\Events\RealTimeNotif;
use App\Models\Admin;
use App\Models\Kecamatan;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Reseller;
use App\Models\TransaksiReseller;
use App\Notifications\RealTimeNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use \Midtrans as Midtrans;
use Ramsey\Uuid\Uuid;

class ResellerController extends Controller
{
  public function __construct()
  {
    Midtrans\Config::$serverKey = config('app.midtrans_server_key');
    Midtrans\Config::$isProduction = false;
    Midtrans\Config::$isSanitized = true;
  }
  public function index()
  {
    return view('reseller', [
      'title' => 'Anggota Reseller'
    ]);
  }

  public function view_reseller_detail(Reseller $item)
  {
    $transaksi = TransaksiReseller::where('id_reseller', $item->id)->get();
    foreach ($transaksi as $key => $value) {
      $value->tanggal = Carbon::parse($value->updated_at)->format('d/m/Y H:i');
    }
    if (!is_null($item->alamat)) {
      $alamat_lengkap = [
        $item->alamat,
        $item->kecamatan()->first(['subdistrict_name'])->subdistrict_name,
        $item->kota()->first(['city_name'])->city_name,
        $item->provinsi()->first(['province_name'])->province_name,
      ];
      $item->alamat_lengkap = implode(', ', $alamat_lengkap);
    } else {
      $item->alamat_lengkap = '(belum diisi)';
    }
    return view('resellerdetail', [
      'title' => 'Detail Reseller',
      'reseller' => $item,
      'transaksi' => $transaksi
    ]);
  }

  public function view_restock(Request $request)
  {
    if ($request->has('fromnotification')) {
      $id = $request->get('fromnotification');
      $userUnreadNotification = auth()->user()
        ->unreadNotifications
        ->where('id', $id)
        ->first();

      if ($userUnreadNotification) {
        $userUnreadNotification->markAsRead();
      }
    }
    return view('restock', [
      'title' => 'Pemesanan Reseller'
    ]);
  }

  public function view_restock_detail(TransaksiReseller $item)
  {
    $detailproduk = $item->produk()->first();
    $detailreseller = $item->reseller()->first();
    $detailpembayaran = $item->pembayaran()->first();
    $item->tanggal = Carbon::parse($item->tanggal)->format('d/m/Y H:i:s');
    if ($detailpembayaran->tipe == 'bank_transfer') {
      $detailpembayaran->nama_tipe = 'Transfer Bank';
    } else if ($detailpembayaran->tipe == 'cstore') {
      $detailpembayaran->nama_tipe = 'Gerai Retail';
    }
    return view('restockdetail', [
      'title' => 'Detail Transaksi',
      'transaksi' => $item,
      'produk' => $detailproduk,
      'pembayaran' => $detailpembayaran,
      'reseller' => $detailreseller
    ]);
  }

  public function json_all_reseller()
  {
    return DataTables::collection(Reseller::all())->toJson();
  }

  public function json_all_restock()
  {
    $data = TransaksiReseller::all();
    foreach ($data as $key => $value) {
      $value->nama_reseller = $value->reseller()->first(['nama_reseller'])->nama_reseller;
      $value->nama_produk = $value->produk()->first(['nama_produk'])->nama_produk;
    }
    return DataTables::collection($data)->toJson();
  }

  public function json_restock($status)
  {
    if ($status === 'semua') {
      $data = TransaksiReseller::all();
    } else {
      $data = TransaksiReseller::where('status', $status)->get();
    }
    foreach ($data as $key => $value) {
      $value->nama_reseller = $value->reseller()->first(['nama_reseller'])->nama_reseller;
      $value->nama_produk = $value->produk()->first(['nama_produk'])->nama_produk;
    }
    return DataTables::collection($data)->toJson();
  }

  public function save_transaction(Request $request)
  {

    $validatedData = $request->validate([
      'id_produk' => 'required',
      'kuantitas' => 'numeric|required',
      'id_kurir' => 'required',
      'payment_type' => 'required',
      'payment_name' => 'required',
    ]);

    $reseller = Reseller::find(auth('sanctum')->id());

    $customer_details = [
      'first_name' => $reseller->nama_reseller,
      'last_name' => '',
      'email' => $reseller->email,
      'phone' => $reseller->telp
    ];

    $product_selected = Produk::find($validatedData['id_produk']);

    $item_details = [
      [
        'id' => $validatedData['id_produk'],
        'price' => $product_selected->harga,
        'quantity' => $validatedData['kuantitas'],
        'name' => $product_selected->nama_produk
      ]
    ];
    // return response()->json($item_details);
    // die;

    if ($product_selected->stok < $validatedData['kuantitas']) {
      return response()->json([
        'status' => 'failed',
        'message' => 'Kuantitas yang Anda masukkan melebihi stok.'
      ]);
    }
    $stok_baru = $product_selected->stok - $validatedData['kuantitas'];

    $transaction_data = [
      'payment_type' => $validatedData['payment_type'],
      'transaction_details' => [
        'order_id' => md5(auth('sanctum')->id() . '-' . date('Ymd-His')),
        'gross_amount' => $item_details[0]['price'] * $item_details[0]['quantity']
      ],
      'custom_expiry' => [
        'expiry_duration' => 60,
        'unit' => 'minute'
      ],
      'customer_details' => $customer_details,
      'item_details' => $item_details,
      'custom_field1' => $customer_details['first_name']
    ];

    if ($transaction_data['payment_type'] == 'cstore') {
      $transaction_data['cstore'] = [
        'store' => $validatedData['payment_name'],
        'message' => 'Toko Bu Tini'
      ];
    } else if ($transaction_data['payment_type'] == 'bank_transfer') {
      $transaction_data['bank_transfer'] = [
        'bank' => $validatedData['payment_name']
      ];
    }
    $id_metode_bayar = Pembayaran::where('tipe', $validatedData['payment_type'])->where('nama', $validatedData['payment_name'])->first()->id;

    $midtrans_response = Midtrans\CoreApi::charge($transaction_data);

    $transaksi = new TransaksiReseller();
    $transaksi->id_pesanan = $transaction_data['transaction_details']['order_id'];
    $transaksi->tanggal = $midtrans_response->transaction_time;
    $transaksi->id_produk = $validatedData['id_produk'];
    $transaksi->id_reseller = auth('sanctum')->id();
    $transaksi->kuantitas = $validatedData['kuantitas'];
    $transaksi->id_kurir = $validatedData['id_kurir'];
    $transaksi->total_harga = $transaction_data['transaction_details']['gross_amount'];
    $transaksi->id_metode_bayar = $id_metode_bayar;
    if ($midtrans_response->transaction_status == 'pending') {
      $transaksi->status = 'pending';
    } else if ($midtrans_response->transaction_status == 'cancel' || $midtrans_response->transaction_status == 'expire') {
      $transaksi->status = 'cancel';
    } else if ($midtrans_response->transaction_status == 'settlement') {
      $transaksi->status = 'selesai';
    }

    if ($transaksi->save()) {      // event(new RealTimeNotif('Transaksi baru dari ' . Reseller::find($validatedData['id_reseller'])->nama_reseller));
      $product_selected->stok = $stok_baru;
      $product_selected->save();
      $all_users = Admin::all();
      Notification::send($all_users, new RealTimeNotification([
        'message' => 'Pesanan baru dari ' . $customer_details['first_name'] . ' menunggu pembayaran.',
        'url' => url('/restock'),
        'icon' => 'mdi:clipboard-plus-outline'
      ]));
      $response = [
        'success' => 1,
        'id_pesanan' => $transaction_data['transaction_details']['order_id'],
        'status_pesanan' => $midtrans_response->transaction_status,
      ];
      return response()->json($response);
    } else {
      return response([
        'success' => 0,
        'message' => 'Transaksi gagal',
        'status_pesanan' => $midtrans_response->transaction_status
      ]);
    }
  }

  public function get_all_transactions()
  {
    $data = TransaksiReseller::where('id_reseller', auth('sanctum')->id())->get();
    foreach ($data as $key => $value) {
      $value->nama_produk = $value->produk()->first(['nama_produk'])->nama_produk;
    }
    // $data->put('nama_produk', $data->produk->nama_produk);

    // $user->notify(new RealTimeNotification('User mengambil data transaksi'));
    return response()->json($data);
  }

  public function get_detail_transaction($id_pesanan)
  {
    $status = Midtrans\Transaction::status($id_pesanan);
    $datefromtext = Carbon::parse($status->transaction_time);
    $response = TransaksiReseller::where('id_pesanan', $id_pesanan)->first();
    $response['payment_type'] = $status->payment_type;
    $response['payment_name'] = '';
    $response['payment_code'] = '';
    $response['expired_at'] = $datefromtext->addMinutes(60)->format('Y-m-d H:i:s');
    $response['status'] = $status->transaction_status;
    $response['msg'] = $status->status_message;
    $response['produk'] = $response->produk()->first();
    $response['kurir'] = $response->kurir()->first();
    $response['kurir']->logo = url('/img/logokurir/' . $response['kurir']->logo);

    if ($status->payment_type == 'cstore') {
      $response['payment_name'] = $status->store;
      $response['payment_code'] = $status->payment_code;
    } else if ($status->payment_type == 'bank_transfer') {
      $response['payment_name'] = $status->va_numbers[0]->bank;
      $response['payment_code'] = $status->va_numbers[0]->va_number;
    }
    return response()->json($response);
  }

  public function process_transaction(string $action, string $order_id)
  {
    try {
      if ($action == 'cancel') {
        $response = Midtrans\Transaction::cancel($order_id);
      } else if ($action == 'expire') {
        $response = Midtrans\Transaction::expire($order_id);
      }
      return response()->json($response);
    } catch (Exception $e) {
      return response();
    }
  }

  public function generate_order_id()
  {
    $datefromtext = Carbon::parse('2022-03-13 16:03:23');
    $dateplus60 = $datefromtext->addMinutes(60)->format('Y-m-d H:i:s');
    // $status = Midtrans\Transaction::status('2');
    return response()->json(['server_key' => config('app.midtrans_server_key')]);
    // return response('order-' . md5($item->id . '-' . date('Ymd-His')));
  }

  public function handle_midtrans_notifications()
  {
    $notif = new Midtrans\Notification();
    $notif = $notif->getResponse();

    $order_id = $notif->order_id;
    $transaction = $notif->transaction_status;
    $row = TransaksiReseller::where('id_pesanan', $order_id)->first();

    error_log("Order ID $order_id: " . "transaction status = $transaction");


    if ($transaction == 'settlement') {
      $row->status = 'selesai';
      $status_text = 'telah lunas.';
      $notif_icon = 'mdi:clipboard-check-outline';
    } else if ($transaction == 'cancel') {
      $row->status = 'cancel';
      $status_text = 'dibatalkan oleh reseller.';
      $notif_icon = 'mdi:clipboard-remove-outline';
    } else if ($transaction == 'expire') {
      $row->status = 'cancel';
      $status_text = 'dibatalkan karena batas waktu pembayaran habis.';
      $notif_icon = 'mdi:clipboard-remove-outline';
    } else if ($transaction == 'deny') {
      $row->status = 'cancel';
      $status_text = 'ditolak oleh sistem.';
      $notif_icon = 'mdi:clipboard-remove-outline';
    }
    $row->save();
    $all_users = Admin::find(1);
    Notification::send($all_users, new RealTimeNotification([
      'message' => 'Transaksi pesanan ' . $order_id . ' ' . $status_text,
      'url' => url('/restock'),
      'icon' => $notif_icon
    ]));
    return response('OK', 200);
  }

  public function get_user_details()
  {
    $user_details = Reseller::find(auth('sanctum')->id());
    $user_details->kecamatan = $user_details->kecamatan()->first();
    $user_details->kota = $user_details->kota()->first();
    $user_details->provinsi = $user_details->provinsi()->first();
    $user_details->foto_profil = asset('storage/upload/img/reseller/' . $user_details->foto_profil);
    return response()->json($user_details);
  }

  public function edit_profile(Request $request)
  {
    $validatedData = $request->validate([
      // 'id' => 'required',
      'nama_reseller' => 'required',
      'email' => 'required|email',
      'id_provinsi' => 'string',
      'id_kota' => 'string',
      'id_kecamatan' => 'string',
      'telp' => 'required',
      'alamat' => 'string'
    ]);
    $resellerToEdit = Reseller::find(auth('sanctum')->id());
    $resellerToEdit->nama_reseller = $validatedData['nama_reseller'];
    $resellerToEdit->email = $validatedData['email'];
    $resellerToEdit->id_provinsi = $validatedData['id_provinsi'];
    $resellerToEdit->id_kota = $validatedData['id_kota'];
    $resellerToEdit->id_kecamatan = $validatedData['id_kecamatan'];
    $resellerToEdit->telp = $validatedData['telp'];
    $resellerToEdit->alamat = $validatedData['alamat'];
    if ($resellerToEdit->save()) {
      return response()->json([
        'status' => 'success',
        'message' => 'Berhasil memperbarui profil'
      ]);
    } else {
      return response()->json([
        'status' => 'failed',
        'message' => 'Gagal memperbarui profil'
      ]);
    }
  }

  public function upload_profile_pic(Request $request)
  {
    $validatedData = $request->validate([
      // 'id' => 'required|string',
      'foto_profil' => 'image'
    ]);

    if ($request->hasFile('foto_profil')) {
      if ($request->has('foto_profil_lama')) {
        Storage::delete('upload/img/reseller/' . $request->foto_profil_lama);
      }
      $validatedData['foto_profil'] = $request->file('foto_profil')->hashName();
      $request->file('foto_profil')->store('upload/img/reseller');
    } else {
      $validatedData['foto_profil'] = $request->foto_profil_lama;
    }

    $reseller = Reseller::find(auth('sanctum')->id());
    $reseller->foto_profil = $validatedData['foto_profil'];

    if ($reseller->save()) {
      return response()->json([
        'status' => 'success',
        'message' => 'Berhasil memperbarui foto profil',
        'profil' => [
          'id' => $reseller->id,
          'nama_reseller' => $reseller->nama_reseller,
          'foto_profil' => url('storage/upload/img/reseller/' . $reseller->foto_profil),
        ]
      ]);
    } else {
      return response()->json([
        'status' => 'failed',
        'message' => 'Gagal memperbarui foto profil'
      ]);
    }
  }
}
