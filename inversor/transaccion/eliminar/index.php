<?php
require_once '../../../func/LoginValidator.php';
require_once '../../../bd/bd.php';
require_once '../../../class/TransaccionesInversores.php';


$Obj_TransaccionesInversores = new TransaccionesInversores();

if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}


$Res_TransaccionInversor = $Obj_TransaccionesInversores->Eliminar($_GET['id']);

if ($Res_TransaccionInversor) {
    $_SESSION['msg'] = 'Transacción eliminada correctamente.';
    $_SESSION['type'] = 'success';
    echo "<script>history.back();</script>";
    return;
}
