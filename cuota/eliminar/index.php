<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Cuotas.php';
require_once '../../class/Prestamos.php';
require_once '../../class/Reset.php';


$Obj_Cuotas = new Cuotas();
$Obj_Prestamos = new Prestamos();
$Obj_Reset = new Reset();

$Res_UltimaFechaPago = $Obj_Cuotas->ObtenerUltimoPagoCuota($_GET['id_prestamo']);
$DatosUltimaCuota = $Res_UltimaFechaPago->fetch_assoc();

if ($DatosUltimaCuota['id_cuota'] === $_GET['id']) {
    $Obj_Prestamos->ActualizarFechaSiguentePago($DatosUltimaCuota['fecha_pago'], $_GET['id_prestamo']);
}

$Res_Cuotas = $Obj_Cuotas->Eliminar($_GET['id']);

if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}



if ($Res_Cuotas) {
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

    $_SESSION['msg'] = 'Cuota eliminada correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/pago-cuota/?id=" . $_GET['id_prestamo']);
    return;
}
