<?php
session_start();
require_once '../bd/bd.php';
require_once '../class/Clientes.php';
require_once '../class/Prestamos.php';
require_once '../class/Reset.php';


$Obj_Clientes = new Clientes();
$Obj_Prestamos = new Prestamos();
$Obj_Reset = new Reset();

$valorPrestamo = doubleval(trim($_POST['formData']['txtValor']));
$numeroCuotas = intval(trim($_POST['formData']['txtNumCuotas']));


if ($valorPrestamo === 0.0 || $numeroCuotas === 0 || trim($_POST['formData']['txtFechaInicio']) === '') {
    return;
}

$gananciaInteres = doubleval(trim($_POST['formData']['txtInteres']));
$gananciaPorcentajeInteres = doubleval(trim($_POST['formData']['txtPorcentajeInteres']));
$plazoEntrePagos = $Obj_Reset->PlazoEntrePagos(intval(trim($_POST['formData']['txtIdPlazoPago'])));
$fechaPrimerPago = $Obj_Reset->FechaInvertirGuardar(trim($_POST['formData']['txtFechaInicio']));

$fechasPagos = $Obj_Reset->GenerarFechasCuotas($fechaPrimerPago, $numeroCuotas, $plazoEntrePagos);

if (isset($_POST['formData']['chkRecalcular'])) {
    $plazoPago = intval($_POST['formData']['txtIdPlazoPago']);

    $cuotasElegidas = [];

    switch ($plazoPago) {
        case 5: //mensual
            $cuotasElegidas = range(1, 500);
            break;
        case 4: // quincenal
            $cuotasElegidas = range(1, 501, 2);
            break;
        case 3: // semanal
            $cuotasElegidas = range(1, 501, 4);
            break;
        case 2: // diario
            $cuotasElegidas = range(1, 500, 24);
            break;
    }

    $total = $Obj_Reset->calcularMontoCuotasConInteresMensual($valorPrestamo, $numeroCuotas, $gananciaPorcentajeInteres, $cuotasElegidas);
} else {
    $total = $Obj_Reset->CalcularMontoCuotas($valorPrestamo, $numeroCuotas, $gananciaPorcentajeInteres);
}
$interes = $total['interes'];
$valor = $total['valor'];
?>
<div class="pt-3 ">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-body">
                            <span>Capital prestado / número de cuotas</span>
                            <p><?= $Obj_Reset->FormatoDinero($valorPrestamo) ?> / <?= $numeroCuotas ?> = <b> <?= $Obj_Reset->FormatoDinero($valorPrestamo / $numeroCuotas) ?></b>, este es el valor que se resta en cada cuota </p>
                            <table id="table-assistan" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th># Cuota</th>
                                        <th>Saldo restante</th>
                                        <th>Interés</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i <= intval(trim($_POST['formData']['txtNumCuotas'])); $i++) { ?>
                                        <tr>
                                            <td>
                                                <p><?= $i ?></p>
                                            </td>
                                            <td>
                                                <p><?= $Obj_Reset->FormatoDinero($valor[$i - 1]) ?></p>
                                            </td>
                                            <td>
                                                <?php
                                                if (isset($_POST['formData']['chkRecalcular'])) {
                                                ?>
                                                    <p><?= $Obj_Reset->FormatoDinero($interes[$i - 1]) ?></p>
                                                    <?php
                                                } else {
                                                    if ($i === 1) {
                                                    ?>
                                                        <p><?= $Obj_Reset->FormatoDinero($interes) ?></p>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php  } ?>
                                    <tr>

                                        <?php
                                        if (isset($_POST['formData']['chkRecalcular'])) {
                                        ?>
                                            <td colspan="3">
                                                <p class="text-lg text-center">Ganancia en interés: <b>$<?= array_sum($interes) ?> </b></p>
                                            </td>
                                        <?php
                                        } else {
                                        ?>
                                            <td colspan="3">
                                                <p class="text-lg text-center">Ganancia en interés: <b>$<?= $interes ?> </b></p>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        // Summernote
        $('.select2').select2()
    })
    $('#table-assistan').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });;
</script>