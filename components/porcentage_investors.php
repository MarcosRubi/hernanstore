<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/TransaccionesInversores.php';
require_once '../class/Reset.php';

if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    header("Location:" . $_SESSION['path']);
    return;
}

$Obj_TransaccionesInversores = new TransaccionesInversores();
$Obj_Reset = new Reset();

$Res_TotalInvertido = $Obj_TransaccionesInversores->ObtenerTotalInvertido();
$totalInvertido = $Res_TotalInvertido->fetch_assoc()['saldo'];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Monto requerido para pago de inversionistas</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Total de inversionistas </th>
                    <th>20%</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="d-block"><?=$Obj_Reset->FormatoDinero($totalInvertido) ?></span>
                    </td>
                    <td>
                        <span class="d-block"><?=$Obj_Reset->FormatoDinero(($totalInvertido * 20) / 100) ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>