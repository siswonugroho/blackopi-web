<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  public function index()
  {
    $products = Produk::all();
    return view('products', [
      'title' => 'Produk',
      'produk' => $products
    ]);
  }
  public function detail(Produk $item)
  {
    return view('productdetail', [
      'title' => 'Produk',
      'produk' => $item
    ]);
  }
  public function api_detail(Produk $item)
  {
    return response($item);
  }
  public function view_edit(Produk $item)
  {
    return view('productedit', [
      'title' => 'Edit Produk ' . $item->nama_produk,
      'produk' => $item
    ]);
  }
  public function edit(Request $request)
  {
    $validatedData = $request->validate([
      'id' => 'required',
      'nama_produk' => 'required|max:255',
      'harga' => 'required|numeric',
      'stok' => 'required|numeric',
      'deskripsi' => 'required',
      'foto_produk' => 'image'
    ]);

    if ($request->hasFile('foto_produk')) {
      if ($request->has('foto_produk_lama')) {
        File::delete('upload/img/' . $request->foto_produk_lama);
      }
      $validatedData['foto_produk'] = $request->file('foto_produk')->hashName();
      $request->file('foto_produk')->move('upload/img', $validatedData['foto_produk']);
    } else {
      $validatedData['foto_produk'] = $request->foto_produk_lama;
    }

    $produk = Produk::find($validatedData['id']);
    $produk->nama_produk = $validatedData['nama_produk'];
    $produk->harga = $validatedData['harga'];
    $produk->stok = $validatedData['stok'];
    $produk->deskripsi = $validatedData['deskripsi'];
    $produk->foto_produk = $validatedData['foto_produk'];

    if ($produk->save()) {
      return redirect('product/' . $validatedData['id'])->with('success_msg', 'Perubahan berhasil disimpan.');
    } else {
      return redirect('product/' . $validatedData['id'])->with('error_msg', 'Gagal menyimpan perubahan.');
    }
  }

  public function get_product_by_id(Produk $item)
  {
    $item->foto_produk = asset('storage/upload/img/' . $item->foto_produk);
    return response($item);
  }
}
