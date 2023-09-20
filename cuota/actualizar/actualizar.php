<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Cuotas.php';
require_once '../../class/Reset.php';


$Obj_Cuotas = new Cuotas();
$Obj_Reset = new Reset();

//VALIDANDO CAMPOS NO VACIOS
if (trim($_POST['txtPagoCuota']) === '') {
    $_SESSION['msg'] = 'Ingrese el monto de la cuota.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};
if (!is_numeric(trim($_POST['txtPagoCuota']))) {
    $_SESSION['msg'] = 'El valor ingresado de la cuota no es válido.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

if (trim($_POST['txtFechaPago']) === '') {
    $_SESSION['msg'] = 'Ingrese la fecha que se realizó el pago.';
    $_SESSION['type'] = 'error';
    echo "<script>history.back();</script>";
    return;
};

$Obj_Cuotas->fecha_pago = $Obj_Reset->FechaInvertirGuardar(trim(strip_tags($_POST['txtFechaPago'])));
$Obj_Cuotas->id_estado_cuota = intval(trim(strip_tags($_POST['txtIdEstadoCuota'])));
$Obj_Cuotas->pago_cuota =  number_format(doubleval(trim($_POST['txtPagoCuota'])), 2);


$Res_Cuotas = $Obj_Cuotas->Actualizar($_POST['txtIdCuota']);

if ($Res_Cuotas) {

    $_SESSION['msg'] = 'Cuota actualizada correctamente.';
    $_SESSION['type'] = 'success';
    echo "<script>
    let URL = window.opener.location.pathname;
        window.opener.location.reload();
    window.close();
</script>";
    return;
}
