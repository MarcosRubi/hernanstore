<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Excedente.php';
require_once '../../class/Reset.php';

$Obj_Excedente = new Excedente();



$Res_Excedente = $Obj_Excedente->Eliminar($_GET['id']);

if ($Res_Excedente) {
    $_SESSION['msg'] = 'Excedente eliminado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/excedente/");
    return;
}
