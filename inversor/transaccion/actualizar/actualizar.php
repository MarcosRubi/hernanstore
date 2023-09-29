<?php
require_once '../../../func/LoginValidator.php';
require_once '../../../bd/bd.php';
require_once '../../../class/TransaccionesInversores.php';
require_once '../../../class/Reset.php';


$Obj_TransaccionesInversores = new TransaccionesInversores();
$Obj_Reset = new Reset();

//VALIDANDO CAMPOS NO VACIOS
if (trim($_POST['txtMonto']) === '') {
    $_SESSION['msg'] = 'Ingrese el monto de la transacción.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (!is_numeric(trim($_POST['txtMonto']))) {
    $_SESSION['msg'] = 'El valor ingresado de la transacción no es válido.';
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

$Obj_TransaccionesInversores->monto = doubleval(trim(strip_tags($_POST['txtMonto'])));
$Obj_TransaccionesInversores->detalles = trim($_POST['txtDetalles']);
$Obj_TransaccionesInversores->fecha = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaInicio'])));
$Obj_TransaccionesInversores->id_tipo_movimiento = intval(trim(strip_tags($_POST['txtIdTipoMovimiento'])));


$Res_TransaccionesInversores = $Obj_TransaccionesInversores->Actualizar($_POST['id_movimiento_inversor']);

if ($Res_TransaccionesInversores) {
    $_SESSION['msg'] = 'Transacción actualizada correctamente.';
    $_SESSION['type'] = 'success';
    echo "<script>let URL = window.opener.location.pathname;
    window.opener.location.reload();
window.close();</script>";
}
