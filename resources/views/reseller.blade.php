@extends('layouts.app')
@push('style')
<link rel="stylesheet" type="text/css"
  href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/r-2.2.9/datatables.min.css" />
@endpush
@section('content')
<div class="row m-0">
  @include('layouts.sidebar')
  <main class="col m-4 d-flex flex-column">
    {{-- <nav class="navbar bg-transparent">
        <div class="dropdown ms-auto">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <span class="iconify me-1" data-icon="mdi:account-circle-outline" data-width="24"></span>
            {{ Auth::user()->nama_admin }}
          </a>
          <div class="dropdown-menu shadow border-0">
            <a href="" class="dropdown-item">
              <span class="iconify me-2" data-icon="mdi:settings-outline" data-width="24"></span>
              Pengaturan
            </a>
            <a href="{{ url('logout', []) }}" class="dropdown-item text-danger">
              <span class="iconify me-2" data-icon="mdi:logout-variant" data-width="24"></span>
              Logout
            </a>
          </div>
        </div>
    </nav> --}}
    <header class="my-3 d-flex justify-content-between align-items-center">
      <div class="main-title">
        <h3 class="fw-bold">Reseller</h3>
        <p class="m-0">
          Total <span class="total-val">0</span> reseller.
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
        <table class="table w-100 " id="dttable">
          <thead class="text-secondary text-uppercase">
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Telp/WA</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="align-middle">
            
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>
@endsection
@push('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.11.4/r-2.2.9/datatables.min.js"></script>
    <script src="{{ asset('js/dttables.js') }}"></script>
    <script src="{{ asset('js/dttables-reseller.js') }}"></script>
@endpush