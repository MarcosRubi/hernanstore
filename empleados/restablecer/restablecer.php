<?php
require_once '../../func/LoginValidator.php';

require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';


$Obj_Empleados = new Empleados();

$Res_Administrador = $Obj_Empleados->buscarPorId($_SESSION['id_empleado']);
$DatosAdministrador = $Res_Administrador->fetch_assoc();

if (trim($_POST['passwordAdmin']) === '') {
    $_SESSION['msg'] = 'Ingrese su contraseña.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (trim($_POST['passwordEmpleado']) === '') {
    $_SESSION['msg'] = 'Ingrese la nueva contraseña del empleado.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (!password_verify($_POST['passwordAdmin'], $DatosAdministrador['contrasenna'])) {
    $_SESSION['msg'] = 'Su contraseña no coincide.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

if (trim($_POST['passwordAdmin']) !== '' && password_verify($_POST['passwordAdmin'], $DatosAdministrador['contrasenna'])) {
    $Obj_Empleados->contrasenna = strip_tags($_POST['passwordEmpleado']);
    $Res_Empleados = $Obj_Empleados->RestablecerContrasenna($_POST['id_empleado']);

    if ($Res_Empleados) {
        echo "<script>
                let URL = window.opener.location.pathname;
                window.opener.location.reload();
                window.close();
              </script>";
        $_SESSION['msg'] = 'Contraseña restablecida correctamente.';
        $_SESSION['type'] = 'success';
    };
}
