<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';


$Obj_Empleados = new Empleados();


$Obj_Empleados->nombre_empleado = strip_tags(ucwords(strtolower(trim($_POST['txtNombreEmpleado']))));
$Obj_Empleados->contrasenna = strip_tags($_POST['txtContrasenna']);
$Obj_Empleados->correo =  strip_tags(strtolower(trim($_POST['txtCorreo'])));
$Obj_Empleados->url_foto = "dist/img/employees/default.png";
$Obj_Empleados->id_rol = strip_tags(ucwords(strtolower(trim($_POST['txtIdRole']))));

//VALIDANDO CAMPOS NO VACIOS
if (trim($_POST['txtNombreEmpleado']) === '') {
    $_SESSION['msg'] = 'Ingrese el nombre del empleado.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (trim($_POST['txtCorreo']) === '') {
    $_SESSION['msg'] = 'Ingrese un correo.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (trim($_POST['txtContrasenna']) === '') {
    $_SESSION['msg'] = 'Ingrese una contraseña.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

if (strlen($_POST['txtContrasenna']) <= 8) {
    $_SESSION['msg'] = 'La contraseña debe tener al menos 8 caracteres.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}
$Res_Empleados = $Obj_Empleados->Insertar();

if ($Res_Empleados) {

    $_SESSION['msg'] = 'Cuenta del empleado creada correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/empleados/");
}
