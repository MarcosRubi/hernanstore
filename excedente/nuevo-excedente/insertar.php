<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Excedente.php';
require_once '../../class/Reset.php';

$Obj_Excedente = new Excedente();
$Obj_Reset = new Reset();


if (trim($_POST['txtMonto']) === '') {
    $_SESSION['msg'] = 'Ingrese el monto.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}
if (trim($_POST['txtFechaInicio']) === '') {
    $_SESSION['msg'] = 'Ingrese la fecha.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Obj_Excedente->monto = doubleval(trim($_POST['txtMonto']));
$Obj_Excedente->descripcion = trim($_POST['txtDescripcion']);
$Obj_Excedente->fecha = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaInicio'])));


$Res_Excedente = $Obj_Excedente->Insertar();

if ($Res_Excedente) {
    $_SESSION['msg'] = 'Excedente agregado correctamente.';
    $_SESSION['type'] = 'success';
    echo "<script>let URL = window.opener.location.pathname;
    window.opener.location.reload();
window.close();</script>";
    return;
}
