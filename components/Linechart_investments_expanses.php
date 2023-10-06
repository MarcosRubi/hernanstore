<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Prestamos.php';
require_once '../class/Cuotas.php';
require_once '../class/TransaccionesInversores.php';
require_once '../class/Reset.php';

$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();
$Obj_TransaccionesInversores = new TransaccionesInversores();
$Obj_Reset = new Reset();

$egresos = array();
$egresosInversores = array();
$ingresosInversores = array();
$ingresos = array();
$labels = array();

$sumarValores = function ($a, $b) {
    return $a + $b;
};


$filter = $_POST['filter'];

switch ($filter) {
    case 'week':
        $fechaActual = new DateTime(); // Obtener la fecha actual
        $fechaActual->setISODate(date('Y'), date('W')); // Establecer la semana actual

        $inicioSemana = $fechaActual->format('Y-m-d'); // Fecha de inicio de la semana (lunes)
        $finSemana = $fechaActual->modify('+6 days')->format('Y-m-d'); // Fecha de fin de la semana (domingo)

        $Res_Egresos = $Obj_Prestamos->ObtenerEgresosPorSemanaActual();
        $Res_Ingresos = $Obj_Cuotas->ObtenerIngresosPorSemanaActual();
        $Res_EstadisticasInversores = $Obj_TransaccionesInversores->ObtenerEstadisticasPorSemanaActual();

        $labels = json_encode(['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']);
        break;
    case 'month':
        $Res_numSemanas = $Obj_Reset->obtenerNumSemanasMesActual();
        $num_semanas = intval($Res_numSemanas->fetch_assoc()['num_semanas']);

        for ($i = 1; $i <= $num_semanas; $i++) {
            $labels[] = "Semana 0$i";
        }
        $fechaActual = new DateTime(); // Obtener la fecha actual

        // Obtener el primer día del mes actual
        $inicioMes = $fechaActual->format('Y-m-01');

        // Obtener el último día del mes actual
        $finMes = $fechaActual->format('Y-m-t');

        $Res_Egresos = $Obj_Prestamos->ObtenerEgresosPorSemanas();
        $Res_Ingresos = $Obj_Cuotas->ObtenerIngresosPorSemanas();
        $Res_EstadisticasInversores = $Obj_TransaccionesInversores->ObtenerEstadisticasPorSemana();

        $labels = json_encode($labels);
        break;

    default:
        $Res_Egresos = $Obj_Prestamos->ObtenerEgresosPorMes();
        $Res_Ingresos = $Obj_Cuotas->ObtenerIngresosPorMes();
        $Res_EstadisticasInversores = $Obj_TransaccionesInversores->ObtenerEstadisticasPorMes();
        $labels = json_encode(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']);
        break;
}

while ($DatosPrestamos = $Res_Egresos->fetch_assoc()) {
    $egresos[] = doubleval($DatosPrestamos["suma_prestamos"]);
}

while ($EstadisticasInversores = $Res_EstadisticasInversores->fetch_assoc()) {
    $egresosInversores[] = doubleval($EstadisticasInversores["total_egresos"]) + doubleval($EstadisticasInversores["total_ganancias"]);
    $ingresosInversores[] = doubleval($EstadisticasInversores["total_ingresos"]);
}

while ($DatosCuotas = $Res_Ingresos->fetch_assoc()) {
    $ingresos[] = doubleval($DatosCuotas["suma_cuotas"]);
}


$egresosCombinados = array_map($sumarValores, $egresos, $egresosInversores);
$ingresosCombinados = array_map($sumarValores, $ingresos, $ingresosInversores);


$jsonEgresos = json_encode($egresosCombinados);
$jsonIngresos = json_encode($ingresosCombinados);
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
        labels: <?= $labels ?>,
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
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
    })
</script>