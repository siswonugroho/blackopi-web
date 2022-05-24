const inputBulan = document.querySelector('#input-bulan');
const inputTahun = document.querySelector('#input-tahun');
const btnShowChart = document.querySelectorAll('.btn-show-chart');
const chartCanvas = document.querySelector('canvas#reportchart');
const chartErrorMsg = document.querySelector('.chart-error-msg');
const btnLoading = document.querySelector('.loading-chart');
let reportChart = null;

function generateChart(month, year) {
  btnLoading.classList.remove('d-none'); 
  chartErrorMsg.classList.add('d-none');
  fetch(`${BASEURL}/json/chart/history/${year}/${month}`).then(response => {
    btnLoading.classList.add('d-none');
    return response.json();
  }).then(responseJson => {
    if (reportChart != null) {
      reportChart.data.labels = responseJson.tanggal;
      reportChart.data.datasets[0].data = responseJson.toko;
      reportChart.data.datasets[1].data = responseJson.reseller;
      reportChart.update();
    } else {
      reportChart = new Chart(
        chartCanvas, {
        type: 'line',
        data: {
          labels: responseJson.tanggal, //data key
          datasets: [
            {
              label: 'Penjualan Toko',
              backgroundColor: 'rgb(231, 222, 218)',
              borderColor: 'rgb(134, 61, 61)',
              fill: 'origin',
              data: responseJson.toko //data value
            },
            {
              label: 'Pembelian Reseller',
              backgroundColor: 'rgb(174, 234, 220)',
              borderColor: 'rgb(50, 186, 154)',
              fill: 'origin',
              data: responseJson.reseller //data value
            },
          ]
        },
        options: {
          scales: {
            y: {
              title: {
                text: 'Jumlah (kg)',
                display: true,
                font: {
                  size: 14
                }
              },
              ticks: {
                beginAtZero: true,
                stepSize: 1
              },
              min: 0
            },
            x: {
              title: {
                text: 'Tanggal',
                display: true,
                font: {
                  size: 14
                }
              }
            }
          },
          plugins: {
            tooltip: {
              callbacks: {
                label: function (context) {
                  return context.parsed.y + ' kg terjual';
                }
              }
            }
          }
        }
      });
    }
  })
  .catch(error => {
    btnLoading.classList.add('d-none'); 
    chartErrorMsg.classList.remove('d-none');
    console.error(error);
  });
}

btnShowChart.forEach(btn => {
  btn.addEventListener('click', function () {
    generateChart(inputBulan.value, inputTahun.value);
  });
});

generateChart(inputBulan.value, inputTahun.value);

