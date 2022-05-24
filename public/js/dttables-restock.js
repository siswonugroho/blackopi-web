document.addEventListener('DOMContentLoaded', function () {
  const table = $('#dttable');
  const btnStatuses = document.querySelectorAll('button.btn-status-table');
  initDatatable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.11.4/i18n/id.json",
    },
    bInfo: false,
    processing: true,
    serverSide: true,
    ajax: `${BASEURL}/json/restock`,
    drawCallback: function (settings) {
      const api = this.api();
      document.querySelector('span.total-val').textContent = api.data().count();
    },
    columns: [
      // mengambil & menampilkan kolom sesuai tabel database
      { data: 'id_pesanan' },
      { data: 'tanggal' },
      { data: 'nama_reseller' },
      { data: 'nama_produk' },
      { data: 'total_harga' },
      { data: 'status' },
    ],
    columnDefs: [
      {
        "targets": 0,
        "render": function (data, type, row, meta) {
          return `<a href="${BASEURL}/restock/detail/${row.id_pesanan}">${row.id_pesanan}</a>`;
        }
      },
      {
        "targets": 1,
        "render": function (data, type, row, meta) {
          const dt = luxon.DateTime;
          return dt.fromSQL(row.tanggal).setLocale('id').toLocaleString(dt.DATETIME_MED);
        }
      },
      {
        "targets": 3,
        "render": function (data, type, row, meta) {
          return `${row.nama_produk} x${row.kuantitas}`
        }
      },
      {
        "targets": 4,
        "render": function (data, type, row, meta) {
          return `Rp.${formatRupiah(row.total_harga)}`
        }
      },
      {
        "targets": 5,
        "render": function (data, type, row, meta) {
          let textColor = '';
          if (row.status === 'pending') {
            textColor = 'text-warning';
          } else if (row.status === 'selesai') {
            textColor = 'text-success';
          } else if (row.status === 'cancel') {
            textColor = 'text-danger';
          }
          return `<span class="${textColor}">${row.status}</span>`
        }
      },
    ]
  });
  document.querySelector('a.btnrefreshtable').addEventListener('click', function () {
    table.DataTable().ajax.reload();
  });
  btnStatuses.forEach(btn => {
    let status = btn.getAttribute('data-order-status');
    btn.addEventListener('shown.bs.tab', function () {
      // console.log(status);
      table.DataTable().ajax.url(`${BASEURL}/json/restockbystatus/${status}`).load();
    }) ;
  });
});