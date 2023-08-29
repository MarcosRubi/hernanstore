<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';


$Obj_Empleados = new Empleados();

$Res_Empleado = $Obj_Empleados->buscarPorId($_GET['id']);
$DatosEmpleado = $Res_Empleado->fetch_assoc();



if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}
if (intval($_SESSION['id_rol']) === 3 && intval($DatosEmpleado['id_rol']) <= 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}
if (intval($_SESSION['id_rol']) === 2 && intval($DatosEmpleado['id_rol']) === 2) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}
if ($_SESSION['id_empleado'] === $_GET['id']) {
    $_SESSION['msg'] = 'No puede eliminar su propia cuenta.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Res_Empleados = $Obj_Empleados->Eliminar($_GET['id']);

if ($Res_Empleados) {
    $_SESSION['msg'] = 'Empleado eliminado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/empleados/");
    return;
}
