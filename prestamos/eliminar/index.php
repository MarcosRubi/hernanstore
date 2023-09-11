<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';


$Obj_Prestamos = new Prestamos();

$Res_Prestamo = $Obj_Prestamos->buscarPorId($_GET['id']);


if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

$Res_BorrarPrestamo = $Obj_Prestamos->Eliminar($_GET['id']);

if ($Res_BorrarPrestamo) {
    $_SESSION['msg'] = 'Préstamo eliminado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/listar/cliente/?id=" . $_GET['id_cliente']);
    return;
}
