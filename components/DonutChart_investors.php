<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/TransaccionesInversores.php';
require_once '../class/Reset.php';
require_once '../func/NameUser.php';

$Obj_TransaccionesInversores = new TransaccionesInversores();
$Obj_Reset = new Reset();

$egresos = array();
$ingresos = array();
$ganancias = array();
$labels = array();

$filter = $_POST['filter'];

switch ($filter) {
    case 'day':
        $Res_Datos = $Obj_TransaccionesInversores->ObtenerEstadisticasDeInversores(date("Y-m-d"), date("Y-m-d"));
        break;
    case 'week':
        $fechaActual = new DateTime(); // Obtener la fecha actual
        $fechaActual->modify('last sunday'); // Establecer el último domingo como el inicio de la semana
        $inicioSemana = $fechaActual->format('Y-m-d'); // Fecha de inicio de la semana (domingo)

        // Avanzar al siguiente lunes
        $fechaActual->modify('next monday');
        $finSemana = $fechaActual->format('Y-m-d'); // Fecha de fin de la semana (lunes)

        $Res_Datos = $Obj_TransaccionesInversores->ObtenerEstadisticasDeInversores($inicioSemana, $finSemana);

        break;
    case 'month':
        $Res_numSemanas = $Obj_Reset->obtenerNumSemanasMesActual();
        $num_semanas = intval($Res_numSemanas->fetch_assoc()['num_semanas']);

        $fechaActual = new DateTime(); // Obtener la fecha actual

        // Obtener el primer día del mes actual
        $inicioMes = $fechaActual->format('Y-m-01');

        // Obtener el último día del mes actual
        $finMes = $fechaActual->format('Y-m-t');

        $Res_Datos = $Obj_TransaccionesInversores->ObtenerEstadisticasDeInversores($inicioMes, $finMes);
        break;

    default:
        $Res_Datos = $Obj_TransaccionesInversores->ObtenerEstadisticasDeInversores(date("Y-01-01"), date("Y-m-d"));
        break;
}

while ($DatosInversores = $Res_Datos->fetch_assoc()) {
    $egresos[] = doubleval($DatosInversores["total_egresos"]);
    $ingresos[] = doubleval($DatosInversores["total_ingresos"]);
    $ganancias[] = doubleval($DatosInversores["total_ganancias"]);
    $labels[] = procesarCadena($DatosInversores["nombre_inversor"]);
}


$jsonLabels = json_encode($labels);
$jsonEgresos = json_encode($egresos);
$jsonIngresos = json_encode($ingresos);
$jsonGanancias = json_encode($ganancias);

?>


<!-- DONUT CHART -->
<div class="col-md-4">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">Ingresos de inversores</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body position-relative ">
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            <?php
            if (array_sum($ingresos) <= 0) {
            ?>
                <h3 class="position-absolute w-100 text-center" style="top:50%;left:50%;transform:translate(-50%,-50%);">No hay datos disponibles</h3>
            <?php
            }
            ?>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<!-- DONUT CHART -->
<div class="col-md-4">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">Egresos de inversores</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body position-relative ">
            <canvas id="donutChartEgresos" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            <?php
            if (array_sum($egresos) <= 0) {
            ?>
                <h3 class="position-absolute w-100 text-center" style="top:50%;left:50%;transform:translate(-50%,-50%);">No hay datos disponibles</h3>
            <?php
            }
            ?>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<!-- DONUT CHART -->
<div class="col-md-4">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">Ganancias de inversores</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body position-relative ">
            <canvas id="donutChartGanancias" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            <?php
            if (array_sum($ganancias) <= 0) {
            ?>
                <h3 class="position-absolute w-100 text-center" style="top:50%;left:50%;transform:translate(-50%,-50%);">No hay datos disponibles</h3>
            <?php
            }
            ?>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
    $(function() {
        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutChartCanvasEgresos = $('#donutChartEgresos').get(0).getContext('2d')
        var donutChartCanvasGanancias = $('#donutChartGanancias').get(0).getContext('2d')
        var donutDataIngresos = {
            labels: <?= $jsonLabels ?>,
            datasets: [{
                data: <?= $jsonIngresos ?>,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        }
        var donutDataEgresos = {
            labels: <?= $jsonLabels ?>,
            datasets: [{
                data: <?= $jsonEgresos ?>,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        }
        var donutDataGanancias = {
            labels: <?= $jsonLabels ?>,
            datasets: [{
                data: <?= $jsonGanancias ?>,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        }
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutDataIngresos,
            options: donutOptions
        })
        new Chart(donutChartCanvasEgresos, {
            type: 'doughnut',
            data: donutDataEgresos,
            options: donutOptions
        })
        new Chart(donutChartCanvasGanancias, {
            type: 'doughnut',
            data: donutDataGanancias,
            options: donutOptions
        })


    })
</script>