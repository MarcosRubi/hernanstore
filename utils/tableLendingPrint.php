<?php
session_start();
require_once '../bd/bd.php';
require_once '../class/Clientes.php';
require_once '../class/Prestamos.php';
require_once '../class/Cuotas.php';
require_once '../class/Reset.php';


$Obj_Clientes = new Clientes();
$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();
$Obj_Reset = new Reset();

$valorPrestamo = doubleval(trim($_POST['formData']['txtValor']));
$numeroCuotas = intval(trim($_POST['formData']['txtNumCuotas']));
$valorCuota = doubleval(trim($_POST['formData']['txtValorCuota']));

if ($valorPrestamo === 0.0 || $numeroCuotas === 0 || trim($_POST['formData']['txtFechaInicio']) === '') {
    return;
}

$plazoEntrePagos = $Obj_Reset->PlazoEntrePagos(intval(trim($_POST['formData']['txtIdPlazoPago'])));
$fechaPrimerPago = $Obj_Reset->FechaInvertirGuardar(trim($_POST['formData']['txtFechaInicio']));

$fechasPagos = $Obj_Reset->GenerarFechasCuotas($fechaPrimerPago, $numeroCuotas, $plazoEntrePagos);

$Res_Cuotas = $Obj_Cuotas->buscarPorIdPrestamo($_POST['formData']['txtIdPrestamo']);
$cuotasRealizadas = $Res_Cuotas->num_rows;

$Res_CapitalPagado = $Obj_Cuotas->CapitalPagado($_POST['formData']['txtIdPrestamo']);

$capitalPagado = $Res_CapitalPagado->fetch_assoc()['total'];
$CapitalRestante = $valorPrestamo + $_POST['formData']['txtGanancia'] - $capitalPagado;
$cuotasFaltantes = $numeroCuotas - $cuotasRealizadas;

$ValorAgregadoSiguienteCuota = $CapitalRestante - ($valorCuota * $cuotasFaltantes);
?>
<div class="">
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
                                    <?php while ($DatosCuotas = $Res_Cuotas->fetch_assoc()) { ?>
                                        <tr>
                                            <td>
                                                <p><?= $DatosCuotas['num_cuota'] ?></p>
                                            </td>
                                            <td>
                                                <p><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($DatosCuotas['fecha_pago'])) ?></p>
                                            </td>
                                            <td>
                                                <p><?= $Obj_Reset->FormatoDinero($DatosCuotas['pago_cuota']) ?></p>
                                            </td>
                                            <td>
                                                <p><?= $DatosCuotas['estado_cuota'] ?></p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php for ($i = $cuotasRealizadas + 1; $i <= intval(trim($_POST['formData']['txtNumCuotas'])); $i++) { ?>
                                        <tr>
                                            <td>
                                                <p><?= $i ?></p>
                                            </td>
                                            <td>
                                                <p><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($fechasPagos[$i - 1])) ?></p>
                                            </td>
                                            <td>
                                                <p><?= $i === $cuotasRealizadas + 1 ? $Obj_Reset->FormatoDinero($valorCuota + $ValorAgregadoSiguienteCuota) : $Obj_Reset->FormatoDinero($valorCuota) ?></p>
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
    $(function() {})
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