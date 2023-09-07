<?php
session_start();
require_once '../bd/bd.php';
require_once '../class/Clientes.php';
require_once '../class/Prestamos.php';
require_once '../class/Reset.php';


$Obj_Clientes = new Clientes();
$Obj_Prestamos = new Prestamos();
$Obj_Reset = new Reset();

$Res_EstadosCuotas = $Obj_Prestamos->listarEstadosCuotas();

$valorPrestamo = doubleval(trim($_POST['formData']['txtValor']));
$numeroCuotas = intval(trim($_POST['formData']['txtNumCuotas']));


if ($valorPrestamo === 0.0 || $numeroCuotas === 0 || trim($_POST['formData']['txtFechaInicio']) === '') {
    return;
}

$porcentajeInteres = doubleval(trim($_POST['formData']['txtInteres']));
$plazoEntrePagos = plazoEntrePagos(intval(trim($_POST['formData']['txtIdPlazoPago'])));
$fechaPrimerPago = $Obj_Reset->FechaInvertirGuardar(trim($_POST['formData']['txtFechaInicio']));

// Función para obtener el valor correspondiente
function plazoEntrePagos($id_plazo)
{
    $plazoDePagos = array(
        2 => 1,
        3 => 7,
        4 => 15,
        5 => 30,
    );

    if (isset($plazoDePagos[$id_plazo])) {
        return $plazoDePagos[$id_plazo];
    } else {
        // Valor predeterminado si no se encuentra en el diccionario
        return null;
    }
}

function calcularMontoCuotas($valorPrestamo, $numeroCuotas, $porcentajeInteres)
{
    $montoCuotas = [];

    // Calcula el valor base para cada cuota (igualmente dividido)
    $valorBase = $valorPrestamo / $numeroCuotas;

    // Inicializa el saldo restante
    $saldoRestante = $valorPrestamo;

    // Calcula el monto de cada cuota y almacénalo en un arreglo
    for ($i = 1; $i <= $numeroCuotas; $i++) {
        // Calcula el interés para esta cuota
        $interes = ($saldoRestante * $porcentajeInteres) / 100;

        // Calcula el monto de la cuota
        $montoCuota = $valorBase + $interes;

        // Agrega el monto de la cuota al arreglo
        $montoCuotas[] = $montoCuota;

        // Actualiza el saldo restante restando el valor base
        $saldoRestante -= $valorBase;
    }

    // Calcula la media de las cuotas
    $media = array_sum($montoCuotas) / $numeroCuotas;

    return number_format($media, 2);
}

function generarFechasCuotas($fechaPrimerPago, $numeroCuotas, $diasEntrePlazos)
{
    $fechasCuotas = array();
    $fechaActual = strtotime($fechaPrimerPago); // Convierte la fecha inicial a un timestamp

    // Agrega la fecha inicial al array de fechas
    $fechasCuotas[] = date('Y-m-d', $fechaActual);

    // Genera las fechas para las cuotas restantes
    for ($i = 1; $i < $numeroCuotas; $i++) {
        // Aumenta la fecha actual en el número de días entre plazos
        $fechaActual = strtotime("+$diasEntrePlazos days", $fechaActual);

        // Si la fecha resultante es un domingo, suma un día adicional
        if (date('w', $fechaActual) == 0) {
            $fechaActual = strtotime('+1 day', $fechaActual);
        }

        // Agrega la fecha al array de fechas
        $fechasCuotas[] = date('Y-m-d', $fechaActual);
    }

    return $fechasCuotas;
}


$mediaTotal = calcularMontoCuotas($valorPrestamo, $numeroCuotas, $porcentajeInteres);
$fechasPagos = generarFechasCuotas($fechaPrimerPago, $numeroCuotas, $plazoEntrePagos);

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
                                        <th>Valor cancelado</th>
                                        <th>Estado</th>
                                        <!-- <th>Acciones</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i <= intval(trim($_POST['formData']['txtNumCuotas'])); $i++) { ?>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="txtNombre" value="<?= $i ?>" readonly>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="txtFecha" value="<?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($fechasPagos[$i - 1])) ?>" readonly>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="txtValorCuota" value="<?= $mediaTotal ?>" readonly>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="txtValorCuotaCancelado" value="$29" readonly>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" value="Pendiente" readonly>
                                                        <!-- <select class="form-control select2" style="width: 100%;" name="txtIdEstado">
                                                        <?php
                                                        #while ($EstadosCuotas = $Res_EstadosCuotas->fetch_assoc()) { 
                                                        ?>
                                                            <option value="<?= $EstadosCuotas['id_estado_cuota'] ?>"><?= $EstadosCuotas['estado_cuota'] ?></option>
                                                        <?php #} 
                                                        ?>
                                                    </select> -->
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- <td>
                                            <?php #if (intval($_SESSION['id_rol']) <= 3) { 
                                            ?>
                                                <a href="#" class=" btn btn-danger" title="Eliminar" onclick="javascript:eliminarCuota();">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            <?php #} 
                                            ?>
                                        </td> -->
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