<?php
session_start();

require_once '../utils/Variables.php';

// require_once '../bd/bd.php';
// require_once '../class/Empleados.php';
// require_once '../class/Recordatorios.php';

// $Obj_Empleados = new Empleados();
// $Obj_Recordatorios = new Recordatorios();

// $Obj_Empleados->Email = $_POST['email'];
// $Obj_Empleados->Contrasenna = $_POST['password'];

// $Res_Empleado = $Obj_Empleados->buscarEmpleado();
// $Datos_Empleado = $Res_Empleado->fetch_assoc();


// if ($Res_Empleado->num_rows > 0 && password_verify($_POST['password'], $Datos_Empleado['Contrasenna'])) {
$_SESSION['NombreEmpleado'] = "Marcos Rubí";
// $_SESSION['IdEmpleado'] = $Datos_Empleado['IdEmpleado'];
$_SESSION['UrlFoto'] = "/dist/img/user2-160x160.jpg";
// $_SESSION['IdRole'] = intval($Datos_Empleado['IdRole']);
// $_SESSION['Email'] = strtolower($_POST['email']);
$_SESSION['Path'] = $BASE_URL;
header("Location:" . $BASE_URL);

    // return;
// }
// $_SESSION['Email'] = $_POST['email'];
// header("Location:" . $_SESSION['Path'] . "/iniciar-sesion ");