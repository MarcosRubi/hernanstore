<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';


$Obj_Prestamos = new Prestamos();

$Obj_Prestamos->detalles = $_POST['txtInformacion'];

$Res_Prestamo = $Obj_Prestamos->actualizarDetalles($_POST['id_prestamo']);

$response = array();

if ($Res_Prestamo) {
    $response['success'] = true;
    $response['message'] = 'Los detalles del préstamo han sido actualizados correctamente.';
} else {
    $response['success'] = false;
    $response['message'] = 'Hubo un error al actualizar los detalles del préstamo.';
}

header('Content-Type: application/json');
echo json_encode($response);
