<?php
session_start();

require_once '../vendor/autoload.php';
require_once '../bd/bd.php';
require_once '../class/Empleados.php';
require_once '../class/TemplateEmail.php';

//CARGA AUTOLOAD DE COMPOSER
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';



$mail = new PHPMailer(true);
$Obj_Empleados = new Empleados();

$email = strip_tags($_POST['txtEmailVerify']);
$Obj_Empleados->correo = $email;

$Res_findByEmail = $Obj_Empleados->buscarEmpleadoPorCorreo();
$DataEmpleado = $Res_findByEmail->fetch_assoc();

$Obj_Email = new Email();
//GENERANDO KEY
$key = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
$Obj_Email->key = $key;
@$Obj_Email->username = $DataEmpleado['nombre_empleado'];

//VALIDACIONES
$errors = array();
if (trim($email) === "") {
	$response['error'] = true;
	$response['message'] = 'Ingrese el correo.';

	header('Content-Type: application/json');
	echo json_encode($response);
	return;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$response['error'] = true;
	$response['message'] = 'Correo no válido.';

	header('Content-Type: application/json');
	echo json_encode($response);
	return;
}
if (mysqli_num_rows($Res_findByEmail) === 0) {
	$response['error'] = true;
	$response['message'] = 'No existe una cuenta con este correo.';

	header('Content-Type: application/json');
	echo json_encode($response);
	echo "Hola";
	return;
}


//ENVIAR EMAIL CON CODIGO
try {
	//Server settings
	// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
	$mail->isSMTP();                                            //Send using SMTP
	$mail->Host       = 'smtp.titan.email';                     //Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	$mail->Username   = "soporte@hernanstore.com";                     //SMTP username
	$mail->Password   = "4Nj697400813.";                              //SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	//Recipients
	$mail->setFrom("soporte@hernanstore.com", 'HernanStore');
	$mail->addAddress($DataEmpleado['correo'], $DataEmpleado['nombre_empleado']);     //Add a recipient

	//Content
	$mail->isHTML(true);                                  //Set email format to HTML
	$mail->Subject = $Obj_Email->templateSubject();
	$mail->Body = $Obj_Email->templateBody();
	$mail->AltBody = strip_tags($Obj_Email->altTemplateBody());

	$mail->send();
	setcookie("code", $key, time() + 600);
	$_SESSION['emailResetPassword'] = $DataEmpleado['correo'];
	$_SESSION['user'] = $DataEmpleado['nombre_empleado'];

	//MOSTRAR SIGUIENTE PASO
	$response = array();

	$response['success'] = true;
	$response['message'] = 'Correo enviado correctamente.';

	header('Content-Type: application/json');
	echo json_encode($response);
} catch (Exception $e) {
	echo "Mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
}
