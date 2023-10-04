<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Prestamos.php';
require_once '../class/Cuotas.php';
require_once '../class/Reset.php';

$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();
$Obj_Reset = new Reset();

$Res_Egresos = $Obj_Prestamos->ObtenerEgresosPorMes();
$Res_Ingresos = $Obj_Cuotas->ObtenerIngresosPorMes();

$egresos = array();
$ingresos = array();
$labels = array();

$filter = $_POST['filter'];

switch ($filter) {
    case 'day':
        $Res_GananciasActuales = $Obj_Prestamos->ObtenerGananciasActuales(date("Y-m-d"), date("Y-m-d"));
        $Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas(date("Y-m-d"), date("Y-m-d"));

        $labels = json_encode(['8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00~23:59']);
        break;
    case 'week':
        $fechaActual = new DateTime(); // Obtener la fecha actual
        $fechaActual->setISODate(date('Y'), date('W')); // Establecer la semana actual

        $inicioSemana = $fechaActual->format('Y-m-d'); // Fecha de inicio de la semana (lunes)
        $finSemana = $fechaActual->modify('+6 days')->format('Y-m-d'); // Fecha de fin de la semana (domingo)

        $Res_Egresos = $Obj_Prestamos->ObtenerEgresosPorSemanaActual();
        $Res_Ingresos = $Obj_Cuotas->ObtenerIngresosPorSemanaActual();

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

        $labels = json_encode($labels);
        break;

    default:
        $Res_Egresos = $Obj_Prestamos->ObtenerEgresosPorMes();
        $Res_Ingresos = $Obj_Cuotas->ObtenerIngresosPorMes();
        $labels = json_encode(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']);
        break;
}

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
    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
</div>

<script>
    //-------------
    //- BAR CHART -
    //-------------

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

    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1

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