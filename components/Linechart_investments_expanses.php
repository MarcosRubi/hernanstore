<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Prestamos.php';
require_once '../class/Cuotas.php';

$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();

$Res_Egresos = $Obj_Prestamos->ObtenerEgresosPorMes();
$Res_Ingresos = $Obj_Cuotas->ObtenerIngresosPorMes();

$egresos = array();
$ingresos = array();

while ($DatosPrestamos = $Res_Egresos->fetch_assoc()) {
    $egresos[] = doubleval($DatosPrestamos["suma_prestamos"]);
}
while ($DatosCuotas = $Res_Ingresos->fetch_assoc()) {
    $ingresos[] = doubleval($DatosCuotas["suma_cuotas"]);
}

$jsonEgresos = json_encode($egresos);
$jsonIngresos = json_encode($ingresos);

?>

<div class="chart">
    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
</div>

<script>
    var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: true
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false,
                }
            }]
        }
    }

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
                data: <?= $jsonIngresos ?>
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
                data: <?= $jsonEgresos ?>
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
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartData.datasets[2].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
    })
</script>