@extends('layouts.app')
@section('content')
    <main class="container my-4 d-flex flex-column">
      <header class="my-3 hstack gap-2">
        <a href="{{ url('reseller', []) }}" title="Kembali">
          <span class="iconify me-2" data-icon="mdi:arrow-left" data-height="32"></span>
        </a>
        <h3 class="fw-bold m-0">Detail Reseller</h3>
      </header>
      <section class="mt-3 hstack gap-4">
        <img src="{{ url('image.php/' . $reseller->foto_profil . '?width=500&height=500&image=' . url('/storage/upload/img/reseller/' . $reseller->foto_profil), []) }}" class="rounded-circle avatar-detail-reseller" alt="foto profil">
        <div class="profile-name">
          <p class="fs-3 mb-1">{{ $reseller->nama_reseller }}</p>
          <p class="text-secondary">{{ $reseller->email }}</p>
          <div class="hstack gap-2">
            <button class="btn btn-success text-white">
              <span class="iconify" data-icon="mdi:whatsapp" data-width="24"></span>
              Chat
            </button>
            <button class="btn btn-primary">
              <span class="iconify" data-icon="mdi:email-outline" data-width="24"></span>
              Email
            </button>
          </div>
        </div>
      </section>
      <section class="mt-4 row">
        <div class="col-7">
          <div class="card border-0 shadow">
            <div class="card-body">
              <p class="fs-3 fw-bold">Riwayat Transaksi</p>
              <div class="list-group list-group-flush">
                @foreach ($transaksi as $item)
                    <div class="list-group-item vstack">
                      <span>{{ $item->kuantitas . 'kg' }} - Rp.{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                      <span class="text-secondary">{{ $item->tanggal }}</span>
                      <span>{{ ucfirst($item->status) }}</span>
                    </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="card border-0 shadow">
            <div class="card-body">
              <p class="fs-3 fw-bold">Tentang</p>
              <div class="row">
                <div class="col-5">
                  <p class="text-secondary">Email</p>
                </div>
                <div class="col-7">
                  <p>{{ $reseller->email }}</p>
                </div>
                <div class="col-5">
                  <p class="text-secondary">Telepon/WhatsApp</p>
                </div>
                <div class="col-7">
                  <p>{{ $reseller->telp }}</p>
                </div>
                <div class="col-5">
                  <p class="text-secondary">Alamat</p>
                </div>
                <div class="col-7">
                  <p>{{ $reseller->alamat_lengkap }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
@endsection