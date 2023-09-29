<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Inversores.php';


$Obj_Inversores = new Inversores();

$Obj_Inversores->nombre_inversor = strip_tags(ucwords(strtolower(trim($_POST['txtNombreInversor']))));
$Obj_Inversores->detalles = strip_tags($_POST['txtDetalles']);

//VALIDANDO CAMPOS NO VACIOS
if (trim($_POST['txtNombreInversor']) === '') {
    $_SESSION['msg'] = 'Ingrese el nombre del inversor.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

if ($_SESSION['id_rol'] > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Res_Inversores = $Obj_Inversores->Insertar();

if ($Res_Inversores) {
    $_SESSION['msg'] = 'Cuenta del inversor creada correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/inversores/");
}
