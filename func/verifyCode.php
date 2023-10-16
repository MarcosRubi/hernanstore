<?php
session_start();
if (isset($_SESSION['emailResetPassword'])) {
	require_once '../bd/bd.php';
	require_once '../class/Empleados.php';

	$Obj_Empleados = new Empleados();

	//RECUPERANDO KEY
	$key = $_COOKIE['code'];

	$code = trim($_POST['txtCodeVerify']);

	//VALIDACIONES

	if ($code === "") {
		$response['error'] = true;
		$response['message'] = 'Ingrese el código';

		header('Content-Type: application/json');
		echo json_encode($response);
		return;
	}
	if ($code != $key) {
		$response['error'] = true;
		$response['message'] = 'El código es incorrecto';

		header('Content-Type: application/json');
		echo json_encode($response);
		return;
	}

	//MOSTRAR ERRORES
	setcookie("code", null, time() - 1);

	//MOSTRAR SIGUIENTE PASO
	$response['success'] = true;

	header('Content-Type: application/json');
	echo json_encode($response);
	return;
} else {
	$response['error'] = true;
	$response['message'] = 'Realice los pasos previos para restablecer la contraseña';

	header('Content-Type: application/json');
	echo json_encode($response);
	return;
}
