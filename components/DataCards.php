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
        $Res_Ganancias = $Obj_Prestamos->ObtenerGanancias(date("Y-m-d"), date("Y-m-d"));
        $Res_PrestamosAcivos = $Obj_Prestamos->ObtenerPrestamosCreados(date("Y-m-d"), date("Y-m-d"));
        $Res_ClientesCreados = $Obj_Clientes->ObtenerClientesCreados(date("Y-m-d"), date("Y-m-d"));
        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date("Y-m-d"), date("Y-m-d"));
        break;
    case 'week':
        $fechaActual = new DateTime(); // Obtener la fecha actual
        $fechaActual->setISODate(date('Y'), date('W')); // Establecer la semana actual

        $inicioSemana = $fechaActual->format('Y-m-d'); // Fecha de inicio de la semana (lunes)
        $finSemana = $fechaActual->modify('+6 days')->format('Y-m-d'); // Fecha de fin de la semana (domingo)

        $Res_Ganancias = $Obj_Prestamos->ObtenerGanancias($inicioSemana, $finSemana);
        $Res_PrestamosAcivos = $Obj_Prestamos->ObtenerPrestamosCreados($inicioSemana, $finSemana);
        $Res_ClientesCreados = $Obj_Clientes->ObtenerClientesCreados($inicioSemana, $finSemana);
        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado($inicioSemana, $finSemana);
        break;
    case 'month':
        $fechaActual = new DateTime(); // Obtener la fecha actual

        // Obtener el primer día del mes actual
        $inicioMes = $fechaActual->format('Y-m-01');

        // Obtener el último día del mes actual
        $finMes = $fechaActual->format('Y-m-t');

        $Res_Ganancias = $Obj_Prestamos->ObtenerGanancias($inicioMes, $finMes);
        $Res_PrestamosAcivos = $Obj_Prestamos->ObtenerPrestamosCreados($inicioMes, $finMes);
        $Res_ClientesCreados = $Obj_Clientes->ObtenerClientesCreados($inicioMes, $finMes);
        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado($inicioMes, $finMes);
        break;

    default:
        $Res_Ganancias = $Obj_Prestamos->ObtenerGanancias(date("Y-01-01"), date("Y-m-d"));
        $Res_PrestamosAcivos = $Obj_Prestamos->ObtenerPrestamosCreados(date("Y-01-01"), date("Y-m-d"));
        $Res_ClientesCreados = $Obj_Clientes->ObtenerClientesCreados(date("Y-01-01"), date("Y-m-d"));
        $Res_CapitalPrestado = $Obj_Prestamos->ObtenerCapitalPrestado(date("Y-01-01"), date("Y-m-d"));
        break;
}


$totalGanancias = $Res_Ganancias->fetch_assoc()['suma_ganancias'];
$totalPrestamosActivos = $Res_PrestamosAcivos->fetch_assoc()['prestamos_activos'];
$totalClientesCreados = $Res_ClientesCreados->fetch_assoc()['clientes_creados'];
$totalCapitalPrestado = $Res_CapitalPrestado->fetch_assoc()['suma_prestamos'];

?>

<div class="card-body">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $Obj_Reset->FormatoDinero($totalGanancias) ?></h3>

                    <p>Ganancias</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="#" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-olive">
                <div class="inner">
                    <h3><?= $totalPrestamosActivos ?></h3>

                    <p>Préstamos creados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $totalClientesCreados ?></h3>

                    <p>Nuevos clientes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $Obj_Reset->FormatoDinero($totalCapitalPrestado) ?></h3>

                    <p>Capital prestado</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>