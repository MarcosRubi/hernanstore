<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/TransaccionesAdicionales.php';
require_once '../../class/Reset.php';

$Obj_TransaccionesAdicionales = new TransaccionesAdicionales();
$Obj_Reset = new Reset();


if (trim($_POST['txtMonto']) === '') {
    $_SESSION['msg'] = 'Ingrese el monto de la transacción.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Obj_TransaccionesAdicionales->monto = doubleval(trim($_POST['txtMonto']));
$Obj_TransaccionesAdicionales->id_tipo_movimiento = intval(trim($_POST['txtIdTipoMovimiento']));
$Obj_TransaccionesAdicionales->descripcion = strip_tags(ucfirst(strtolower(trim($_POST['txtDescripcion']))));
$Obj_TransaccionesAdicionales->fecha = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaInicio'])));


$Res_TransaccionAdicional = $Obj_TransaccionesAdicionales->Insertar();

if ($Res_TransaccionAdicional) {
    $_SESSION['msg'] = 'Transacción realizada correctamente.';
    $_SESSION['type'] = 'success';
    echo "<script>let URL = window.opener.location.pathname;
    window.opener.location.reload();
window.close();</script>";
    return;
}
