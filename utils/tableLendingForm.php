<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Clientes.php';
require_once '../class/Cuotas.php';
require_once '../class/Prestamos.php';
require_once '../class/Reset.php';


$Obj_Clientes = new Clientes();
$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();
$Obj_Reset = new Reset();


$Res_DatosCuotas = $Obj_Cuotas->buscarPorIdPrestamo($_GET['id']);
$Res_EstadosCuotas = $Obj_Prestamos->listarEstadosCuotas();

$Res_DatosPrestamos = $Obj_Prestamos->ListarDatosParaDocumento($_GET['id']);
$DatosPrestamo = $Res_DatosPrestamos->fetch_assoc();

$numCuotas = $Res_DatosCuotas->num_rows + 1;
$cuotasRestantes = $DatosPrestamo['num_cuotas'];
$plazoEntrePagos = $Obj_Reset->PlazoEntrePagos($DatosPrestamo['id_plazo_pago']);
$fechaUltimoPago = $DatosPrestamo['fecha_primer_pago'];

$fechasPagos = $Obj_Reset->GenerarFechasCuotas($fechaUltimoPago, $cuotasRestantes, $plazoEntrePagos);

$Res_CapitalPagado = $Obj_Cuotas->CapitalPagado($_GET['id']);

$capitalPagado = $Res_CapitalPagado->fetch_assoc()['total'];
$CapitalRestante = $DatosPrestamo['capital_prestamo'] + $DatosPrestamo['ganancias'] - $capitalPagado;
$cuotasFaltantes = $cuotasRestantes - $numCuotas + 1;

$ValorAgregadoSiguienteCuota = $CapitalRestante - ($DatosPrestamo['valor_cuota'] * $cuotasFaltantes);
?>
<div class="">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title w-100 font-weight-bold text-center">Tabla de cuotas</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= $_SESSION['path'] . '/prestamos/pago-cuota/insertar.php' ?>" method="post" class="card-body" id="frmNuevoPrestamo">
                                <table id="table-payments" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th># Cuota</th>
                                            <th>Fecha de pago</th>
                                            <th>Valor cuota</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($Res_DatosCuotas->num_rows > 0) {
                                            while ($DatosCuota = $Res_DatosCuotas->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td>
                                                        <div class="form-group ">
                                                            <input type="text" class="form-control" value="<?= $DatosCuota['num_cuota'] ?>" readonly />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group container-fluid">
                                                            <input type="text" class="form-control" value="<?= $Obj_Reset->FechaInvertir($DatosCuota['fecha_pago']) ?>" readonly />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-form">
                                                            <input type="text" class="form-control" value="<?= $DatosCuota['pago_cuota']  ?>" readonly />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group container-fluid">
                                                            <input type="text" value="<?= $DatosCuota['estado_cuota']  ?>" class="form-control" readonly>
                                                        </div>
                                                    </td>
                                                    <td>a</td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <?php for ($i = 1; $i <= $DatosPrestamo['num_cuotas'] - ($numCuotas - 1); $i++) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" <?= $i + $numCuotas - 1 === $numCuotas ? 'name="txtNumCuota"' : '' ?> value="<?= $i + $numCuotas - 1 ?>" readonly />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group container-fluid">
                                                        <?php
                                                        if ($i + $numCuotas - 1 === $numCuotas) {
                                                        ?>
                                                            <div class="input-group date" id="dateStart" data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateStart" data-inputmask-alias="datetime" placeholder="dd-mm-yyyy" name="txtFechaPago" id="date-start" value="<?= $Obj_Reset->FechaInvertir($fechasPagos[$i + $numCuotas - 2]) ?>">
                                                                <div class="input-group-append" data-target="#dateStart" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } else {
                                                        ?>
                                                            <input type="text" class="form-control" value="<?= $Obj_Reset->FechaInvertir($fechasPagos[$i + $numCuotas - 2]) ?>" readonly />
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-form">
                                                        <input type="text" class="form-control" value="<?= $i + $numCuotas - 1 === $numCuotas ? $DatosPrestamo['valor_cuota'] + $ValorAgregadoSiguienteCuota : $DatosPrestamo['valor_cuota'] ?>" <?= $i + $numCuotas - 1 === $numCuotas ? '' : 'readonly' ?> <?= $i + $numCuotas - 1 === $numCuotas ? 'name="txtValorCuota"' : '' ?> />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group container-fluid">
                                                        <?php if ($i + $numCuotas - 1 === $numCuotas) { ?>
                                                            <select class="form-control select2" style="width: 100%;" name="txtIdEstadoCuota">
                                                                <?php while ($EstadosCuotas = $Res_EstadosCuotas->fetch_assoc()) { ?>
                                                                    <option value="<?= $EstadosCuotas['id_estado_cuota'] ?>"><?= $EstadosCuotas['estado_cuota'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } else { ?>
                                                            <input type="text" value="Pendiente" class="form-control" readonly>
                                                        <?php  } ?>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                                <!-- /.form group -->
                                <input type="hidden" value="<?= $_GET['id'] ?>" name="txtIdPrestamo" class="form-control">
                                <?php if ($numCuotas - 1 !== intval($DatosPrestamo['num_cuotas'])) { ?>
                                    <div class="d-flex flex-wrap justify-content-center align-items-center">
                                        <div class="form-group pr-1 flex-grow-1 ">
                                            <a href="../listar/cliente/?id=<?= $DatosPrestamo['id_cliente'] ?>" class="btn btn-lg btn-secondary text-center btn-block" type="reset">Cancelar</a>
                                        </div>
                                        <div class="form-group pl-1 flex-grow-1">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit">Realizar pago cuota</button>
                                        </div>
                                    </div>
                                <?php  } ?>
                            </form>
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
        $(function() {
            // Summernote
            $('.select2').select2()

            $('#dateStart').datetimepicker({
                format: 'DD-MM-YYYY'
            });
        })
    })
    $('#table-payments').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": true,
        "responsive": true,
    });;
</script>