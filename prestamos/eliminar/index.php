<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';


$Obj_Prestamos = new Prestamos();

$Res_Prestamo = $Obj_Prestamos->buscarPorId($_GET['id']);


if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Res_BorrarPrestamo = $Obj_Prestamos->Eliminar($_GET['id']);

if ($Res_BorrarPrestamo) {
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

    $_SESSION['msg'] = 'Préstamo eliminado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/listar/cliente/?id=" . $_GET['id_cliente']);
    return;
}
