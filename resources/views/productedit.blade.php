@extends('layouts.app')

@section('content')
<main class="container my-4 d-flex flex-column">
  <header class="my-3">
    <h3 class="fw-bold m-0">Edit Info Produk</h3>
  </header>
  <form action="{{ url('product/edit') }}" method="post" enctype="multipart/form-data">
    @csrf
    <section class="row my-3 gx-5">
      <div class="col-auto">
        <figure class="img-product-detail">
          <img src="{{ asset('storage/upload/img/' . $produk->foto_produk) }}" alt="Kopi 1" class="rounded w-100 h-100 preview_foto">
          <div class="my-3">
            <input type="file" hidden name="foto_produk" id="foto_produk" class="input_foto"
              accept="image/jpg, image/jpeg, image/png">
            <label for="foto_produk" class="btn btn-primary-light">Ubah foto</label>
          </div>
        </figure>
      </div>
      <div class="col">
        <div class="forms">
          <input type="hidden" name="id" value="{{ $produk->id }}">
          <input type="hidden" name="foto_produk_lama" value="{{ $produk->foto_produk }}">
          <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" value="{{ $produk->nama_produk }}" name="nama_produk" id="nama_produk"
              class="form-control">
          </div>
          <div class="row row-cols-2">
            <div class="mb-3">
              <label for="harga" class="form-label">Harga per kg (RP)</label>
              <input type="number" value="{{ $produk->harga }}" min="0" name="harga" id="harga" class="form-control">
            </div>
            <div class="mb-3">
              <label for="stok" class="form-label">Stok (kg)</label>
              <input type="number" value="{{ $produk->stok }}" min="0" name="stok" id="stok" class="form-control">
            </div>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Produk</label>
            <textarea name="deskripsi" id="deskripsi" rows="6" class="form-control">{{ $produk->deskripsi }}</textarea>
          </div>
          <div class="hstack gap-3 justify-content-end">
            <a href="{{ url('product/' . $produk->id) }}" class="btn btn-primary-light">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </div>
    </section>
  </form>
</main>
@endsection
@push('script')
<script src="{{ asset('js/imagepreview.js') }}"></script>
@endpush