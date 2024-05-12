require('./bootstrap');
require('admin-lte');

$(function () {
  'use strict'
  const url = window.location.href;
  const urlOb = new URL(url);

  if (urlOb.pathname == '/home') {
    var analytics;
    $.ajax({
      url:
      decodeURIComponent(window.location.href),
      type: "GET",
      async: false,
      success: function (data) {
        //var Charts = JSON.stringify(data);
        analytics = data;
        //console.log(decodeURIComponent(window.location.href));
      },
      error: function (error) {
        console.log(`Error ${error}`);
      }
    });


    Chart.register({
      id: 'noData',
      afterDraw: function (chart) {
        if (chart.data.datasets[0].data.length === 0) {
          let ctx = chart.ctx;
          let width = chart.width;
          let height = chart.height;

          chart.clear();
          ctx.save();
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          ctx.font = 'bold 20px Microsoft Yahei';
          ctx.fillText('Sin datos a mostrar', width / 2, height / 2);
          ctx.restore();
        }
      }
    });
    Chart.register(ChartDataLabels);

    var pieChartCanvas = $('#typeChart').get(0).getContext('2d')
    var pieData = {
      labels: Object.keys(analytics['chartType']),
      datasets: [{
        data: Object.values(analytics['chartType']),
        backgroundColor: [
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(153, 102, 255, 0.2)',]
      }]
    }
    var pieOptions = {
      maintainAspectRatio: false,
      plugins: {
        // Change options for ALL labels of THIS CHART
        datalabels: {
          color: '#00a65a'
        }
      },
      legend: {
        display: true
      },
      labels: {
        render: 'value',
        fontSize: 14,
        fontStyle: 'bold',
        fontColor: '#000',
        fontFamily: '"Lucida Console", Monaco, monospace'
      },
      plugins: [],

    }
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions,

    })

    //
    var barChartCanvas = $('#errorChart').get(0).getContext('2d')
    var barData = {
      labels: Object.keys(analytics['chartErrors']),
      datasets: [{
        label: 'Total Auditorias',
        data: Object.values(analytics['chartErrors']),
        backgroundColor: ['rgba(255, 99, 132, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)']
      }]
    }
    var barOptions = {
      maintainAspectRatio: false,
    }
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barData,
      options: barOptions,
      plugins: [],

    })

    //
    var bar2ChartCanvas = $('#auditUserChart').get(0).getContext('2d')
    var bar2Data = {
      labels: Object.keys(analytics['chartUsers']),
      datasets: [{
        label: 'Total auditorias del Usuario',
        data: Object.values(analytics['chartUsers']),
        backgroundColor: ['rgba(255, 99, 132, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)']
      }]
    }
    var bar2Options = {
      maintainAspectRatio: false,
      scales: {
        y: {
          stacked: true,
          grid: {
            display: true,

          }
        },
        x: {
          grid: {
            display: false
          }
        }
      },


    }
    var bar2Chart = new Chart(bar2ChartCanvas, {
      type: 'bar',
      data: bar2Data,
      options: bar2Options,
      plugins: []
    })
  }


  //dataRange
  $('#filter-date').daterangepicker({
    autoUpdateInput: false,
    "locale": {
      "format": "YYYY/MM/DD",
      "applyLabel": "Aplicar",
      "cancelLabel": "limpiar",
      "daysOfWeek": [
        "Do",
        "Lu",
        "Ma",
        "Mi",
        "Ju",
        "Vi",
        "Sa"
      ],
      "monthNames": [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
      ]
    }
  });

  //setear formato de date
  $('input[name="dateRange"]').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY/MM/DD') +' - '+ picker.endDate.format('YYYY/MM/DD'));
  });

  //quitar campo
  $('input[name="dateRange"]').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
  });

  //resetear filtros home 
  $('#reset-filter').on("click", function () {
    $('input[name="dateRange"]').val('');
    $('select[name=type]').val('');
    window.location.href = '/home';

  });

  //resetear filtros audits
  $('#reset-filter-audits').on("click", function () {
    $('input[name="dateRange"]').val('');
    $('select[name=type]').val('');
    window.location.href = '/audits';

  });

  $('#exportAudits').on("click", function () {
    $('#auditsForm').attr('action','audits/export');
    $('#auditsForm').submit();
    $('#auditsForm').attr('action','');
  });
  
})



