@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
@endpush
@section('content')
<main class="row m-0">
  <aside class="col-3 px-2 bg-primary-light">
    <nav class="nav nav-pills flex-column sticky-top vh-100 py-3">
      <header class="h3 text-center my-2">Logo</header>
      <button class="btn btn-primary mx-auto my-4 text-primary-light" data-bs-toggle="modal"
        data-bs-target="#exampleModal">
        <span class="iconify" data-icon="ic:outline-add" data-width="24"></span>
        Transaksi baru
      </button>
      <a class="nav-link" aria-current="page" href="#">
        <span class="iconify me-3" data-icon="ic:outline-home" data-width="24"></span>
        Home
      </a>
      <a class="nav-link active" href="#">
        <span class="iconify me-3" data-icon="ic:outline-shopping-cart" data-width="24"></span>
        Shop
      </a>
      <a class="nav-link" href="#">
        <span class="iconify me-3" data-icon="ic:outline-history" data-width="24"></span>
        History
      </a>
      <a class="nav-link" href="#">
        <span class="iconify me-3" data-icon="ic:outline-account-circle" data-width="24"></span>
        Account
      </a>
    </nav>
  </aside>
  <div class="col p-0">
    <section class="p-5 bg-light">
      <div class="container-fluid">
        <h1 class="display-4 fw-bold">Bootstrap component experiment</h1>
        <button class="btn btn-primary my-3">Get Started</button>
      </div>
    </section>
    <div class="card border-0 shadow-sm m-4">
      <div class="card-body">
        <div class="input-group mb-3">
          <span class="input-group-text border-0 bg-transparent me-n5" id="basic-addon1">
            <span class="iconify" data-icon="ic:outline-search" data-width="24"></span>
          </span>
          <input type="search" class="form-control rounded bg-transparent ps-5" placeholder="Search" aria-label="Search"
            aria-describedby="basic-addon1">
        </div>
        <div class="alert alert-primary d-flex align-items-center" role="alert">
          <span class="iconify me-2" data-icon="ic:outline-info" data-width="24"></span>
          <div>
            An example alert with an icon
          </div>
        </div>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <span class="iconify me-2" data-icon="ic:outline-warning-amber" data-width="24"></span>
          <strong>Be careful.</strong> File from internet may contain viruses. Proceed with caution.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="iconify me-2" data-icon="ic:outline-error-outline" data-width="24"></span>
          <strong>An error occured.</strong> Please try again later.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="iconify me-2" data-icon="ic:outline-check-circle" data-width="24"></span>
          Payment successful.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="row slide-top">
          <div class="dropdown col">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
              data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown button
            </button>
            <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <hr>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
          <div class="col-8">
            <select class="form-select" aria-label="Default select example">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
        </div>
        <div class="my-2">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              Default checkbox
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
            <label class="form-check-label" for="flexCheckChecked">
              Checked checkbox
            </label>
          </div>
        </div>
        <div class="my-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
              Default radio
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
              Default checked radio
            </label>
          </div>
        </div>
        <div class="my-2">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="lightSwitch">
            <label class="form-check-label" for="lightSwitch">Dark Theme</label>
          </div>
        </div>
      </div>
    </div>
    <div class="card border-0 shadow-sm m-4">
      <div class="card-body">
        <button class="btn btn-primary ">Button</button>
        <button class="btn btn-secondary ">Button</button>
        <button class="btn btn-warning ">Button</button>
        <button class="btn btn-danger ">Button</button>
        <button class="btn btn-success">Button</button>
        <button class="btn btn-info">Button</button>
        <button class="btn btn-dark">Button</button>
        <div class="my-2">
          <button class="btn btn-outline-primary">Button</button>
          <button class="btn btn-outline-secondary">Button</button>
          <button class="btn btn-outline-warning">Button</button>
          <button class="btn btn-outline-danger">Button</button>
          <button class="btn btn-outline-success">Button</button>
          <button class="btn btn-outline-info">Button</button>
          <button class="btn btn-outline-dark">Button</button>
          <div class="my-2">
            <button class="btn btn-sm btn-primary">Button</button>
            <button class="btn btn-sm btn-secondary">Button</button>
            <button class="btn btn-sm btn-warning">Button</button>
            <button class="btn btn-sm btn-danger">Button</button>
            <button class="btn btn-sm btn-success">Button</button>
            <button class="btn btn-sm btn-info">Button</button>
            <button class="btn btn-sm btn-dark">Button</button>
            <div class="d-flex flex-column mt-3">
              <p>Say hello to new color: Primary light!</p>
              <span>
                <button class="btn btn-primary-light">Primary light</button>
                <button class="btn btn-primary">Primary</button>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card border-0 shadow-sm m-4 bg-primary-light">
      <div class="card-body">
        <h3 class="mb-4 text-center card-title">Material Icons from Google</h3>
        <div class="row row-cols-5 gy-5 text-primary">
          <div class="col text-center">
            <button class="btn btn-primary text-primary-light">
              <span class="iconify" data-icon="ic:outline-add" data-width="36"></span>
            </button>
          </div>
          <span class="iconify" data-icon="ic:outline-edit" data-width="36"></span>
          <span class="iconify" data-icon="ic:outline-delete" data-width="36"></span>
          <span class="iconify" data-icon="ic:outline-history" data-width="36"></span>
          <span class="iconify" data-icon="ic:outline-payment" data-width="36"></span>
          <span class="iconify" data-icon="ic:outline-account-circle" data-width="36"></span>
          <span class="iconify" data-icon="ic:outline-home" data-width="36"></span>
          <span class="iconify" data-icon="ic:outline-shopping-cart" data-width="36"></span>
          <span class="iconify" data-icon="ic:outline-settings" data-width="36"></span>
          <span class="iconify" data-icon="ic:outline-notifications" data-width="36"></span>

        </div>
      </div>
    </div>
  </div>
</main>
<footer class="bg-dark m-0 text-light text-center p-5">
  <div class="container">
    <p>Copyright 2021 Sovana Siswonugroho</p>
  </div>
</footer>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Transaksi Baru</h5>
      </div>
      <div class="modal-body py-0">
        <div class="row row-cols-2">
          <div class="mb-3">
            <label for="qtt1" class="form-label">Kuantitas (gram)</label>
            <input type="number" name="qtt" id="qtt1" class="form-control">
          </div>
          <div class="mb-3">
            <label for="qtt2" class="form-label">Jumlah Bayar (Rp)</label>
            <input type="number" name="qtt" id="qtt2" class="form-control">
          </div>
        </div>
        <div class="mb-3 row">
          <div class="input-group">
            <input type="color" class="form-control form-control-color" name="colors" id="colors">
            <div class="input-group-text" id="color-value">
              #000000
            </div>
          </div>
        </div>
        <div class="mb-3 row row-cols-2">
          <p>Harga per kg</p>
          <p class="fw-bold">Rp.14.000</p>
          <p>Total biaya</p>
          <p class="fw-bold">Rp.14.000</p>
          <p>Kembalian</p>
          <p class="fw-bold">Rp.1.000</p>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary-light flex-fill text-primary"
          data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary flex-fill">Selesai</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  let colorInput = document.getElementById('colors')
  colorInput.addEventListener('input', function () {
    document.getElementById('color-value').textContent = colorInput.value;
  }, false);
</script>
@endpush