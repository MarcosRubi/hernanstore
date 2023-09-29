<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/TransaccionesInversores.php';
require_once '../../class/Reset.php';

$Obj_TransaccionesInversor = new TransaccionesInversores();
$Obj_Reset = new Reset();


if (trim($_POST['txtMonto']) === '') {
    $_SESSION['msg'] = 'Ingrese el monto de la transacción.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Obj_TransaccionesInversor->monto = doubleval(trim($_POST['txtMonto']));
$Obj_TransaccionesInversor->id_inversor = intval(trim($_POST['id_inversor']));
$Obj_TransaccionesInversor->id_tipo_movimiento = intval(trim($_POST['txtIdTipoMovimiento']));
$Obj_TransaccionesInversor->detalles = trim($_POST['txtDetalles']);
$Obj_TransaccionesInversor->fecha = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaInicio'])));


$Res_Inversor = $Obj_TransaccionesInversor->Insertar();

if ($Res_Inversor) {
    $_SESSION['msg'] = 'Transacción realizada correctamente.';
    $_SESSION['type'] = 'success';
    echo "<script>let URL = window.opener.location.pathname;
    window.opener.location.reload();
window.close();</script>";
    return;
}
