<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';


$Obj_Prestamos = new Prestamos();

$Obj_Prestamos->num_cuotas = intval(trim(strip_tags($_POST['numCuotas'])));

$Res_Prestamo = $Obj_Prestamos->ActualizarNumCuotas($_POST['id_prestamo']);

if ($Res_Prestamo) {

    $Res_DatosSidebar = $Obj_Prestamos->DatosSidebar();
    $DatosSidebar = $Res_DatosSidebar->fetch_assoc();

    $PrestamosEnProceso = $DatosSidebar['total_prestamos_en_proceso'];
    $PrestamosPendientes = $DatosSidebar['total_prestamos_pendientes'];
    $PrestamosPagosAtrasados = $DatosSidebar['total_pagos_atrasados'];
    $PrestamosAtrasados = $DatosSidebar['total_prestamos_atrasados'];
    $PrestatosProximoPago = $DatosSidebar['total_proximos_pagos'];
    $_SESSION['prestamos_pendientes'] = $PrestamosPendientes;
    $_SESSION['prestamos_en_proceso'] = $PrestamosEnProceso;
    $_SESSION['prestamos_pagos_atrasados'] = $PrestamosPagosAtrasados;
    $_SESSION['prestamos_atrasados'] = $PrestamosAtrasados;
    $_SESSION['prestamos_proximo_pago'] = $PrestatosProximoPago;

    $_SESSION['msg'] = 'El número de cuotas ha sido actualizado y el préstamo fue marcado como completado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/pago-cuota/?id=" . $_POST['id_prestamo']);
}
