<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';


$Obj_Prestamos = new Prestamos();

var_dump($_POST);

$Obj_Prestamos->num_cuotas = intval(trim(strip_tags($_POST['numCuotas'])));

$Res_Prestamo = $Obj_Prestamos->ActualizarNumCuotas($_POST['id_prestamo']);

if ($Res_Prestamo) {

    $_SESSION['msg'] = 'El número de cuotas ha sido actualizado y el préstamo fue marcado como completado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/pago-cuota/?id=" . $_POST['id_prestamo']);
}
