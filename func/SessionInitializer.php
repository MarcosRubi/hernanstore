<?php
session_start();
// $BASE_URL = "https://hernanstore.com";
$BASE_URL = "http://127.0.0.1/Proyectos/hernanstore.com";

require_once '../bd/bd.php';
require_once '../class/Empleados.php';
require_once '../class/Prestamos.php';

$Obj_Empleados = new Empleados();
$Obj_Prestamos = new Prestamos();

$Obj_Empleados->correo = $_POST['txtCorreo'];
$Res_Empleado = $Obj_Empleados->buscarEmpleadoPorCorreo();
$Datos_Empleado = $Res_Empleado->fetch_assoc();


$Res_DatosSidebar = $Obj_Prestamos->DatosSidebar();
$DatosSidebar = $Res_DatosSidebar->fetch_assoc();

include './NameUser.php';

if (isset($_POST['chkRemember'])) {
    $_SESSION['remember'] = true;
}
$_SESSION['path'] = $BASE_URL;

if ($Res_Empleado->num_rows > 0 && password_verify($_POST['txtContrasenna'], $Datos_Empleado['contrasenna'])) {
    $_SESSION['nombre_empleado'] = procesarCadena($Datos_Empleado['nombre_empleado']);
    $_SESSION['nombre_completo'] = $Datos_Empleado['nombre_empleado'];
    $_SESSION['id_empleado'] = $Datos_Empleado['id_empleado'];
    $_SESSION['contrasenna'] = $_POST['txtContrasenna'];
    $_SESSION['url_foto'] = $Datos_Empleado['url_foto'];
    $_SESSION['id_rol'] = intval($Datos_Empleado['id_rol']);
    $_SESSION['correo'] = $Datos_Empleado['correo'];

    $PrestamosEnProceso = $DatosSidebar['total_prestamos_en_proceso'];
    $PrestamosPendientes = $DatosSidebar['total_prestamos_pendientes'];
    $PrestamosPagosAtrasados = $DatosSidebar['total_pagos_atrasados'];
    $PrestamosAtrasados = $DatosSidebar['total_prestamos_atrasados'];
    $PrestatosProximoPago = $DatosSidebar['total_proximos_pagos'];
    $_SESSION['prestamos_pendientes'] = $PrestamosPendientes;
    $_SESSION['prestamos_en_proceso'] = $PrestamosEnProceso;
    $_SESSION['prestamos_pagos_atrasados'] = $PrestamosPagosAtrasados;
    $_SESSION['prestamos_atrasados'] = $PrestamosAtrasados;
    $_SESSION['prestamos_proximo_pago'] = $PrestatosProximoPago;

    header("Location:" . $BASE_URL);

    return;
}
$_SESSION['msg'] = 'Usuario y/o contraseña incorrecto.';
$_SESSION['type'] = 'error';

$_SESSION['correo'] = $_POST['txtCorreo'];
header("Location:" . $_SESSION['path'] . "/iniciar-sesion ");
