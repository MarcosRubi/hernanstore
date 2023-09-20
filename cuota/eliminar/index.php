<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Cuotas.php';


$Obj_Cuotas = new Cuotas();

$Res_Cuotas = $Obj_Cuotas->Eliminar($_GET['id']);


if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
}

if ($Res_Cuotas) {
    $_SESSION['msg'] = 'Cuota eliminada correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/pago-cuota/?id=" . $_GET['id_prestamo']);
    return;
}
