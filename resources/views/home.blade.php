@extends('layouts.app')

@section('content')
<div class="row m-0">
  @include('layouts.sidebar')
  <main class="col m-4 d-flex flex-column">
    <section class="my-3">
      <header class="mb-4 hstack justify-content-between">
        <div class="title-sec">
          <h3 class="fw-bold" id="welcome-text">Selamat Datang </h3>
          <p>Berikut statistik Anda bulan ini</p>
        </div>
        @include('components.notif')
      </header>
      <div class="row row-cols-4 gx-3 mb-2">
        <div class="col">
          <div class="card border-0 bg-primary-light shadow-sm">
            <div class="card-body">
              <p class="fs-3 mb-1 fw-bold">{{ $sold_store }}</p>
              <p>Kg kopi terjual di toko</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card border-0 bg-primary-light shadow-sm">
            <div class="card-body">
              <p class="fs-3 mb-1 fw-bold">{{ $sold_reseller }}</p>
              <p>Kg terjual ke reseller</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card border-0 bg-primary-light shadow-sm">
            <div class="card-body">
              <p class="fs-3 mb-1 fw-bold">{{ $count_reseller }}</p>
              <p>Reseller terdaftar</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card border-0 bg-primary-light shadow-sm">
            <div class="card-body">
              <p class="fs-3 mb-1 fw-bold">{{ $available }}</p>
              <p>Kg stok tersedia</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="row mb-3">
      <div class="col-md-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <header>
              <h3 class="fw-bold">Grafik Penjualan per Hari</h3>
              <small>
                {{ $month_name . ' ' . $date_now[1] }}
                <span class="spinner-border spinner-border-sm d-none loading-chart" role="status" aria-hidden="true"></span>
              </small>
              <section class="chart-error-msg d-none">
                @component('components.alert', ['type' => 'danger'])
                <span>Gagal memuat data</span>
                <a role="button" class="btn text-decoration-underline btn-show-chart">Coba lagi</a>
                @endcomponent
              </section>
              <input type="hidden" name="input_bulan" value="{{ $date_now[0] }}" id="input-bulan">
              <input type="hidden" name="input_tahun" value="{{ $date_now[1] }}" id="input-tahun">
            </header>
            <canvas id="reportchart" class="w-100">
            
            </canvas>
          </div>
        </div>
      </div>
      <div class="col-md">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <header class="h3 fw-bold">Data Reseller</header>
            <div class="list-group list-group-flush mb-3">
              @foreach ($five_recent_resellers as $item)    
              <a href="{{ url('reseller/detail/' . $item->id) }}" class="list-group-item list-group-item-action hstack">
                <img
                  src="{{ url('/') }}/image.php/{{ $item->foto_profil }}?width=80&height=80&image={{ url('/') }}/storage/upload/img/reseller/{{ $item->foto_profil }}"
                  class="rounded-circle me-2" style="height: 3rem;" onerror="this.onerror = null; this.src = '{{url('/img/noavatar.png')}}'">
                <div class="vstack">
                  <p class="mb-1">{{ $item->nama_reseller }}</p>
                  <small class="text-secondary">{{ $item->telp }}</small>
                </div>
              </a>
              @endforeach
            </div>
            <a href="{{ url('reseller') }}" class="text-decoration-none">Lihat semua</a>
          </div>
        </div>
      </div>
    </section>
    {{-- <section class="card shadow-sm border-0">
      <div class="card-body">
        <h3 class="fw-bold">Transaksi terbaru</h3>
        
      </div>
    </section> --}}
  </main>
</div>


@endsection
@push('script')
<script src="{{ asset('js/greetings.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="{{ asset('js/chartreport.js') }}"></script>
@endpush