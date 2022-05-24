@extends('layouts.app')

@section('content')
    <main class="bg-primary-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="card col-4 border-0 shadow">
        <div class="card-body m-3 text-center">
          <img src="{{ asset('img/gbr_login.png') }}" class="my-3" style="height: 6em" alt="logo">
          <h2 class="card-title my-4">Login Admin</h2>
          @if ($retries > 0)
          @error('wronglogin')
            @component('components.alert', ['type' => 'danger'])
                {{ $message }}<br>Tersisa {{ $retries }} percobaan.
            @endcomponent
          @enderror
          @elseif ($retries <= 0) 
            @component('components.alert', ['type' => 'danger'])
                Terlalu banyak percobaan login.<br>Coba lagi dalam <span class="login-retry-sec">{{ $seconds }}</span> detik.
            @endcomponent
          @endif
          <form action="{{ url('login')}}" method="post">
            @csrf
            <div class="mb-3">
              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email">
              <span class="invalid-feedback">@error('email') {{ $message }} @enderror</span>
            </div>
            <div class="mb-3">
              <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
              <span class="invalid-feedback">@error('password') {{ $message }} @enderror</span>
            </div>
            <div class="mb-3 d-grid">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
          </form>
        </div>
      </div>
    </main>
@endsection
@if ($retries <= 0)
@push('script')
    <script src="{{ asset('js/loginlimitsec.js') }}"></script>
@endpush
@endif