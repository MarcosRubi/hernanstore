<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';

if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    header("Location:" . $_SESSION['path']);
    return;
}

$Obj_Clientes = new Clientes();


$Obj_Clientes->nombre_cliente = preg_replace('/\s+/', ' ', trim(strip_tags(ucwords(strtolower(trim($_POST['txtNombre']))))));
$Obj_Clientes->telefono = strip_tags(trim(str_replace("_", "", $_POST['txtTelefono'])));
$Obj_Clientes->direccion = preg_replace('/\s+/', ' ', trim(strip_tags(ucwords(strtolower(trim($_POST['txtDireccion']))))));
$Obj_Clientes->correo =  strip_tags(strtolower(trim($_POST['txtCorreo'])));
$Obj_Clientes->descripcion =  trim($_POST['txtInformacion']);

if (trim($_POST['txtNombre']) === '') {
    $_SESSION['msg'] = 'Ingrese el nombre del cliente.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

$Res_Clientes = $Obj_Clientes->Actualizar($_POST['id']);

$response = array();

if ($Res_Clientes) {
    $response['success'] = true;
    $response['message'] = 'Datos actualizados correctamente.';
} else {
    $response['success'] = false;
    $response['message'] = 'Hubo un error al actualizar los datos del cliente.';
}

header('Content-Type: application/json');
echo json_encode($response);
