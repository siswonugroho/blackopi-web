document.addEventListener('DOMContentLoaded', function () {
  const dropdownNotif = document.querySelector('#dropdown-notif');
  const dropdownList = dropdownNotif.querySelector('.dropdown-body');
  const progressBar = dropdownNotif.querySelector('.progress-bar');
  const unreadBadge = document.querySelector('.badge.unread-badge');

  async function getData(url) {
    try {
      const response = await fetch(url);
      if (!response.ok) throw Error();
      const responseJson = await response.json();
      return responseJson;
    } catch (error) {
      return error;
    }
  }

  function renderData(data) {
    dropdownList.innerHTML = "";
    const dt = luxon.DateTime;
    data.forEach(item => {
      let datetime = dt.fromISO(item.created_at).setLocale('id').toLocaleString(dt.DATETIME_MED);
      dropdownList.insertAdjacentHTML('beforeend', `
      
        <a href="${item.url}?fromnotification=${item.id}" class="dropdown-item py-2 vstack text-wrap border-bottom ${null == item.read_at ? 'bg-primary-light' : ''}">
          <div class="hstack gap-3">
          <figure>
          <span class="iconify" data-icon="${item.icon}" data-height="32"></span>
          </figure>
            <div class="">
              ${item.message}
              <small class="text-secondary">${datetime}</small>
            </div>
          </div>
        </a>
      `);
    });
  }
  dropdownNotif.addEventListener('shown.bs.dropdown', function () {
    progressBar.classList.remove('d-none');
    getData(`${BASEURL}/json/notifications`).then(data => {
      renderData(data);
      progressBar.classList.add('d-none');
    }).catch(error => {
      dropdownList.innerHTML = '<p class="text-center text-secondary">Gagal mengambil notifikasi</p>'
      progressBar.classList.add('d-none');
    })
  });

  getData(`${BASEURL}/json/notifications/countunread`).then(data => {
    if (data.unread > 0) {
      unreadBadge.classList.remove('d-none');
      unreadBadge.insertAdjacentText('afterbegin', data.unread);
    }
  });
});