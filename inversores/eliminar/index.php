<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Inversores.php';


$Obj_Inversores = new Inversores();

$Res_Inversores = $Obj_Inversores->Eliminar($_GET['id']);

if ($Res_Inversores) {
    $_SESSION['msg'] = 'Inversor eliminado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/inversores/");
    return;
}
