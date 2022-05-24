@extends('layouts.app', ['title' => 'Layanan tidak tersedia'])

@section('content')
<main class="min-vh-100 d-flex flex-column justify-content-center align-items-center">
  <figure class="mb-4">
    <img src="{{ asset('img/undraw_server_down.svg') }}" alt="coffee" height="150">
  </figure>
  <h2 class="text-primary fw-bold">Layanan Sementara Tidak Tersedia</h2>
  <p class="text-secondary">Kami sedang berusaha memperbaikinya. Coba beberapa saat lagi.</p>
  <small class="text-secondary mb-4">ERROR 503</small>
</main>
@endsection