<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';


$Obj_Clientes = new Clientes();

$Res_Empleado = $Obj_Clientes->buscarPorId($_GET['id']);
$DatosEmpleado = $Res_Empleado->fetch_assoc();

if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Res_Clientes = $Obj_Clientes->Eliminar($_GET['id']);

if ($Res_Clientes) {
    $_SESSION['msg'] = 'Cliente eliminado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/clientes/");
    return;
}
