<?php
require_once './func/LoginValidator.php';
require_once './bd/bd.php';
require_once './class/Prestamos.php';
require_once './class/TransaccionesInversores.php';
require_once './class/TransaccionesAdicionales.php';
require_once './class/Cuotas.php';

$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();
$Obj_TransaccionesInversores = new TransaccionesInversores();
$Obj_TransaccionesAdicionales = new TransaccionesAdicionales();

$sumarValores = function ($a, $b) {
    return $a + $b;
};

$Res_Egresos = $Obj_Prestamos->ObtenerEgresosPorMes();
$Res_Ingresos = $Obj_Cuotas->ObtenerIngresosPorMes();
$Res_TransaccionesAdicionales = $Obj_TransaccionesAdicionales->ObtenerEstadisticasPorMes();
$Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas(date('Y-01-01'), date('Y-12-31'));
$Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date('Y-01-01'), date('Y-12-31'));
$Res_EstadisticasInversores = $Obj_TransaccionesInversores->ObtenerEstadisticasPorMes();

$egresos = array();
$ingresos = array();
$egresosInversores = array();
$ingresosInversores = array();
$IngresosTransaccionesAdicionales = array();
$EgresosTransaccionesAdicionales = array();

$gananciasPrevistas = $Res_GananciasPrevistas->fetch_assoc()['suma_ganancias'];
$capitalPrestado = $Res_CapitalPrestado->fetch_assoc()['suma_prestamos'];

while ($DatosPrestamos = $Res_Egresos->fetch_assoc()) {
    $egresos[] = doubleval($DatosPrestamos["suma_prestamos"]);
}

while ($EstadisticasInversores = $Res_EstadisticasInversores->fetch_assoc()) {
    $egresosInversores[] = doubleval($EstadisticasInversores["total_egresos"]) + doubleval($EstadisticasInversores["total_ganancias"]);
    $ingresosInversores[] = doubleval($EstadisticasInversores["total_ingresos"]);
}
while ($transaccionesAdicionales = $Res_TransaccionesAdicionales->fetch_assoc()) {
    $EgresosTransaccionesAdicionales[] = doubleval($transaccionesAdicionales["total_egresos"]) + doubleval($transaccionesAdicionales["total_ganancias"]);
    $IngresosTransaccionesAdicionales[] = doubleval($transaccionesAdicionales["total_ingresos"]);
}

while ($DatosCuotas = $Res_Ingresos->fetch_assoc()) {
    $ingresos[] = doubleval($DatosCuotas["suma_cuotas"]);
}

$preEgresosCombinados = array_map($sumarValores, $egresos, $egresosInversores);
$preIngresosCombinados = array_map($sumarValores, $ingresos, $ingresosInversores);

$egresosCombinados = array_map($sumarValores, $preEgresosCombinados, $EgresosTransaccionesAdicionales);
$ingresosCombinados = array_map($sumarValores, $preIngresosCombinados, $IngresosTransaccionesAdicionales);

$jsonEgresos = json_encode($egresosCombinados);
$jsonIngresos = json_encode($ingresosCombinados);

$porcentajeGanancias  = number_format(($gananciasPrevistas / $capitalPrestado) * 100, 3);

?>

<div class="card">
    <div class="border-0 card-header">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">Ingresos y egresos del <?= date('Y') ?></h3>
            <p class="ml-auto text-right d-flex flex-column">
                <span class="text-success">
                    <i class="fas fa-arrow-up"></i> <?= $porcentajeGanancias ?>%
                </span>
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="position-relative">
            <canvas id="sales-chart" height="212"></canvas>
        </div>

        <div class="flex-row d-flex justify-content-end">
            <span class="mr-2">
                <i class="fas fa-square text-primary"></i> Ingresos
            </span>

            <span>
                <i class="fas fa-square text-gray"></i> Egresos
            </span>
        </div>
    </div>
</div>

<script>
    $(function() {
        "use strict";

        var ticksStyle = {
            fontColor: "#495057",
            fontStyle: "bold",
        };

        var mode = "index";
        var intersect = true;

        var $salesChart = $("#sales-chart");
        // eslint-disable-next-line no-unused-vars
        var salesChart = new Chart($salesChart, {
            type: "bar",
            data: {
                labels: [
                    "ENE",
                    "FEB",
                    "MAR",
                    "ABR",
                    "MAY",
                    "JUN",
                    "JUL",
                    "AGO",
                    "SEP",
                    "OCT",
                    "NOV",
                    "DIC",
                ],
                datasets: [{
                        backgroundColor: "#007bff",
                        borderColor: "#007bff",
                        data: <?= $jsonIngresos ?>,
                    },
                    {
                        backgroundColor: "#ced4da",
                        borderColor: "#ced4da",
                        data: <?= $jsonEgresos ?>,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect,
                },
                hover: {
                    mode: mode,
                    intersect: intersect,
                },
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [{
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: "4px",
                            color: "rgba(0, 0, 0, .2)",
                            zeroLineColor: "transparent",
                        },
                        ticks: $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function(value) {
                                    if (value >= 1000) {
                                        value /= 1000;
                                        value += "k";
                                    }

                                    return "$" + value;
                                },
                            },
                            ticksStyle
                        ),
                    }, ],
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false,
                        },
                        ticks: ticksStyle,
                    }, ],
                },
            },
        });
    });
</script>