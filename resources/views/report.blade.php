@extends('layouts.app')
@section('content')
@php
    use Illuminate\Support\Carbon;
@endphp
<div class="row m-0">
  @include('layouts.sidebar')
  <main class="col m-4 d-flex flex-column">
    <header class="my-3 d-flex justify-content-between align-items-center">
      <div class="main-title">
        <h3 class="fw-bold">Laporan Penjualan</h3>
      </div>
      @include('components.notif')
    </header>
    <section class="my-3">
      <div class="hstack gap-2 align-items-end">
        <div>
          <label for="input-bulan" class="form-label">Bulan:</label>
          <select name="bulan" id="input-bulan" class="form-select">
            @foreach ($months as $key => $item)
            <option value="{{ $key }}" {{ Carbon::now()->month == $key ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="input-tahun" class="form-label">Tahun:</label>
          <select name="tahun" id="input-tahun" class="form-select">
            @foreach ($years as $item)
            <option value="{{ $item }}" {{ Carbon::now()->year == $item ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
          </select>
        </div>
        <button class="btn btn-primary-light btn-show-chart">
          <span class="spinner-border spinner-border-sm d-none loading-chart" role="status" aria-hidden="true"></span>
          Tampilkan
        </button>
      </div>
    </section>
    <section class="chart-error-msg d-none">
      @component('components.alert', ['type' => 'danger'])
        <span>Gagal memuat data</span>
        <a role="button" class="btn text-decoration-underline btn-show-chart">Coba lagi</a>
      @endcomponent
    </section>
    <section class="chart-sec my-3">
      <canvas id="reportchart" class="w-100" style="height: 30rem;">

      </canvas>
    </section>
    <section class="mb-2">
      <div class="row row-cols-2 gy-4">
        <div class="col">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-secondary">Total kg terjual (toko)</p>
              <p class="fs-4">2 kg</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-secondary">Total kg terjual (reseller)</p>
              <p class="fs-4">4 kg</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-secondary">Total pendapatan (toko)</p>
              <p class="fs-4">Rp.26.000</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-secondary">Total pendapatan (reseller)</p>
              <p class="fs-4">Rp.48.000</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>
@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="{{ asset('js/chartreport.js') }}"></script>
@endpush