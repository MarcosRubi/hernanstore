<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Cuotas.php';
require_once '../../class/Prestamos.php';
require_once '../../class/TransaccionesAdicionales.php';
require_once '../../class/TransaccionesInversores.php';
require_once '../../class/Reset.php';

$Obj_Cuotas = new Cuotas();
$Obj_Prestamos = new Prestamos();
$Obj_TransaccionesInversores = new TransaccionesInversores();
$Obj_TransaccionesAdicionales = new TransaccionesAdicionales();
$Obj_Reset = new Reset();

$fechaInicio = $_GET['inicio'];
$fechaFin = $_GET['fin'];

if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    header("Location:" . $_SESSION['path']);
    return;
}

$Res_Cuotas = $Obj_Cuotas->ObtenerIngresosAnualesPorSemanas($fechaInicio, $fechaFin);
$Res_Prestamos = $Obj_Prestamos->ObtenerEgresosAnualesPorSemanas($fechaInicio, $fechaFin);
$Res_TransaccionesAdicionales = $Obj_TransaccionesAdicionales->ObtenerEgresosAnualesPorSemanas($fechaInicio, $fechaFin);
$Res_TransaccionesInversores = $Obj_TransaccionesInversores->ObtenerEgresosAnualesPorSemanas($fechaInicio, $fechaFin);


$resultados_combinados = array();

while ($row_cuotas = $Res_Cuotas->fetch_assoc()) {
    $semana = $row_cuotas['semana'];
    $resultados_combinados[$semana]['suma_cuotas'] = $row_cuotas['suma_cuotas'];
    $resultados_combinados[$semana]['fecha_inicial_semana'] = $row_cuotas['fecha_inicial_semana'];
    $resultados_combinados[$semana]['fecha_final_semana'] = $row_cuotas['fecha_final_semana'];
}

while ($row_prestamos = $Res_Prestamos->fetch_assoc()) {
    $semana = $row_prestamos['semana'];
    $resultados_combinados[$semana]['suma_prestamos'] = $row_prestamos['suma_prestamos'];
}

while ($row_transacciones = $Res_TransaccionesAdicionales->fetch_assoc()) {
    $semana = $row_transacciones['semana'];
    if (!isset($resultados_combinados[$semana])) {
        $resultados_combinados[$semana] = array();
    }

    // Suma 'total_ingresos' a 'suma_cuotas' y 'total_egresos' a 'suma_prestamos'
    $resultados_combinados[$semana]['suma_cuotas'] += $row_transacciones['total_ingresos'];
    $resultados_combinados[$semana]['suma_prestamos'] += $row_transacciones['total_egresos'];
}
while ($row_transaccionesInversores = $Res_TransaccionesInversores->fetch_assoc()) {
    $semana = $row_transaccionesInversores['semana'];
    if (!isset($resultados_combinados[$semana])) {
        $resultados_combinados[$semana] = array();
    }

    // Suma 'total_ingresos' a 'suma_cuotas' y 'total_egresos' a 'suma_prestamos'
    $resultados_combinados[$semana]['suma_cuotas'] += $row_transaccionesInversores['total_ingresos'];
    $resultados_combinados[$semana]['suma_prestamos'] += $row_transaccionesInversores['total_egresos'];
}

$Res_CuotasDetalles = $Obj_Cuotas->ObtenerIngresosPorFechas($fechaInicio, $fechaFin);
$Res_PrestamosDetalles = $Obj_Prestamos->ObtenerEgresosPorFechas($fechaInicio, $fechaFin);
$Res_TransaccionesDetalles = $Obj_TransaccionesAdicionales->ObtenerEstadisticasPorFechas($fechaInicio, $fechaFin);
$Res_TransaccionesInversoresDetalles = $Obj_TransaccionesInversores->ObtenerEstadisticasPorFechas($fechaInicio, $fechaFin);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles <?= $Obj_Reset->FechaInvertir($fechaInicio) ?> - <?= $Obj_Reset->FechaInvertir($fechaFin) ?> | Hernan Store</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once '../../components/Navbar.php' ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once '../../components/Sidebar.php' ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="mt-5 col-12">
                            <div class="card ">
                                <div class="flex-wrap px-4 py-2 d-flex align-items-center justify-content-between">
                                    <h3 class="card-title">Resumen de la semana</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table_details" class="table table-bordered table-striped  table-hover">
                                        <thead>
                                            <tr>
                                                <th># Semana</th>
                                                <th>Desde</th>
                                                <th>Hasta</th>
                                                <th>Ingresos</th>
                                                <th>Egresos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($resultados_combinados as $semana => $datos) {
                                            ?>
                                                <tr>
                                                    <td><?= $semana ?></td>
                                                    <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($datos['fecha_inicial_semana'])) ?></td>
                                                    <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($datos['fecha_final_semana'])) ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($datos['suma_cuotas']) ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($datos['suma_prestamos']) ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->

                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="mt-5 col-12">
                            <div class="card ">
                                <div class="flex-wrap px-4 py-2 d-flex align-items-center justify-content-between">
                                    <h3 class="card-title">Detalles sobre capital entrante por cuotas (Ingresos)</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table_incomes" class="table table-bordered table-striped  table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($DatosCuota = $Res_CuotasDetalles->fetch_assoc()) {
                                                if ($DatosCuota['pago_cuota'] > 0) {
                                            ?>
                                                    <tr>
                                                        <td><?= $DatosCuota['nombre_cliente'] ?></td>
                                                        <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($DatosCuota['fecha_pago'])) ?></td>
                                                        <td><?= $Obj_Reset->FormatoDinero($DatosCuota['pago_cuota']) ?></td>
                                                    </tr>
                                            <?php }
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->

                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="mt-5 col-12">
                            <div class="card ">
                                <div class="flex-wrap px-4 py-2 d-flex align-items-center justify-content-between">
                                    <h3 class="card-title">Detalles sobre capital saliente por préstamos realizados (Egresos)</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table_expenses" class="table table-bordered table-striped  table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($DatosPrestamo = $Res_PrestamosDetalles->fetch_assoc()) {
                                            ?>
                                                <tr>
                                                    <td><?= $DatosPrestamo['nombre_cliente'] ?></td>
                                                    <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($DatosPrestamo['fecha_prestamo'])) ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($DatosPrestamo['capital_prestamo']) ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->

                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->

                        <?php if ($Res_TransaccionesDetalles->num_rows > 0) { ?>
                            <div class="mt-5 col-12">
                                <div class="card ">
                                    <div class="flex-wrap px-4 py-2 d-flex align-items-center justify-content-between">
                                        <h3 class="card-title">Detalles sobre transacciones adicionales</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="table_expenses" class="table table-bordered table-striped  table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Descripción</th>
                                                    <th>Fecha</th>
                                                    <th>Valor</th>
                                                    <th>Tipo de transacción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($TransaccionDetalles = $Res_TransaccionesDetalles->fetch_assoc()) {
                                                ?>
                                                    <tr>
                                                        <td><?= $TransaccionDetalles['descripcion'] ?></td>
                                                        <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($TransaccionDetalles['fecha'])) ?></td>
                                                        <td><?= $Obj_Reset->FormatoDinero($TransaccionDetalles['monto']) ?></td>
                                                        <td><?= $TransaccionDetalles['nombre_tipo_movimiento'] ?></td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->

                                </div>
                                <!-- /.card -->
                            </div>
                        <?php  }  ?>

                        <!-- /.col -->
                        <?php if ($Res_TransaccionesInversoresDetalles->num_rows > 0) { ?>
                            <div class="mt-5 col-12">
                                <div class="card ">
                                    <div class="flex-wrap px-4 py-2 d-flex align-items-center justify-content-between">
                                        <h3 class="card-title">Detalles sobre transacciones de inversionistas y empleados</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="table_expenses" class="table table-bordered table-striped  table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Fecha</th>
                                                    <th>Valor</th>
                                                    <th>Tipo de transacción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($TransaccionesInversoresDetalles = $Res_TransaccionesInversoresDetalles->fetch_assoc()) {
                                                ?>
                                                    <tr>
                                                        <td><?= $TransaccionesInversoresDetalles['nombre_inversor'] ?></td>
                                                        <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($TransaccionesInversoresDetalles['fecha'])) ?></td>
                                                        <td><?= $Obj_Reset->FormatoDinero($TransaccionesInversoresDetalles['monto']) ?></td>
                                                        <td><?= $TransaccionesInversoresDetalles['nombre_tipo_movimiento'] ?></td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->

                                </div>
                                <!-- /.card -->
                            </div>
                        <?php  }  ?>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once '../../components/Footer.php' ?>
    </div>

    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- dropzonejs -->
    <script src="../../plugins/dropzone/min/dropzone.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#table_details").DataTable({
                "paging": false,
                "info": false,
                "searching": false,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": false,
            });
            $("#table_incomes").DataTable({
                "paging": true,
                "info": false,
                "searching": false,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": false,
            });
            $("#table_expenses").DataTable({
                "paging": true,
                "info": false,
                "searching": false,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": false,
            });
        });
    </script>
    <script>
        function abrirFormEditar(fechaInicio, fechaFin) {
            console.log(fechaInicio)
            const ventanaAncho = 1000;
            const ventanaAlto = 800;
            const ventanaX = (screen.availWidth - ventanaAncho) / 2;
            const ventanaY = (screen.availHeight - ventanaAlto) / 2;

            window.open(
                '<?= $_SESSION['path'] ?>/caja-chica/detalles/?inicio=' + fechaInicio + '&fin=' + fechaFin,
                'Editar datos del inversor',
                'width=' + ventanaAncho + ',height=' + ventanaAlto + ',left=' + ventanaX + ',top=' + ventanaY
            );
        }

        function logout(path) {
            window.location.href = path + '/func/SessionDestroy.php';
        }
    </script>
    <script>
        <?php
        if (isset($_SESSION['msg'])) {
            include '../../func/Message.php';
            echo showMessage($_SESSION['type'], $_SESSION['msg']);
        }
        ?>
    </script>
    <?php include '../../utils/initDropzoneConfiguration.php' ?>

</body>

</html>