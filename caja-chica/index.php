<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Cuotas.php';
require_once '../class/Prestamos.php';
require_once '../class/TransaccionesAdicionales.php';
require_once '../class/TransaccionesInversores.php';
require_once '../class/Reset.php';


if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    header("Location:" . $_SESSION['path']);
    return;
}

$Obj_Cuotas = new Cuotas();
$Obj_Prestamos = new Prestamos();
$Obj_TransaccionesAdicionales = new TransaccionesAdicionales();
$Obj_TransaccionesInversores = new TransaccionesInversores();
$Obj_Reset = new Reset();

$Res_Cuotas = $Obj_Cuotas->ObtenerIngresosAnualesPorSemanas('2023-01-01', date("Y-m-d"));
$Res_Prestamos = $Obj_Prestamos->ObtenerEgresosAnualesPorSemanas('2023-01-01', date("Y-m-d"));
$Res_TransaccionesAdicionales = $Obj_TransaccionesAdicionales->ObtenerEgresosAnualesPorSemanas('2023-01-01', date("Y-m-d"));
$Res_TransaccionesInversores = $Obj_TransaccionesInversores->ObtenerEgresosAnualesPorSemanas('2023-01-01', date("Y-m-d"));

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

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Caja Chica | Hernan Store</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once '../components/Navbar.php' ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once '../components/Sidebar.php' ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="mt-5 col-12">
                            <div class="card ">
                                <div class="flex-wrap px-4 py-2 d-flex align-items-center justify-content-between">
                                    <h3 class="card-title">Listado de acciones</h3>
                                    <div class="d-flex align-items-center">
                                        <a onclick="javascript:listarTransacciones()" class=" btn btn-info d-flex align-items-center mr-2">
                                            <i class="pr-1 nav-icon fas fa-list"></i>
                                            Listar transacciones
                                        </a>
                                        <a onclick="javascript:realizarMovimiento()" class=" btn btn-primary d-flex align-items-center">
                                            <i class="pr-1 nav-icon fas fa-plus-square"></i>
                                            Nueva transacción
                                        </a>
                                    </div>
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
                                                <th>Total</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($resultados_combinados as $semana => $datos) {
                                                $total = $datos['suma_cuotas'] - $datos['suma_prestamos'];
                                            ?>
                                                <tr>
                                                    <td><?= $semana ?></td>
                                                    <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($datos['fecha_inicial_semana'])) ?></td>
                                                    <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($datos['fecha_final_semana'])) ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($datos['suma_cuotas']) ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($datos['suma_prestamos']) ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($total) ?></td>
                                                    <td>
                                                        <div class="d-flex justify-content-around">
                                                            <a href="<?= $_SESSION['path'] ?>/caja-chica/detalles/?inicio=<?= $datos['fecha_inicial_semana'] ?>&fin=<?= $datos['fecha_final_semana']  ?>" target="_blank"" class=" mx-1 btn btn-md bg-olive d-flex align-items-center" title="Ver detalles">
                                                                <i class="fa fa-eye pr-2"></i>
                                                                <span>Ver detalles</span>
                                                            </a>
                                                        </div>
                                                    </td>
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
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php require_once '../components/Footer.php' ?>
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- dropzonejs -->
    <script src="../plugins/dropzone/min/dropzone.min.js"></script>
    <!-- jquery-validation -->
    <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Toastr -->
    <script src="../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#table_details").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "ordering": false,
            });
        });
    </script>
    <script>
        function logout(path) {
            window.location.href = path + '/func/SessionDestroy.php';
        }

        function realizarMovimiento() {
            const ventanaAncho = 1000;
            const ventanaAlto = 800;
            const ventanaX = (screen.availWidth - ventanaAncho) / 2;
            const ventanaY = (screen.availHeight - ventanaAlto) / 2;

            window.open(
                '<?= $_SESSION['path'] ?>/caja-chica/nueva-transaccion/',
                'Transacción',
                'width=' + ventanaAncho + ',height=' + ventanaAlto + ',left=' + ventanaX + ',top=' + ventanaY
            );
        }

        function listarTransacciones() {
            const ventanaAncho = 1000;
            const ventanaAlto = 800;
            const ventanaX = (screen.availWidth - ventanaAncho) / 2;
            const ventanaY = (screen.availHeight - ventanaAlto) / 2;

            window.open(
                '<?= $_SESSION['path'] ?>/caja-chica/transacciones/',
                'Transacciones',
                'width=' + ventanaAncho + ',height=' + ventanaAlto + ',left=' + ventanaX + ',top=' + ventanaY
            );
        }
    </script>
    <script>
        <?php
        if (isset($_SESSION['msg'])) {
            include '../func/Message.php';
            echo showMessage($_SESSION['type'], $_SESSION['msg']);
        }
        ?>
    </script>
    <?php include '../utils/initDropzoneConfiguration.php' ?>

</body>

</html>