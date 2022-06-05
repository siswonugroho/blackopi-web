@extends('layouts.app')

@section('content')
    <div class="row m-0">
      @include('layouts.sidebar')
      <main class="col m-4 d-flex flex-column">
        <header class="my-3 d-flex justify-content-between align-items-center">
          <div class="main-title">
            <h3 class="fw-bold">Produk Kopi</h3>
            <p class="m-0">Total 6 produk</p>
          </div>
          <div class="search-box">
            <div class="input-group rounded bg-white">
              <span class="input-group-text border-0 bg-transparent me-n5">
                <span class="iconify text-secondary" data-icon="ic:outline-search" data-width="24"></span>
              </span>
              <input type="search" class="form-control rounded bg-transparent ps-5" placeholder="Cari Reseller"
                aria-label="Search">
            </div>
          </div>
        </header>
        <section class="my-2">
          <div class="d-flex justify-content-between align-items-end">
            <div class="add-btn">
              <button class="btn btn-primary">
                <span class="iconify" data-icon="ic:outline-add" data-width="24"></span>
                Tambah Produk
              </button>
            </div>
            <div class="sort-by">
              <label for="sort-reseller" class="form-label">Urut berdasarkan</label>
              <select name="sort-by" class="form-select" id="sort-reseller">
                <option value="Terbaru">Terbaru</option>
                <option value="Terlama">Terlama</option>
              </select>
            </div>
          </div>
        </section>
        <section class="my-3">
          <div class="row row-cols-2 row-cols-md-3 gy-3 gx-3">
            @foreach ($produk as $item)
                <div class="col">
                  <div class="card border-0 shadow-sm h-100">
                    <img src="{{ url('/') }}/image.php/{{ $item->foto_produk }}?width=200&height=200&image={{ url('/') }}/storage/upload/img/{{ $item->foto_produk }}" alt="foto produk" class="card-img-top">
                    <div class="card-body">
                      <p class="fw-bold">{{ $item->nama_produk }}</p>
                      <p class="fw-bold fs-5 text-primary">Rp.{{ number_format($item->harga, 0, ',', '.') }},-</p>
                      <p class="text-secondary">{{ $item->stok }} kg tersedia</p>
                      <div class="hstack row-cols-2 gap-2 justify-content-center">
                        <a href="{{ url('product', ['id' => $item->id]) }}" class="btn btn-primary-light">Detail</a>
                        <a href="{{ url('product/edit', ['id' => $item->id]) }}" class="btn btn-primary-light">Edit</a>
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach
          </div>
        </section>
      </main>
    </div>

@endsection