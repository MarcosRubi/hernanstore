<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';
require_once '../../class/Reset.php';


$Obj_Prestamos = new Prestamos();
$Obj_Reset = new Reset();

//VALIDANDO CAMPOS NO VACIOS
if (trim($_POST['txtValor']) === '') {
    $_SESSION['msg'] = 'Ingrese el monto del préstamo.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (!is_numeric(trim($_POST['txtValor']))) {
    $_SESSION['msg'] = 'El valor ingresado del préstamo no es válido.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (trim(strip_tags($_POST['txtInteres'])) === '') {
    $_SESSION['msg'] = 'Ingrese el porcentaje de intereses del préstamo.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (trim($_POST['txtFechaInicio']) === '') {
    $_SESSION['msg'] = 'Ingrese la fecha a realizar el primer pago.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

$Obj_Prestamos->ganancias = (doubleval(trim($_POST['txtValor'])) * doubleval(trim($_POST['txtInteres']))) / 100;
$Obj_Prestamos->capital_prestamo = doubleval(trim(strip_tags($_POST['txtValor'])));
$Obj_Prestamos->num_cuotas = intval(trim(strip_tags($_POST['txtNumCuotas'])));
$Obj_Prestamos->detalles = trim($_POST['txtDetalles']);
$Obj_Prestamos->fecha_primer_pago = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaPrimerPago'])));
$Obj_Prestamos->fecha_prestamo = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaInicio'])));
$Obj_Prestamos->id_estado = intval(trim(strip_tags($_POST['txtIdEstado'])));
$Obj_Prestamos->id_cliente = intval(trim(strip_tags($_POST['txtIdCliente'])));
$Obj_Prestamos->id_plazo_pago = intval(trim(strip_tags($_POST['txtIdPlazoPago'])));
$Obj_Prestamos->valor_cuota =  $Obj_Reset->CalcularMontoCuotas(doubleval(trim(strip_tags($_POST['txtValor']))), intval(trim(strip_tags($_POST['txtNumCuotas']))), doubleval(trim(strip_tags($_POST['txtInteres']))));
$Obj_Prestamos->ganancias = number_format(doubleval(trim(strip_tags($_POST['txtInteres']))), 2);
$Obj_Prestamos->valor_cuota = number_format((doubleval(trim($_POST['txtValor'])) + doubleval(trim($_POST['txtInteres']))) / intval(trim(strip_tags($_POST['txtNumCuotas']))), 2);


$Res_Prestamos = $Obj_Prestamos->Actualizar($_POST['txtIdPrestamo']);

if ($Res_Prestamos) {

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

    $_SESSION['msg'] = 'Préstamo actualizado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/listar/cliente/?id=" . $_POST['txtIdCliente']);
}
