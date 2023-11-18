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


if ($valorPrestamo === 0.0 || $numeroCuotas === 0 || trim($_POST['formData']['txtFechaPrimerPago']) === '') {
    return;
}

$gananciaInteres = doubleval(trim($_POST['formData']['txtInteres']));
$gananciaPorcentajeInteres = doubleval(trim($_POST['formData']['txtPorcentajeInteres']));
$plazoEntrePagos = $Obj_Reset->PlazoEntrePagos(intval(trim($_POST['formData']['txtIdPlazoPago'])));
$fechaPrimerPago = $Obj_Reset->FechaInvertirGuardar(trim($_POST['formData']['txtFechaPrimerPago']));

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
$mediaTotal = ($valorPrestamo + $gananciaInteres) /  $numeroCuotas;
?>
<div class="pt-3 ">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title w-100 font-weight-bold text-center">Tabla de cuotas</h3>
                        </div>
                        <div class="card-body">
                            <table id="table-payments" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th># Cuota</th>
                                        <th>Fecha de pago</th>
                                        <th>Valor cuota</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i <= intval(trim($_POST['formData']['txtNumCuotas'])); $i++) {
                                        if($i === intval(trim($_POST['formData']['txtNumCuotas']))){
                                        ?>
                                            <input type="text" class="d-none" name="txtFechaUltimoPago" value="<?= $fechasPagos[$i -1 ] ?>" id="fechaUltimoPago">
                                        <?php } ?>
                                        <tr>
                                            <td>
                                                <p><?= $i ?></p>
                                            </td>
                                            <td>
                                                <p><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($fechasPagos[$i - 1])) ?></p>
                                            </td>
                                            <td>
                                                <p><?= $Obj_Reset->FormatoDinero($mediaTotal) ?></p>
                                            </td>
                                            <td>
                                                <p>Pendiente</p>
                                            </td>
                                        </tr>
                                    <?php  } ?>
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
    $('#table-payments').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });;
</script>