@extends('layouts.app')

@section('content')
<div class="row m-0">
  @include('layouts.sidebar')
  <main class="col m-4 d-flex flex-column">
    <header class="my-3">
      <h3 class="fw-bold m-0">Detail Produk</h3>
    </header>
    @if (session('success_msg'))
      @component('components.alert', ['type' => 'success'])
      {{ session('success_msg') }}
      @endcomponent
    @elseif (session('error_msg'))
      @component('components.alert', ['type' => 'danger'])
      {{ session('success_msg') }}
      @endcomponent
    @endif
    <section class="row my-3 gx-4">
      <figure class="col-auto img-product-detail">
        <img src="{{ asset('upload/img/' . $produk->foto_produk) }}" alt="Kopi 1" class="w-100 h-100 rounded">
      </figure>
      <div class="col">
        <p class="fs-4">{{ $produk->nama_produk }}</p>
        <p class="fs-4 fw-bold text-primary">Rp.{{ number_format($produk->harga, 0, ',', '.') }}/kg</p>
        <p><strong>{{ $produk->stok }} kg </strong>stok tersedia.</p>
        <a href="{{ url('product/edit', ['id' => $produk->id]) }}" class="btn btn-primary-light text-primary">Ubah</a>
      </div>
    </section>
    <section class="my-3">
      <header>
        <h3 class="fw-bold">Deskripsi</h3>
        <article>
          {{ $produk->deskripsi }}
        </article>
      </header>
    </section>
  </main>
  @component('components.modal', ['id' => 'viewImageDialog', 'class' => 'modal-dialog-scrollable'])
  <form action="{{ url('product/edit') }}" method="post" enctype="multipart/form-data">
  @csrf
    <div class="modal-header">
      <h5 class="modal-title">Foto {{ $produk->nama_produk }}</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body py-0">
      <img src="{{ asset('upload/img/' . $produk->foto_produk) }}" alt="foto produk" class="w-100">
    </div>
</div>
</form>
@endcomponent
</div>

@endsection
