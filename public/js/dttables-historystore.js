document.addEventListener('DOMContentLoaded', function () {
  const table = $('#dttable');
  initDatatable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.11.4/i18n/id.json",
    },
    bInfo: false,
    processing: true,
    serverSide: true,
    ajax: `${BASEURL}/json/history`,
    drawCallback: function (settings) {
      const api = this.api();
      document.querySelector('span.total-val').textContent = api.data().count();
    },
    columns: [
      // mengambil & menampilkan kolom sesuai tabel database
      { data: 'id' },
      { data: 'created_at' },
      { data: 'nama_produk' },
      { data: 'kuantitas' },
      { data: 'total_harga' },
    ],
    columnDefs: [
      {
        "targets": 5,
        "render": function (data, type, row, meta) {
          return `<a role="button" class="btn btn-sm btn-primary-light btn-detail-transaksi" data-bs-toggle="modal" data-bs-target="#detailtransaksidialog" onclick="getHistoryDetail(${row.id})" data-id="${row.id}">Detail</a>`;
        }
      },
      {
        "targets": 1,
        "render": function (data, type, row, meta) {
          const dt = luxon.DateTime;
          return dt.fromISO(row.created_at).setLocale('id').toLocaleString(dt.DATETIME_MED);
        }
      },
      {
        "targets": 3,
        "render": function (data, type, row, meta) {
          return `${row.kuantitas} kg`
        }
      },
      {
        "targets": 4,
        "render": function (data, type, row, meta) {
          return `Rp.${formatRupiah(row.total_harga)}`;
        }
      },
    ]
  });
  document.querySelector('a.btnrefreshtable').addEventListener('click', function () {
    table.DataTable().ajax.reload();
  });
});