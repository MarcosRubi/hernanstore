<div class="chart">
    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
</div>

<script>
    //-------------
    //- BAR CHART -
    //-------------

    var areaChartData = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [{
                label: 'Ingresos',
                backgroundColor: 'rgba(60,141,188,1)',
                borderColor: 'rgba(60,141,188,1)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [28, 48, 40, 19, 86, 27, 90, 28, 48, 40, 19, 86]
            },
            {
                label: 'Egresos',
                backgroundColor: 'rgba(210, 214, 222, 1)',
                borderColor: 'rgba(210, 214, 222, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55]
            },
            {
                label: 'Ganancias',
                backgroundColor: 'rgba(128, 203, 196, 1)',
                borderColor: 'rgba(128, 203, 196, 1)',
                pointRadius: false,
                pointColor: 'rgba(128, 203, 196, 1)',
                pointStrokeColor: '#4db6ac',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(128, 203, 196, 1)',
                data: [20, 39, 60, 61, 36, 35, 20, 20, 39, 60, 61, 36, 35]
            },
        ]
    }

    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    var temp2 = areaChartData.datasets[2]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1
    barChartData.datasets[2] = temp2

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    }

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions

    })
</script>