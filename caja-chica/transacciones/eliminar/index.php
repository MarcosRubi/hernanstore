<?php
require_once '../../../func/LoginValidator.php';
require_once '../../../bd/bd.php';
require_once '../../../class/TransaccionesAdicionales.php';

if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    header("Location:" . $_SESSION['path']);
    return;
}

$Obj_TransaccionesAdicionales = new TransaccionesAdicionales();

$Res_TransaccionesAdicionales = $Obj_TransaccionesAdicionales->Eliminar($_GET['id']);

if ($Res_TransaccionesAdicionales) {
    $_SESSION['msg'] = 'Transacción eliminada correctamente.';
    $_SESSION['type'] = 'success';
    echo "<script>let URL = window.opener.location.pathname;
    window.opener.location.reload();
    history.back();</script>";
    return;
}
