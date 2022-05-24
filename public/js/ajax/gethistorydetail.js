function getHistoryDetail(id) {
  const modalDetail = document.querySelector('#detailtransaksidialog');
  // const btnDetail = document.querySelector('button.btn-detail-transaksi');
  const detailitemElements = document.querySelectorAll('.detail-item');
  const progressHTML = modalDetail.querySelector('.progress-bar');

  async function getData(idtransaksi) {
    try {
      const response = await fetch(`${BASEURL}/json/history/${idtransaksi}`);
      const responseJson = await response.json();
      progressHTML.classList.add('d-none');
      renderData(responseJson);
    } catch (error) {
      console.error(error);
    }
  }

  function renderData(item) {
    const dt = luxon.DateTime;
    detailitemElements[0].textContent = item.id
    detailitemElements[1].textContent = dt.fromISO(item.updated_at).setLocale('id').toLocaleString(dt.DATETIME_MED);
    detailitemElements[2].textContent = item.nama_produk
    detailitemElements[3].textContent = item.kuantitas + ' kg'
    detailitemElements[4].textContent = `Rp.${formatRupiah(item.total_harga)}`
    detailitemElements[5].textContent = `Rp.${formatRupiah(item.jumlah_bayar)}`
    detailitemElements[6].textContent = `Rp.${formatRupiah(item.kembalian)}`
  }

  getData(id);

  modalDetail.addEventListener('hidden.bs.modal', function (event) {
    progressHTML.classList.remove('d-none');
  });
}

