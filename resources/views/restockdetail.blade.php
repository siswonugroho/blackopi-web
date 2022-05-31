@extends('layouts.app')
@section('content')
  <main class="container my-4 d-flex flex-column">
    <header class="my-3 hstack gap-2">
      <a href="{{ url('restock', []) }}" title="Kembali">
      <span class="iconify me-2" data-icon="mdi:arrow-left" data-height="32"></span>
      </a>
      <h3 class="fw-bold m-0">Detail Pesanan</h3>
    </header>
    @if (session('success_msg'))
    @component('components.alert', ['type' => 'success'])
    {{ session('success_msg') }}
    @endcomponent
    @endif
    <section class="row row-cols-md-2 row-cols-lg-4 mt-3">
      <div class="col-auto">
        <div class="card bg-primary-light h-100 border-0">
          <div class="card-body">
            <p class="text-secondary mb-2">Pemesan</p>
            <p class="fs-5">{{ $reseller->nama_reseller }}</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card bg-primary-light h-100 border-0">
          <div class="card-body">
            <p class="text-secondary mb-2">Total Harga</p>
            <p class="fs-5">Rp.{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card bg-primary-light h-100 border-0">
          <div class="card-body">
            <p class="text-secondary mb-2">Produk</p>
            <p class="fs-5">{{ $transaksi->kuantitas }} kg {{ $produk->nama_produk }}</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card bg-primary-light h-100 border-0">
          <div class="card-body">
            <p class="text-secondary mb-2">Status</p>
            <p class="fs-5">{{ $transaksi->status == 'diproses' ? 'perlu dikirim' : $transaksi->status }}</p>
          </div>
        </div>
      </div>
    </section>
    <section class="row mt-4">
      <div class="col">
        @if ($transaksi->status == 'diproses')
            <div class="card border-0 shadow mb-3">
              <div class="card-body">
                <div class="mb-3">
                  <h5 class="fs-5 fw-bold mb-3">
                    <span class="iconify me-2" data-icon="mdi:information-outline" data-width="24"></span>
                    Mohon segera kirimkan pesanan ke alamat berikut.
                  </h5>
                  <div class="border border-muted p-3 rounded">
                    <p class="text-secondary mb-0">Alamat lengkap</p>
                    <p>{{ $reseller->alamat_lengkap }}</p>
                    <p class="text-secondary mb-0">Jasa kirim</p>
                    <p class="mb-0">{{ $transaksi->kurir->nama_tampilan }}</p>
                  </div>
                </div>
                <div class="mb-2">
                  <h5 class="fs-5 fw-bold">Sudah mengirimkan pesanan?</h5>
                  <form action="{{ url('restock/inputresi') }}" method="post">
                    @csrf
                    <label for="inputnoresi" class="form-label">Masukkan nomor resi</label>
                    <div class="hstack gap-2">
                      <input type="hidden" name="id_pesanan" value="{{ $transaksi->id_pesanan }}">
                      <input type="text" name="no_resi" id="inputnoresi" class="form-control" placeholder="Nomor resi">
                      <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                    <small class="form-text">Dengan menyimpan nomor resi, status pesanan akan berubah menjadi "Dikirim"</small>
                  </form>
                </div>
              </div>
            </div>
        @endif
        <div class="card border-0 shadow">
          <div class="card-header border-0 bg-transparent">
            <p class="fs-4 card-title fw-bold mb-0">Detail Lainnya</p>
          </div>
          <div class="card-body">
            <div class="row row-cols-2 gy-2">
              <div class="col-4 fw-bold">ID Pesanan</div>
              <div class="col">{{ $transaksi->id_pesanan }}</div>
              <div class="col-4 fw-bold">Tanggal</div>
              <div class="col">{{ $transaksi->tanggal }}</div>
              <div class="col-4 fw-bold">Nama Produk</div>
              <div class="col">{{ $produk->nama_produk }}</div>
              <div class="col-4 fw-bold">Kuantitas</div>
              <div class="col">{{ $transaksi->kuantitas }} kg</div>
              <div class="col-4 fw-bold">Total Harga</div>
              <div class="col">Rp.{{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
              <div class="col-4 fw-bold">Metode pembayaran</div>
              <div class="col">{{ $pembayaran->nama_lengkap }}</div>
              <div class="col-4 fw-bold">Dikirim melalui</div>
              <div class="col">{{ $transaksi->kurir->nama_tampilan }}</div>
              @if ($transaksi->status == 'dikirim')    
              <div class="col-4 fw-bold">Nomor resi</div>
              <div class="col">{{ $transaksi->no_resi }}</div>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card border-0 shadow">
          <div class="card-header border-0 bg-transparent">
            <p class="fs-4 card-title fw-bold mb-0">Detail Reseller</p>
          </div>
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <img src="{{ url('image.php/' . $reseller->foto_profil . '?width=150&height=150&image=' . url('storage/upload/img/reseller/'. $reseller->foto_profil)) }}" class="rounded-circle " style="height: 64px; width: 64px;">
              </div>
              <div class="col">
                <p class="fs-5 mb-0">{{ $reseller->nama_reseller }}</p>
              </div>
            </div>
            <div class="hstack gap-2 mt-3 ">
              <a role="button" class="btn btn-outline-success btn-sm w-100">
                <span class="iconify me-2" data-icon="mdi:whatsapp" data-height="16"></span>
                WhatsApp
              </a>
              <a role="button" class="btn btn-outline-danger btn-sm w-100">
                <span class="iconify me-2" data-icon="mdi:email-outline" data-height="16"></span>
                Email
              </a>
            </div>
            <div class="row row-cols-2 mt-3 gy-2">
              <div class="col-4 fw-bold">Email</div>
              <div class="col">{{ $reseller->email }}</div>
              <div class="col-4 fw-bold">Telepon</div>
              <div class="col">{{ $reseller->telp }}</div>
              <div class="col-4 fw-bold">Alamat</div>
              <div class="col">{{ $reseller->alamat_lengkap }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection