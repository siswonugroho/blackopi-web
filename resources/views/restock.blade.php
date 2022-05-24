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
        <h3 class="fw-bold">Pemesanan Reseller</h3>
        <p class="m-0">
          Total <span class="total-val"></span> pesanan
          <a role="button" class="btnrefreshtable text-primary text-decoration-none">
            <span class="iconify" data-icon="mdi:refresh" data-height="20"></span>
            Perbarui data
          </a>
        </p>
      </div>
      @include('components.notif')
    </header>
    <section class="my-2">
      <span class="d-flex justify-content-between align-items-end">
        <div>
          <ul class="nav nav-pills" id="statusTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active btn-status-table" id="semua-tab" data-bs-toggle="pill" data-bs-target="#semua" data-order-status="semua" type="button"
                role="tab" aria-controls="semua" aria-selected="true">Semua</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link btn-status-table" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending" data-order-status="pending" type="button"
                role="tab" aria-controls="pending" aria-selected="false">Pending</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link btn-status-table" id="selesai-tab" data-bs-toggle="pill" data-bs-target="#selesai" data-order-status="selesai" type="button"
                role="tab" aria-controls="selesai" aria-selected="false">Selesai</button>
            </li>
          </ul>
        </div>
      </span>
    </section>
    <section class="my-3" id="statusTabContent">
      <table class="table w-100" id="dttable">
        <thead class="text-secondary text-uppercase">
          <tr>
            <th scope="col" class="col-2">ID</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nama Reseller</th>
            <th scope="col">Produk</th>
            <th scope="col">Total Bayar</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody class="align-middle">

        </tbody>
      </table>
    </section>
  </main>
</div>
@endsection
@push('script')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/r-2.2.9/datatables.min.js">
</script>
<script src="{{ asset('js/dttables.js') }}"></script>
<script src="{{ asset('js/formatrupiah.js') }}"></script>
<script src="{{ asset('js/dttables-restock.js') }}"></script>
@endpush