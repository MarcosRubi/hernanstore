<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';

$Obj_Empleado = new Empleados();


if (trim($_POST['txtNombreEmpleado']) === '') {
    $_SESSION['msg'] = 'Ingrese el nombre del empleado.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}
if (trim($_POST['txtCorreo']) === '') {
    $_SESSION['msg'] = 'Ingrese el correo del empleado.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}
if (intval($_POST['txtIdRol']) === 2 && $_SESSION['id_rol'] !== 2) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Res_EmpleadoCorreo = $Obj_Empleado->buscarEmpleadoPorCorreo(strip_tags(strtolower(trim($_POST['txtCorreo']))));
if ($Res_EmpleadoCorreo->num_rows > 0) {
    $_SESSION['msg'] = 'El correo ya esta siendo utilizado por otra cuenta.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

if (isset($_POST['chkImgDefault'])) {
    $Obj_Empleado->url_foto = 'dist/img/employees/default.png';
} else {
    $Obj_Empleado->url_foto = $_POST['url_foto'];
}

$Obj_Empleado->nombre_empleado = strip_tags(trim($_POST['txtNombreEmpleado']));
$Obj_Empleado->correo = strip_tags(trim($_POST['txtCorreo']));
$Obj_Empleado->id_rol = strip_tags(trim($_POST['txtIdRol']));

$Res_Empleado = $Obj_Empleado->ActualizarPorAdministrador($_POST['id_empleado']);

if ($Res_Empleado) {
    $_SESSION['msg'] = 'Datos del empleado actualizados.';
    $_SESSION['type'] = 'success';
    echo "<script>let URL = window.opener.location.pathname;
    window.opener.location.reload();
window.close();</script>";
    return;
}
