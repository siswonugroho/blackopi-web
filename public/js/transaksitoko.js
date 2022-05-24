document.addEventListener('DOMContentLoaded', function (e) {
  const formTransaksi = document.querySelector('form.form-transaksitoko');
  const hargaPerSatuan = document.querySelector('input#input-harga-satu');
  const textTotalHarga = document.querySelector('p.total-harga');
  const totalHargaInput = document.querySelector('input#input-total-harga');
  const kuantitasInput = document.querySelector('input#input-kuantitas');
  const kembalianText = document.querySelector('p.kembalian');
  const kembalianInput = document.querySelector('input#input-kembalian');
  const inputJumlahBayar = document.querySelector('input#input-jumlah-bayar');

  function checkTotalHarga() {
    if (kuantitasInput.value != '') {
      totalHargaInput.value = parseFloat(kuantitasInput.value) * parseInt(hargaPerSatuan.value);
      textTotalHarga.textContent = `Rp.${formatRupiah(totalHargaInput.value)}`;
    } else {
      totalHargaInput.value = '';
      textTotalHarga.textContent = 'Rp.0';
    }
  }

  function checkKembalian() {
    if (totalHargaInput.value != '' && kuantitasInput.value != '') {
      kembalianInput.value = parseInt(inputJumlahBayar.value) - parseInt(totalHargaInput.value);
      kembalianText.textContent = `Rp.${formatRupiah(kembalianInput.value)}`;
    } else {
      kembalianInput.value = '';
      kembalianText.textContent = 'Rp.0';
    }
  }

  kuantitasInput.addEventListener('input', checkTotalHarga);
  inputJumlahBayar.addEventListener('input', checkKembalian);

});

