<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Inversores.php';

$Obj_Inversores = new Inversores();


if (trim($_POST['txtNombreInversor']) === '') {
    $_SESSION['msg'] = 'Ingrese el nombre del inversor.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Obj_Inversores->nombre_inversor = strip_tags(trim(ucwords(strtolower($_POST['txtNombreInversor']))));
$Obj_Inversores->detalles = trim($_POST['txtDetalles']);

$Res_Inversores = $Obj_Inversores->Actualizar($_POST['id_inversor']);

if ($Res_Inversores) {
    $_SESSION['msg'] = 'Datos del inversor actualizados.';
    $_SESSION['type'] = 'success';
    echo "<script>let URL = window.opener.location.pathname;
    window.opener.location.reload();
window.close();</script>";
    return;
}
