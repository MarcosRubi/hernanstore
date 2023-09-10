<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';
require_once '../../class/Reset.php';


$Obj_Prestamos = new Prestamos();
$Obj_Reset = new Reset();

//VALIDANDO CAMPOS NO VACIOS
if (trim($_POST['txtValor']) === '') {
    $_SESSION['msg'] = 'Ingrese el monto del préstamo.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (!is_numeric(trim($_POST['txtValor']))) {
    $_SESSION['msg'] = 'El valor ingresado del préstamo no es válido.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (trim(strip_tags($_POST['txtInteres'])) === '') {
    $_SESSION['msg'] = 'Ingrese el porcentaje de intereses del préstamo.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (trim($_POST['txtFechaInicio']) === '') {
    $_SESSION['msg'] = 'Ingrese la fecha a realizar el primer pago.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

$Obj_Prestamos->recalcular_interes = 'N';
$Obj_Prestamos->ganancias = (doubleval(trim($_POST['txtValor'])) * doubleval(trim($_POST['txtInteres']))) / 100;
$Obj_Prestamos->capital_prestamo = doubleval(trim(strip_tags($_POST['txtValor'])));
$Obj_Prestamos->num_cuotas = intval(trim(strip_tags($_POST['txtNumCuotas'])));
$Obj_Prestamos->porcentaje_interes = doubleval(trim(strip_tags($_POST['txtInteres'])));
$Obj_Prestamos->fecha_primer_pago = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaInicio'])));
$Obj_Prestamos->id_estado = intval(trim(strip_tags($_POST['txtIdEstado'])));
$Obj_Prestamos->id_cliente = intval(trim(strip_tags($_POST['txtIdCliente'])));
$Obj_Prestamos->id_plazo_pago = intval(trim(strip_tags($_POST['txtIdPlazoPago'])));

if (isset($_POST['chkRecalcular'])) {
    $Obj_Prestamos->recalcular_interes = 'S';
}

$Res_Prestamos = $Obj_Prestamos->Insertar();

if ($Res_Prestamos) {

    $_SESSION['msg'] = 'Préstamo creado correctamente.';
    $_SESSION['type'] = 'success';
    header("Location:" . $_SESSION['path'] . "/prestamos/listar/cliente/?id=" . $_POST['txtIdCliente']);
}