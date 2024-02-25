<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Prestamos.php';
require_once '../class/Reset.php';

if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    header("Location:" . $_SESSION['path']);
    return;
}

$Obj_Prestamos = new Prestamos();
$Obj_Reset = new Reset();

$filter = $_POST['filter'];

switch ($filter) {
    case 'day':
        $Res_GananciasActuales = $Obj_Prestamos->ObtenerGananciasActuales(date("Y-m-d"), date("Y-m-d"));
        $Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas(date("Y-m-d"), date("Y-m-d"));

        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date("Y-m-d"), date("Y-m-d"), true);
        $Res_CapitalPagado = $Obj_Prestamos->ObtenerCapitalPagado(date("Y-m-d"), date("Y-m-d"));

        break;
    case 'week':
        $fechaActual = new DateTime(); // Obtener la fecha actual
        $fechaActual->modify('last sunday'); // Establecer el último domingo como el inicio de la semana
        $inicioSemana = $fechaActual->format('Y-m-d'); // Fecha de inicio de la semana (domingo)

        // Avanzar al siguiente lunes
        $fechaActual->modify('next monday');
        $finSemana = $fechaActual->format('Y-m-d'); // Fecha de fin de la semana (lunes)

        $Res_GananciasActuales = $Obj_Prestamos->ObtenerGananciasActuales($inicioSemana, $finSemana);
        $Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas($inicioSemana, $finSemana);

        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado($inicioSemana, $finSemana, true);
        $Res_CapitalPagado = $Obj_Prestamos->ObtenerCapitalPagado($inicioSemana, $finSemana);

        break;
    case 'month':
        $fechaActual = new DateTime(); // Obtener la fecha actual

        // Obtener el primer día del mes actual
        $inicioMes = $fechaActual->format('Y-m-01');

        // Obtener el último día del mes actual
        $finMes = $fechaActual->format('Y-m-t');

        $Res_GananciasActuales = $Obj_Prestamos->ObtenerGananciasActuales($inicioMes, $finMes);
        $Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas($inicioMes, $finMes);

        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado($inicioMes, $finMes, true);
        $Res_CapitalPagado = $Obj_Prestamos->ObtenerCapitalPagado($inicioMes, $finMes);
        break;

    case 'year':
        $Res_GananciasActuales = $Obj_Prestamos->ObtenerGananciasActuales(date("Y-01-01"), date("Y-m-d"));
        $Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas(date("Y-01-01"), date("Y-m-d"));

        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date("Y-01-01"), date("Y-m-d"), true);
        $Res_CapitalPagado = $Obj_Prestamos->ObtenerCapitalPagado(date("Y-01-01"), date("Y-m-d"));
        break;

    default:
        $Res_GananciasActuales = $Obj_Prestamos->ObtenerGananciasActuales(date("2023-01-01"), date("Y-m-d"));
        $Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas(date("2023-01-01"), date("Y-m-d"));

        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date("2023-01-01"), date("Y-m-d"), true);
        $Res_CapitalPagado = $Obj_Prestamos->ObtenerCapitalPagado(date("2023-01-01"), date("Y-m-d"));
        break;
}

$totalGananciasActuales = doubleval($Res_GananciasActuales->fetch_assoc()['suma_ganancias']);
$totalGananciasPrevistas = doubleval($Res_GananciasPrevistas->fetch_assoc()['suma_ganancias']);
$totalGananciasPrevistas == 0
    ? $porcentajeInteresCompletado = 100
    : $porcentajeInteresCompletado = number_format(($totalGananciasActuales / $totalGananciasPrevistas) * 100, 2);


$totalCapitalPrestado = $Res_CapitalPrestado->fetch_assoc()['suma_prestamos'];
$totalCapitalPagado = $Res_CapitalPagado->fetch_assoc()['capital_pagado'];
$totalCapitalPrestado == 0
    ? $porcentajeCapitalPagado = 100
    : $porcentajeCapitalPagado = number_format(($totalCapitalPagado / $totalCapitalPrestado) * 100, 2)
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Estadísticas de los préstamos</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Valor evaluado </th>
                    <th style="width:70%;">Progreso</th>
                    <th style="width:150px;">completado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="d-block">Ganancia</span>
                    </td>
                    <td>
                        <div class="progress progress-sm rounded">
                            <div class="progress-bar progress-bar-success rounded bg-success" style="width: <?= $porcentajeInteresCompletado ?>%"></div>
                        </div>
                        <span>Se ha cobrado <b><?= $Obj_Reset->FormatoDinero($totalGananciasActuales) ?></b> de <b><?= $Obj_Reset->FormatoDinero($totalGananciasPrevistas) ?></b> de los intereses</span>
                    </td>
                    <td><span class="badge bg-success"><?= $porcentajeInteresCompletado ?>%</span></td>
                </tr>
                <tr>
                    <td>
                        <span class="d-block">Capital prestado</span>
                    </td>
                    <td>
                        <div class="progress progress-sm rounded">
                            <div class="progress-bar progress-bar-success rounded bg-success" style="width: <?= $porcentajeCapitalPagado ?>%"></div>
                        </div>
                        <span>Se ha cobrado <b><?= $Obj_Reset->FormatoDinero($totalCapitalPagado) ?></b> de <b><?= $Obj_Reset->FormatoDinero($totalCapitalPrestado) ?></b> del capital en prestamos activos</span>
                    </td>
                    <td><span class="badge bg-success"><?= $porcentajeCapitalPagado ?>%</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>