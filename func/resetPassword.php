<?php
session_start();
if (isset($_SESSION['emailResetPassword'])) {
	require_once '../bd/bd.php';
	require_once '../class/Empleados.php';

	$Obj_Empleados = new Empleados();

	$email = $_SESSION['emailResetPassword'];

	//ENCONTRANDO USUARIO
	$Obj_Empleados->correo = $email;
	$Res_Empleado = $Obj_Empleados->buscarEmpleadoPorCorreo();
	$DataEmpleado = $Res_Empleado->fetch_assoc();
	$Obj_Empleados->nombre_empleado = $DataEmpleado['nombre_empleado'];
	$Obj_Empleados->contrasenna = trim($_POST['txtNewPassword']);

	//Nueva Contraseña
	if (trim($_POST['txtNewPassword']) === "") {
		$response['error'] = true;
		$response['message'] = 'Ingrese la nueva contraseña.';

		header('Content-Type: application/json');
		echo json_encode($response);
		return;
	}
	if (strlen(trim($_POST['txtNewPassword'])) <= 7) {
		$response['error'] = true;
		$response['message'] = 'La contraseña debe ser mayor de 7 caracteres.';

		header('Content-Type: application/json');
		echo json_encode($response);
		return;
	}


	//ACTUALIZANDO CONTRASEÑA EN BASE DE DATOS
	$Res_Empleado = $Obj_Empleados->RestablecerContrasenna($DataEmpleado['id_empleado']);

	if ($Res_Empleado) {
		$response['success'] = true;
		$response['message'] = 'Contraseña actualizada correctamente.';

		header('Content-Type: application/json');
		echo json_encode($response);
		unset($_SESSION['emailResetPassword']);
		unset($_SESSION['user']);
	}
} else {
	$response['error'] = true;
	$response['message'] = 'Realce los pasos previos para restablecer la contraseña.';

	header('Content-Type: application/json');
	echo json_encode($response);
	return;
}
