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
        <img src="{{ url('image.php/' . $reseller->foto_profil . '?width=500&height=500&image=' . url('/storage/upload/img/reseller/' . $reseller->foto_profil), []) }}" class="rounded-circle avatar-detail-reseller" onerror="this.onerror = null; this.src = '{{url('/img/noavatar.png')}}'" alt="foto profil">
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
              <table class="table">
                <thead class="text-secondary text-uppercase">
                  <tr>
                    <th>Tanggal</th>
                    <th>Kuantitas</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody class="align-middle">
                  @foreach ($transaksi as $item)
                  <tr>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->kuantitas . 'kg' }}</td>
                    <td>Rp.{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
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