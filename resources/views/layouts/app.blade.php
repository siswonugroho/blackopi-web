<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $title }} - Blackopi Web Admin</title>
  <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.custom.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  @stack('style')
</head>

<body class="bg-light">
  @yield('content')
  <div class="toast-container position-fixed bottom-0 start-0 p-3">
    <div id="toastNotif" class="toast align-items-center border-0" role="alert" data-bs-delay="7000"
      aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <span class="iconify me-2" data-icon="mdi:bell" data-height="20"></span>
        <small>NOTIFIKASI BARU</small>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
        <div class="toast-body">
          <div class="hstack gap-3">
            <div class="p-2 rounded-circle bg-primary-light text-primary">
              <span class="iconify notif-icon" data-icon="" data-height="36"></span>
            </div>
            <a href="" class="toast-msg text-dark text-decoration-none"></a>
          </div>
        </div>
        
    </div>
  </div>
  @if (auth()->check())
  <input type="hidden" id="loggedInId" value="{{ auth()->user()->getAuthIdentifier() }}">
  @endif
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/constants.js') }}"></script>
  <script src="{{ asset('js/luxon.min.js') }}"></script>
  <script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
  <script>
    const userId = document.querySelector('input#loggedInId');
    const toast = new bootstrap.Toast(document.querySelector('#toastNotif'));
    const toastMsg = document.querySelector('a.toast-msg');
    const toastIcon = document.querySelector('span.notif-icon');
    Echo.private('events')
          .listen('RealTimeNotif', (e) => console.log(e.message));
    Echo.private('App.Models.Admin.' + userId.value)
    .notification((notification) => {
      toastMsg.textContent = notification.message;
      toastMsg.href = notification.url;
      toastIcon.setAttribute('data-icon', notification.icon);
      toast.show();
    });
  </script>
  @stack('script')
</body>

</html>