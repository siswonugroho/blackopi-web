@php
use App\Models\Produk;
$produkItem = Produk::find(1);
$hargaProduk = number_format($produkItem->harga, 0, ',', '.')
@endphp
@push('style')
    <link rel="stylesheet" href="{{ asset('css/progress.css') }}">
@endpush
<aside class="col-2 px-2 bg-primary-light">
  <nav class="nav nav-pills mx-1 flex-column py-3 min-vh-100 sticky-top">
    <header class="text-center d-flex flex-column mb-3">
      <figure>
        <img src="{{ asset('img/gbr_login.png') }}" class="my-2" style="height: 5em" alt="logo">
      </figure>
      @if (session('sidebar_msg_ok'))
      @component('components.alert', ['type' => 'success'])
      {{ session('sidebar_msg_ok') }}
      @endcomponent
      @elseif (session('sidebar_msg_error'))
      @component('components.alert', ['type' => 'danger'])
      {{ session('sidebar_msg_error') }}
      @endcomponent
      @endif
      <span>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#transaksiDialog">
          <span class="iconify" data-icon="ic:outline-add" data-width="24"></span>
          Transaksi Baru
        </button>
      </span>
    </header>
    <a class="nav-link {{ $title === 'Beranda' ? 'active' : '' }}" aria-current="page" href="{{ url('home') }}">
      <span class="iconify me-2" data-icon="ic:outline-home" data-width="24"></span>
      Beranda
    </a>
    <a class="nav-link {{ $title === 'Produk' ? 'active' : '' }}" aria-current="page" href="{{ url('product/1') }}">
      <span class="iconify me-2" data-icon="ic:outline-local-cafe" data-width="24"></span>
      Produk
    </a>
    <a href="{{ url('reseller') }}" class="nav-link {{ $title === 'Anggota Reseller' ? 'active' : '' }}">
      <span class="iconify me-2" data-icon="mdi:sitemap" data-width="24"></span>
      Anggota Reseller
    </a>
    <a href="{{ url('restock', []) }}" class="nav-link {{ $title === 'Pemesanan Reseller' ? 'active' : '' }}">
      <span class="iconify me-2" data-icon="mdi:shopping-outline" data-width="24"></span>
      Pemesanan Reseller
    </a>
    <a href="{{ url('history', []) }}" class="nav-link {{ $title === 'Riwayat Transaksi Toko' ? 'active' : '' }}">
      <span class="iconify me-2" data-icon="mdi:history" data-width="24"></span>
      Riwayat Transaksi
    </a>
    <a href="{{ url('report', []) }}" class="nav-link {{ $title === 'Laporan Penjualan' ? 'active' : '' }}" aria-current="page">
      <span class="iconify me-2" data-icon="mdi:chart-box-outline" data-width="24"></span>
      Laporan
    </a>
    <hr class="text-primary mx-2">
    {{-- <div class="dropend" id="dropdown-notif">
      <a href="#" class="nav-link " data-bs-toggle="dropdown">
        <span class="iconify me-2" data-icon="ic:outline-notifications" data-width="24"></span>
        Notifikasi
      </a>
      <div class="dropdown-menu shadow border-0">
          <h3 class="dropdown-header fs-4 fw-bold text-black">Notifikasi</h3>
          <div class="dropdown-body">
            <div class="progress-bar bg-primary-light my-3">
              <div class="progress-bar-value bg-primary"></div>
            </div>
          </div>
      </div>
    </div> --}}
    <div class="dropdown">
      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        <span class="iconify me-2" data-icon="mdi:account-circle-outline" data-width="24"></span>
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
  </nav>
</aside>
@component('components.modal', ['id' => 'transaksiDialog', 'class' => ''])
<form action="{{ url('shop/savetransaction') }}" method="post" class="form-transaksitoko">
  @csrf
  <input type="hidden" name="id_produk" value="{{ $produkItem->id }}">
  <div class="modal-header">
    <h5 class="modal-title">Transaksi Baru</h5>
  </div>
  <div class="modal-body py-0">
    <div class="row row-cols-2">
      <div class="mb-3">
        <label for="kuantitas" class="form-label">Kuantitas (kg)</label>
        <input type="number" name="kuantitas" step="0.1" id="input-kuantitas" class="form-control">
      </div>
      <div class="mb-3">
        <label for="jumlah_bayar" class="form-label">Jumlah Bayar (Rp)</label>
        <input type="number" name="jumlah_bayar" id="input-jumlah-bayar" class="form-control">
      </div>
    </div>
    <div class="mb-3 row row-cols-2">
      <p>Harga per kg</p>
      <p class="fw-bold">Rp.{{ $hargaProduk }}</p>
      <input type="hidden" name="harga_satu" id="input-harga-satu" value="{{ $produkItem->harga }}">
      <p>Total harga</p>
      <p class="fw-bold total-harga">Rp.0</p>
      <input type="hidden" name="total_harga" id="input-total-harga">
      <p>Kembalian</p>
      <p class="fw-bold kembalian">Rp.0</p>
      <input type="hidden" name="kembalian" id="input-kembalian">
    </div>
  </div>
  <div class="modal-footer justify-content-center">
    <button type="button" class="btn btn-primary-light flex-fill text-primary" data-bs-dismiss="modal">Batal</button>
    <button type="submit" class="btn btn-primary flex-fill">Selesai</button>
  </div>
</form>
@endcomponent
@push('script')
<script src="{{ asset('js/transaksitoko.js') }}"></script>
<script src="{{ asset('js/ajax/getnotifications.js') }}"></script>
<script src="{{ url('js/formatrupiah.js') }}"></script>
@endpush