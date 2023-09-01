<?php
require_once './LoginValidator.php';
include './Message.php';

require_once '../bd/bd.php';
require_once '../class/Empleados.php';

include './NameUser.php';


$Obj_Empleados = new Empleados();

$Res_DatosEmpleado = $Obj_Empleados->buscarPorId($_SESSION['id_empleado']);
$DatosEmpleado = $Res_DatosEmpleado->fetch_assoc();

$Obj_Empleados->nombre_empleado = $_SESSION['nombre_empleado'];
$Obj_Empleados->correo =  $_SESSION['correo'];
$Obj_Empleados->contrasenna = $_SESSION['contrasenna'];
$Obj_Empleados->url_foto = $_SESSION['url_foto'];
$Obj_Empleados->id_rol = $_SESSION['id_rol'];


// VALIDACIONES CONTRASEÑA
if (trim($_POST['txtOldPassword']) !== '' && !password_verify($_POST['txtOldPassword'], $DatosEmpleado['contrasenna'])) {
    $_SESSION['msg'] = 'La contraseña actual no coincide';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

if (trim($_POST['txtOldPassword']) !== '' && trim($_POST['txtNewPassword']) === '') {
    $_SESSION['msg'] = 'Ingrese la nueva contraseña';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

//VALIDACIONES CAMPOS A CAMBIAR
if (trim($_POST['txtNombre']) !== '') {
    $Obj_Empleados->nombre_empleado = ucwords(strtolower(trim($_POST['txtNombre'])));
    $_SESSION['nombre_empleado'] = procesarCadena(ucwords(strtolower(trim($_POST['txtNombre']))));
    $_SESSION['nombre_completo'] =  ucwords(strtolower(trim($_POST['txtNombre'])));
};
if (trim($_POST['txtCorreo']) !== '') {
    $Obj_Empleados->correo = strtolower(trim($_POST['txtCorreo']));
    $_SESSION['correo'] = strtolower(trim($_POST['txtCorreo']));
};
if (trim($_POST['txtOldPassword']) !== '' && password_verify($_POST['txtOldPassword'], $DatosEmpleado['contrasenna'])) {
    $Obj_Empleados->contrasenna = $_POST['txtNewPassword'];
    $_SESSION['contrasenna'] = $_POST['txtNewPassword'];
};

if (isset($_FILES["file"])) {
    $targetDirectory = "../dist/img/employees/";
    $targetFileName = 'fotoemp_' . $_SESSION['id_empleado'] . '.png';  // Cambiar la extensión por defecto a .png
    $targetFilePath = $targetDirectory . $targetFileName;

    $allowedExtensions = array('jpeg', 'jpg', 'png');
    $fileExtension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $Obj_Empleados->url_foto = "dist/img/employees/" . $targetFileName;
            $_SESSION['url_foto'] = "dist/img/employees/" . $targetFileName;
        } else {
            $_SESSION['msg'] = 'Error al subir la imagen, vuelva a intentarlo.';
            $_SESSION['type'] = 'error';
            echo "<script>history.back();</script>";
            return;
        }
    } else {
        $_SESSION['msg'] = 'Formato no válido. Solo se permiten archivos JPEG, JPG y PNG.';
        $_SESSION['type'] = 'error';
        echo "<script>history.back();</script>";
        return;
    }
}


//ACTUALIZANDO
$Res_Empleados = $Obj_Empleados->Actualizar($_SESSION['id_empleado']);

if ($Res_Empleados) {
    $_SESSION['msg'] = 'Sus datos han sido actualizados';
    $_SESSION['type'] = 'success';


    echo "<script> history.back();</script>";
    return;
}
