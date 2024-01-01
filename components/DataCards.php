<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Prestamos.php';
require_once '../class/Clientes.php';
require_once '../class/Reset.php';

$Obj_Prestamos = new Prestamos();
$Obj_Clientes = new Clientes();
$Obj_Reset = new Reset();

$filter = $_POST['filter'];

switch ($filter) {
    case 'day':
        $Res_GananciasActuales = $Obj_Prestamos->ObtenerGananciasActuales(date("Y-m-d"), date("Y-m-d"));
        $Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas(date("Y-m-d"), date("Y-m-d"));

        $Res_PrestamosAcivos = $Obj_Prestamos->ObtenerPrestamosCreados(date("Y-m-d"), date("Y-m-d"));
        $Res_ClientesCreados = $Obj_Clientes->ObtenerClientesCreados(date("Y-m-d"), date("Y-m-d"));

        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date("Y-m-d"), date("Y-m-d"), true);
        $Res_CapitalPagado = $Obj_Prestamos->ObtenerCapitalPagado(date("Y-m-d"), date("Y-m-d"),);
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

        $Res_PrestamosAcivos = $Obj_Prestamos->ObtenerPrestamosCreados($inicioSemana, $finSemana);
        $Res_ClientesCreados = $Obj_Clientes->ObtenerClientesCreados($inicioSemana, $finSemana);

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

        $Res_PrestamosAcivos = $Obj_Prestamos->ObtenerPrestamosCreados($inicioMes, $finMes);
        $Res_ClientesCreados = $Obj_Clientes->ObtenerClientesCreados($inicioMes, $finMes);

        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado($inicioMes, $finMes, true);
        $Res_CapitalPagado = $Obj_Prestamos->ObtenerCapitalPagado($inicioMes, $finMes);
        break;
    case 'year':
        $Res_GananciasActuales = $Obj_Prestamos->ObtenerGananciasActuales(date("Y-01-01"), date("Y-12-31"));
        $Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas(date("Y-01-01"), date("Y-12-31"));

        $Res_PrestamosAcivos = $Obj_Prestamos->ObtenerPrestamosCreados(date("Y-01-01"), date("Y-12-31"));
        $Res_ClientesCreados = $Obj_Clientes->ObtenerClientesCreados(date("Y-01-01"), date("Y-12-31"));

        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date("Y-01-01"), date("Y-12-31"), true);
        $Res_CapitalPagado = $Obj_Prestamos->ObtenerCapitalPagado(date("Y-01-01"), date("Y-12-31"));
        break;

    default:
        $Res_GananciasActuales = $Obj_Prestamos->ObtenerGananciasActuales(date("2023-01-01"), date("Y-12-31"));
        $Res_GananciasPrevistas = $Obj_Prestamos->ObtenerGananciasPrevistas(date("2023-01-01"), date("Y-12-31"));

        $Res_PrestamosAcivos = $Obj_Prestamos->ObtenerPrestamosCreados(date("2023-01-01"), date("Y-12-31"));
        $Res_ClientesCreados = $Obj_Clientes->ObtenerClientesCreados(date("2023-01-01"), date("Y-12-31"));

        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date("2023-01-01"), date("Y-12-31"), true);
        $Res_CapitalPagado = $Obj_Prestamos->ObtenerCapitalPagado(date("2023-01-01"), date("Y-12-31"));
        break;
}

$totalGananciasActuales = doubleval($Res_GananciasActuales->fetch_assoc()['suma_ganancias']);
$totalGananciasPrevistas = $Res_GananciasPrevistas->fetch_assoc()['suma_ganancias'];

$totalPrestamosActivos = $Res_PrestamosAcivos->fetch_assoc()['prestamos_activos'];
$totalClientesCreados = $Res_ClientesCreados->fetch_assoc()['clientes_creados'];

$totalCapitalPrestado = $Res_CapitalPrestado->fetch_assoc()['suma_prestamos'];
$totalCapitalPagado = $Res_CapitalPagado->fetch_assoc()['capital_pagado'];

$totalCapitalPendientePago = $totalCapitalPrestado - $totalCapitalPagado;
$totalGananciasPendientePago = $totalGananciasPrevistas - $totalGananciasActuales;
?>

<div class="card-body">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $Obj_Reset->FormatoDinero($totalGananciasPrevistas) ?></h3>
                    <span>Ganancias</span>
                    <span class="d-block text-center">Pendiente de cobro: <b><?= $Obj_Reset->FormatoDinero($totalGananciasPendientePago) ?></b></span>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="<?= $_SESSION['path'] ?>/reporte/" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-olive">
                <div class="inner">
                    <h3><?= $totalPrestamosActivos ?></h3>

                    <span>Préstamos creados</span>
                    <span class="d-block text-center">&nbsp;</span>

                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="<?= $_SESSION['path'] ?>/prestamos/listar/en-proceso/" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $totalClientesCreados ?></h3>

                    <span>Nuevos clientes</span>
                    <span class="d-block text-center">&nbsp;</span>

                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?= $_SESSION['path'] ?>/clientes/" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $Obj_Reset->FormatoDinero($totalCapitalPrestado) ?></h3>

                    <span>Capital prestado</span>
                    <span class="d-block text-center">Pendiente de cobro: <b><?= $Obj_Reset->FormatoDinero($totalCapitalPendientePago) ?></b></span>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?= $_SESSION['path'] ?>/reporte/" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>