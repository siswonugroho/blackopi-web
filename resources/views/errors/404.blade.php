@extends('layouts.app', ['title' => 'Halaman tidak ditemukan'])

@section('content')
    <main class="min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <figure class="mb-4">
          <img src="{{ asset('img/undraw_lost.svg') }}" alt="coffee" height="150">
        </figure>
        <h2 class="text-primary fw-bold">Halaman Tidak Ditemukan</h2>
        <p class="text-secondary">Halaman yang dicari tidak ada.</p>
        <small class="text-secondary mb-4">ERROR 404</small>
        <a href="home" class="btn btn-primary mb-3">Kembali ke Beranda</a>
    </main>
@endsection