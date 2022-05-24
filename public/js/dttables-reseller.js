document.addEventListener('DOMContentLoaded', function () {
  const table = $('#dttable');
  initDatatable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.11.4/i18n/id.json",
    },
    bInfo: false,
    processing: true,
    serverSide: true,
    ajax: `${BASEURL}/json/reseller`,
    drawCallback: function (settings) {
      const api = this.api();
      document.querySelector('span.total-val').textContent = api.data().count();
    },
    columns: [
      // mengambil & menampilkan kolom sesuai tabel database
      { data: 'nama_reseller' },
      { data: 'email' },
      { data: 'telp' },
    ],
    columnDefs: [
      {
        "targets": 0,
        "render": function (data, type, row, meta) {
          return `<img src="${BASEURL}/image.php/${row.foto_profil}?width=80&height=80&image=${BASEURL}/storage/upload/img/reseller/${row.foto_profil}" class="rounded-circle me-2" height="36"> ${row.nama_reseller}`;
        }
      },
      {
        "targets": 3,
        "render": function (data, type, row, meta) {
          return `<a href="${BASEURL}/reseller/detail/${row.id}" class="btn btn-sm btn-primary-light btn-detail-transaksi">Detail</a>`;
        }
      },
    ]
  });
  document.querySelector('a.btnrefreshtable').addEventListener('click', function () {
    table.DataTable().ajax.reload();
  });
});