<?php
require_once './func/LoginValidator.php';
require_once './bd/bd.php';
require_once './class/Prestamos.php';
require_once './class/Cuotas.php';

$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();

$Res_Egresos = $Obj_Prestamos->ObtenerEgresosPorMes();
$Res_Ingresos = $Obj_Cuotas->ObtenerIngresosPorMes();
$Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGanancias(date('Y-01-01'), date('Y-12-31'));
$Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date('Y-01-01'), date('Y-12-31'));

$egresos = array();
$ingresos = array();
$gananciasPrevistas = $Res_GananciasPrevistas->fetch_assoc()['suma_ganancias'];
$capitalPrestado = $Res_CapitalPrestado->fetch_assoc()['suma_prestamos'];

while ($DatosPrestamos = $Res_Egresos->fetch_assoc()) {
    $egresos[] = doubleval($DatosPrestamos["suma_prestamos"]);
}
while ($DatosCuotas = $Res_Ingresos->fetch_assoc()) {
    $ingresos[] = doubleval($DatosCuotas["suma_cuotas"]);
}

$jsonEgresos = json_encode($egresos);
$jsonIngresos = json_encode($ingresos);

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