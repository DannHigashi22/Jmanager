require('./bootstrap');
require('admin-lte');

$(function() {
    'use strict'

    var analytics;

    $.ajax({
        url:
            'http://192.168.100.11:8000/home',
        type: "GET",
        async: false,
        success: function (data) {
            //var Charts = JSON.stringify(data);
            analytics=data;
        },
        error: function (error) {
            console.log(`Error ${error}`);
        }
    });

    //console.log(analytics['chartErrors']);
   
    var pieChartCanvas = $('#typeChart').get(0).getContext('2d')
    var pieData = {
        labels: Object.keys(analytics['chartType']),
        datasets: [{
            data: Object.values(analytics['chartType']),
            backgroundColor: ['#f56954', '#00a65a']
        }]
    }
    var pieOptions = {
        maintainAspectRatio: false,
        legend: {
            display: true
        },
        labels: {
            render: 'value',
            fontSize: 14,
            fontStyle: 'bold',
            fontColor: '#000',
            fontFamily: '"Lucida Console", Monaco, monospace'
          }
        
    }
    var pieChart = new Chart(pieChartCanvas,{
        type: 'pie',
        data: pieData,
        options: pieOptions
    })

    //
    var barChartCanvas = $('#errorChart').get(0).getContext('2d')
    var barData = {
        labels: Object.keys(analytics['chartErrors']),
        datasets: [{
            label: 'Total Auditorias',
            data: Object.values(analytics['chartErrors']),
            backgroundColor: [ 'rgba(255, 99, 132, 0.2)',
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
        scales: {
            y: {
              stacked: true,
              grid: {
                display: true,
                color: "rgba(255,99,132,0.2)"
              }
            },
            x: {
              grid: {
                display: false
              }
            }
          },
          
    }    
    var barChart = new Chart(barChartCanvas,{
        type: 'bar',
        data: barData,
        options: barOptions
    })

    //
    var bar2ChartCanvas = $('#auditUserChart').get(0).getContext('2d')
    var bar2Data = {
        labels: Object.keys(analytics['chartUsers']),
        datasets: [{
            label:'Total auditorias del Usuario',
            data: Object.values(analytics['chartUsers']),
            backgroundColor: [ 'rgba(255, 99, 132, 0.2)',
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
    var bar2Chart = new Chart(bar2ChartCanvas,{
        type: 'bar',
        data: bar2Data,
        options: bar2Options
    })
    
})
