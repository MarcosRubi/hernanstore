<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';


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

if ($Res_Clientes) {
    $_SESSION['msg'] = 'Datos actualizados correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/cliente/?id=" . $_POST['id']);
}
