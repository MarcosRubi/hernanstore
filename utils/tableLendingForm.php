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
$fechaUltimoPago = $numCuotas - 1 === 0 ? $DatosPrestamo['fecha_primer_pago'] : $DatosPrestamo['fecha_siguiente_pago'];

$fechasPagos = $Obj_Reset->GenerarFechasCuotas($fechaUltimoPago, $cuotasRestantes, $plazoEntrePagos);

$Res_CapitalPagado = $Obj_Cuotas->CapitalPagado($_GET['id']);

$capitalPagado = $Res_CapitalPagado->fetch_assoc()['total'];
$CapitalRestante = $DatosPrestamo['capital_prestamo'] + $DatosPrestamo['ganancias'] - $capitalPagado;
$cuotasFaltantes = $cuotasRestantes - $numCuotas + 1;

$ValorAgregadoSiguienteCuota = $CapitalRestante - ($DatosPrestamo['valor_cuota'] * $cuotasFaltantes);

if ($ValorAgregadoSiguienteCuota <= 0) {
    if ($CapitalRestante > $DatosPrestamo['valor_cuota']) {
        if ($DatosPrestamo['valor_cuota'] + $ValorAgregadoSiguienteCuota <= 0) {
            $ValorAgregadoSiguienteCuota = 0;
        } else {
            $ValorAgregadoSiguienteCuota =  $DatosPrestamo['valor_cuota'] + $ValorAgregadoSiguienteCuota;
        }
    } else {
        $ValorAgregadoSiguienteCuota =  $CapitalRestante;
    }
} else {
    $ValorAgregadoSiguienteCuota = $ValorAgregadoSiguienteCuota + $DatosPrestamo['valor_cuota'];
}
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
                                            <th style="width:120px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($cuotasFaltantes !== intval($DatosPrestamo['num_cuotas'])) {
                                        ?>
                                            <div class="card  <?= $CapitalRestante === 0 ? '' : 'collapsed-card' ?>">
                                                <div class="card-header bg-olive">
                                                    <h3 class="card-title">Ver historial de pagos</h3>

                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse"><i class="fas <?= $CapitalRestante === 0 ? 'fa-minus' : 'fa-plus' ?> "></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.card-tools -->
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group container-fluid">
                                                            <span class="font-weight-bold text-lg"># cuota</span>
                                                        </div>
                                                        <div class="form-group container-fluid">
                                                            <span class="font-weight-bold text-lg">Fecha de pago</span>
                                                        </div>
                                                        <div class="form-group container-fluid">
                                                            <span class="font-weight-bold text-lg">Valor cuota</span>
                                                        </div>
                                                        <div class="form-group container-fluid">
                                                            <span class="font-weight-bold text-lg">Estado</span>
                                                        </div>
                                                        <div class="d-flex align-items-center form-group">
                                                            <span class="font-weight-bold text-lg mx-4">Acciones</span>

                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($Res_DatosCuotas->num_rows > 0) {
                                                        while ($DatosCuota = $Res_DatosCuotas->fetch_assoc()) {
                                                    ?>
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-group container-fluid">
                                                                    <input type="text" class="form-control" value="<?= $DatosCuota['num_cuota'] ?>" readonly />
                                                                </div>
                                                                <div class="form-group container-fluid">
                                                                    <input type="text" class="form-control" value="<?= $Obj_Reset->FechaInvertir($DatosCuota['fecha_pago']) ?>" readonly />
                                                                </div>
                                                                <div class="form-group container-fluid">
                                                                    <input type="text" class="form-control" value="<?= $DatosCuota['pago_cuota']  ?>" readonly />
                                                                </div>
                                                                <div class="form-group container-fluid">
                                                                    <input type="text" value="<?= $DatosCuota['estado_cuota']  ?>" class="form-control" readonly>
                                                                </div>
                                                                <div class="d-flex align-items-center form-group">
                                                                    <a href="#" class=" btn bg-orange mx-2" title="Editar" onclick="javascript:editarCuota(<?= $DatosCuota['id_cuota'] ?>);">
                                                                        <i class="fa fa-edit "></i>
                                                                    </a>
                                                                    <a href="#" class=" btn btn-danger mx-2" title="Eliminar" onclick="javascript:eliminarCuota(<?php echo $DatosCuota['id_cuota'] . "," .  $_GET['id'] ?>);">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>

                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        <?php  } ?>


                                        <?php for ($i = 1; $i <= $DatosPrestamo['num_cuotas'] - ($numCuotas - 1); $i++) { ?>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" <?= $i + $numCuotas - 1 === $numCuotas ? 'name="txtNumCuota"' : '' ?> value="<?= $i + $numCuotas - 1 ?>" readonly />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group container-fluid">
                                                        <?php
                                                        if ($i + $numCuotas - 1 === $numCuotas) {
                                                        ?>
                                                            <div class="input-group date" id="dateStart" data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateStart" data-inputmask-alias="datetime" placeholder="dd-mm-yyyy" name="txtFechaPago" id="date-start" value="<?= $Obj_Reset->FechaInvertir($fechasPagos[$i - 1]) ?>">
                                                                <div class="input-group-append" data-target="#dateStart" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } else {
                                                        ?>
                                                            <input type="text" class="form-control" value="<?= $Obj_Reset->FechaInvertir($fechasPagos[$i - 1]) ?>" readonly />
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-form">
                                                        <input type="text" class="form-control" value="<?= $i + $numCuotas - 1 === $numCuotas ?  $ValorAgregadoSiguienteCuota : $DatosPrestamo['valor_cuota'] ?>" <?= $i + $numCuotas - 1 === $numCuotas ? '' : 'readonly' ?> <?= $i + $numCuotas - 1 === $numCuotas ? 'name="txtValorCuota"' : '' ?> />
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if ($numCuotas - 1 !== intval($DatosPrestamo['num_cuotas'])) { ?>
                                                        <?= $i + $numCuotas - 1 === $numCuotas ? '<button class="btn btn-primary" type="submit">Agregar pago</button>' : '' ?>
                                                    <?php  } ?>
                                                </td>
                                            </tr>
                                            <?php if ($i + $numCuotas - 1 === $numCuotas) { ?>
                                                <input type="text" class="form-control d-none" name="txtFechaSiguientePago" value="<?= $Obj_Reset->FechaInvertir($fechasPagos[$i]) ?>" readonly id="fecha_siguiente_pago" />
                                            <?php }
                                            ?>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                                <!-- /.form group -->
                                <input type="hidden" value="<?= $_GET['id'] ?>" name="txtIdPrestamo" class="form-control">
                                <input type="hidden" value="<?= $DatosPrestamo['valor_cuota'] ?>" name="valor_cuota" class="form-control">
                                <input type="hidden" value="<?= $DatosPrestamo['fecha_siguiente_pago'] ?>" name="fecha_siguiente_pago" class="form-control">

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
    });

    function eliminarCuota(id, id_prestamo) {
        let confirmacion = confirm("¿Está seguro que desea eliminar una cuota?");

        if (confirmacion) {
            window.location.href = '<?= $_SESSION['path'] ?>/cuota/eliminar/?id=' + id + '&id_prestamo=' + id_prestamo
        }
    }

    function editarCuota(id) {
        // Dimensiones de la ventana
        var ancho = 1000;
        var alto = 600;

        // Calcula la posición para centrar la ventana en el viewport
        var left = (window.innerWidth - ancho) / 2;
        var top = (window.innerHeight - alto) / 2;

        // Abre la URL en una ventana flotante
        window.open('<?= $_SESSION['path'] ?>/cuota/actualizar/?id=' + id, 'Actualizar cuota', 'width=' + ancho + ', height=' + alto + ', left=' + left + ', top=' + top);
    }
</script>

<?php
if ($CapitalRestante === 0 && ($numCuotas - 1 !== $cuotasRestantes) && $cuotasFaltantes !== 0) {
    $id_prestamo = $DatosPrestamo['id_prestamo'];
    $numCuotas = $numCuotas - 1;
?>

    <script>
        // Muestra el cuadro de diálogo de confirmación
        var id_prestamo = <?php echo json_encode($id_prestamo); ?>;
        var numCuotas = <?php echo json_encode($numCuotas); ?>;

        var mensaje = "El préstamo fue pagado antes de las cuotas acordadas, desea actualizar el número de cuotas del préstamo y marcarlo como completado?";

        var respuesta = confirm(mensaje);

        // Si el usuario hace clic en "Aceptar", redirige o realiza alguna acción
        if (respuesta) {
            // Crea un formulario oculto
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "./actualizar-cuotas-prestamo.php"; // Ruta al archivo PHP de destino

            // Crea campos de entrada ocultos para los parámetros
            var id_prestamoInput = document.createElement("input");
            id_prestamoInput.type = "hidden";
            id_prestamoInput.name = "id_prestamo"; // Nombre del parámetro
            id_prestamoInput.value = id_prestamo; // Valor del parámetro
            form.appendChild(id_prestamoInput);

            var numCuotasInput = document.createElement("input");
            numCuotasInput.type = "hidden";
            numCuotasInput.name = "numCuotas"; // Nombre del parámetro
            numCuotasInput.value = numCuotas; // Valor del parámetro
            form.appendChild(numCuotasInput);

            // Agrega el formulario al cuerpo del documento y envíalo
            document.body.appendChild(form);
            form.submit();
        }
    </script>
<?php
}
?>