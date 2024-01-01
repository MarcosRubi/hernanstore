<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Excedente.php';


$Obj_Excedente = new Excedente();

$Obj_Excedente->notas = $_POST['txtNotas'];
$Obj_Excedente->monto = $_POST['txtMonto'];


if (filter_var(trim($_POST['txtMonto']), FILTER_VALIDATE_FLOAT) || trim($_POST['txtMonto']) == "0") {
    $Res_Excedente = $Obj_Excedente->actualizar($_POST['id_excedente']);
    
    $response = array();
    
    if ($Res_Excedente) {
        $response['success'] = true;
        $response['message'] = 'Los datos han sido actualizados correctamente.';
    } else {
        $response['success'] = false;
        $response['message'] = 'Hubo un error al actualizar los datos.';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'El monto no es válido.';
}

header('Content-Type: application/json');
echo json_encode($response);
