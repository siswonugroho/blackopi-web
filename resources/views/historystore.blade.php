@extends('layouts.app')
@push('style')
<link rel="stylesheet" type="text/css"
  href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/r-2.2.9/datatables.min.css" />
@endpush
@section('content')
<div class="row m-0">
  @include('layouts.sidebar')
  <main class="col m-4 d-flex flex-column">
    <header class="my-3 d-flex justify-content-between align-items-center">
      <div class="main-title">
        <h3 class="fw-bold">Transaksi Toko</h3>
        <p class="m-0">
          Total <span class="total-val"></span> transaksi 
          <a role="button" class="btnrefreshtable text-primary text-decoration-none">
            <span class="iconify" data-icon="mdi:refresh" data-height="20"></span>
            Perbarui data
          </a>
        </p>
      </div>
      @include('components.notif')
    </header>
    <section class="my-3">
      <div class="table-responsive">
        <table class="table w-100" id="dttable">
          <thead class="text-secondary text-uppercase">
            <tr>
              <th>ID</th>
              <th>Tanggal</th>
              <th>Nama Produk</th>
              <th>Kuantitas</th>
              <th>Total harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="align-middle">
            {{-- @foreach ($list as $item)
            <tr>
              <td>{{ $item->id }}</td>
              <td>{{ $item->updated_at }}</td>
              <td>{{ $item->produk->nama_produk }}</td>
              <td>{{ $item->kuantitas }}</td>
              <td>{{ $item->total_harga }}</td>
              <td>
                <a role="button" class="btn btn-sm btn-primary-light btn-detail-transaksi" data-bs-toggle="modal"
                  data-bs-target="#detailtransaksidialog" data-id="{{ $item->id }}">Detail</a>
              </td>
            </tr>
            @endforeach --}}
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>
@component('components.modal', ['id' => 'detailtransaksidialog', 'class' => ''])
<div class="modal-header">
  <h5 class="modal-title">Detail</h5>
</div>
<div class="modal-body py-0">
  <div class="progress-bar bg-primary-light">
    <div class="progress-bar-value bg-primary"></div>
  </div>
  <div class="row my-2">
    <div class="col-4">ID transaksi</div>
    <div class="col text-secondary detail-item"></div>
  </div>
  <div class="row my-2">
    <div class="col-4">Tanggal/waktu</div>
    <div class="col text-secondary detail-item"></div>
  </div>
  <div class="row my-2">
    <div class="col-4">Nama produk</div>
    <div class="col text-secondary detail-item"></div>
  </div>
  <div class="row my-2">
    <div class="col-4">Kuantitas</div>
    <div class="col text-secondary detail-item"></div>
  </div>
  <div class="row my-2">
    <div class="col-4">Total harga</div>
    <div class="col text-secondary detail-item"></div>
  </div>
  <div class="row my-2">
    <div class="col-4">Jumlah bayar</div>
    <div class="col text-secondary detail-item"></div>
  </div>
  <div class="row my-2">
    <div class="col-4">Kembalian</div>
    <div class="col text-secondary detail-item"></div>
  </div>
</div>
<div class="modal-footer"><button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button></div>
@endcomponent
@endsection
@push('script')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/r-2.2.9/datatables.min.js">
</script>
<script src="{{ asset('js/dttables.js') }}"></script>
<script src="{{ asset('js/formatrupiah.js') }}"></script>
<script src="{{ asset('js/ajax/gethistorydetail.js') }}"></script>
<script src="{{ asset('js/dttables-historystore.js') }}"></script>
@endpush