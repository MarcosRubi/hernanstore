<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Cuotas.php';
require_once '../../class/Prestamos.php';
require_once '../../class/Reset.php';


$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();
$Obj_Reset = new Reset();

//VALIDANDO CAMPOS NO VACIOS
if (trim($_POST['txtValorCuota']) === '') {
    $_SESSION['msg'] = 'Ingrese el monto de la cuota.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (!is_numeric(trim($_POST['txtValorCuota']))) {
    $_SESSION['msg'] = 'El valor ingresado de la cuota no es válido.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (trim(strip_tags($_POST['txtNumCuota'])) === '') {
    $_SESSION['msg'] = 'No elimine el número de la cuota.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (trim($_POST['txtFechaPago']) === '') {
    $_SESSION['msg'] = 'Ingrese la fecha del pago de cuota.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

$Obj_Cuotas->pago_cuota = doubleval(trim(strip_tags($_POST['txtValorCuota'])));
$Obj_Cuotas->num_cuota = intval(trim(strip_tags($_POST['txtNumCuota'])));
$Obj_Cuotas->fecha_pago = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaPago'])));
$Obj_Cuotas->id_estado_cuota = intval(trim(strip_tags($_POST['txtIdEstadoCuota'])));
$Obj_Cuotas->id_prestamo = intval(trim(strip_tags($_POST['txtIdPrestamo'])));

$fechaSiguientePago = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaSiguientePago'])));
$Obj_Prestamos->ActualizarFechaSiguentePago($fechaSiguientePago, intval(trim(strip_tags($_POST['txtIdPrestamo']))));

$Res_Cuotas = $Obj_Cuotas->Insertar();

if ($Res_Cuotas) {

    $PrestamosAtrasados = $Res_PrestamosAtrasados->fetch_assoc()['total_prestamos'];
    $PrestatosProximoPago = $Res_PrestamosProximosPago->fetch_assoc()['total_prestamos'];
    $_SESSION['prestamos_atrasados'] = $PrestamosAtrasados;
    $_SESSION['prestamos_proximo_pago'] = $PrestatosProximoPago;

    $_SESSION['msg'] = 'Cuota realizada correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/pago-cuota/?id=" . $_POST['txtIdPrestamo']);
}
