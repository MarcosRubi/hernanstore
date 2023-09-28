<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';


$Obj_Prestamos = new Prestamos();

$Obj_Prestamos->num_cuotas = intval(trim(strip_tags($_POST['numCuotas'])));

$Res_Prestamo = $Obj_Prestamos->ActualizarNumCuotas($_POST['id_prestamo']);

if ($Res_Prestamo) {

    $Res_PrestamosEnProceso = $Obj_Prestamos->ObtenerTotalPrestamosPorEstado('3');
    $Res_PrestamosPendientes = $Obj_Prestamos->ObtenerTotalPrestamosPorEstado('2');
    $PrestamosEnProceso = $Res_PrestamosEnProceso->fetch_assoc()['total_prestamos'];
    $PrestamosPendientes = $Res_PrestamosPendientes->fetch_assoc()['total_prestamos'];
    $PrestamosAtrasados = $Res_PrestamosAtrasados->fetch_assoc()['total_prestamos'];
    $PrestatosProximoPago = $Res_PrestamosProximosPago->fetch_assoc()['total_prestamos'];

    $_SESSION['prestamos_pendientes'] = $PrestamosPendientes;
    $_SESSION['prestamos_en_proceso'] = $PrestamosEnProceso;
    $_SESSION['prestamos_atrasados'] = $PrestamosAtrasados;
    $_SESSION['prestamos_proximo_pago'] = $PrestatosProximoPago;

    $_SESSION['msg'] = 'El número de cuotas ha sido actualizado y el préstamo fue marcado como completado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/pago-cuota/?id=" . $_POST['id_prestamo']);
}
