<?php
require_once '../../../func/LoginValidator.php';
require_once '../../../bd/bd.php';
require_once '../../../class/Prestamos.php';
require_once '../../../class/Reset.php';


$Obj_Prestamos = new Prestamos();
$Obj_Reset = new Reset();

$Res_Prestamos = $Obj_Prestamos->listarPrestamosPorEstado('2');

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de préstamos pendientes de aprobación | Hernan Store</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../../plugins/toastr/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="../../../plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once '../../../components/Navbar.php' ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once '../../../components/Sidebar.php' ?>
        <!-- Main content -->
        <div class="content-wrapper pt-3">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Préstamos pendientes de aprobación</h3>
                                </div>
                                <div class="card-body">
                                    <table id="table-payments" class="table table-bordered table-striped  table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Capital prestado</th>
                                                <th>Ganancias previstas</th>
                                                <th># de cuotas</th>
                                                <th>Primer pago</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($DatosPrestamos = $Res_Prestamos->fetch_assoc()) { ?>
                                                <tr>
                                                    <td>
                                                        <p><a href="<?= $_SESSION['path'] . '/prestamos/listar/cliente/?id=' . $DatosPrestamos['id_cliente'] ?>"><?= $DatosPrestamos['nombre_cliente'] ?></a></p>
                                                    </td>
                                                    <td>
                                                        <p><?= $Obj_Reset->FormatoDinero($DatosPrestamos['capital_prestamo']) ?></p>
                                                    </td>
                                                    <td>
                                                        <p><?= $Obj_Reset->FormatoDinero($DatosPrestamos['ganancias']) ?></p>
                                                    </td>
                                                    <td>
                                                        <p><?= $DatosPrestamos['num_cuotas'] ?></p>
                                                    </td>
                                                    <td>
                                                        <p><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($DatosPrestamos['fecha_primer_pago'])) ?></p>
                                                    </td>
                                                    <td>
                                                        <a href="#" class=" btn btn-info mx-2 my-2" title="Imprimir" onclick="javascript:imprimirPrestamo(<?= $DatosPrestamos['id_prestamo'] ?>);">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                        <?php if (intval($_SESSION['id_rol']) <= 3) {
                                                        ?>
                                                            <a href="#" class=" btn bg-orange mx-2 my-2" title="Editar" onclick="javascript:editarPrestamo(<?= $DatosPrestamos['id_prestamo'] ?>);">
                                                                <i class="fa fa-edit "></i>
                                                            </a>
                                                            <a href="#" class=" btn btn-danger mx-2 my-2" title="Eliminar" onclick="javascript:eliminarPrestamo(<?php echo $DatosPrestamos['id_prestamo'] . "," .  $DatosPrestamos['id_cliente'] ?>);">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        <?php }
                                                        ?>
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
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
        </div>
        <?php require_once '../../../components/Footer.php' ?>
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../../plugins/jszip/jszip.min.js"></script>
    <script src="../../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <!-- dropzonejs -->
    <script src="../../../plugins/dropzone/min/dropzone.min.js"></script>
    <!-- Toastr -->
    <script src="../../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->
    <script src="../../../dist/js/demo.js"></script>
    <script>
        $(function() {
            $('#table-payments').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#table-payments_wrapper .col-md-6:eq(0)');

        });
    </script>
    <script>
        <?php
        if (isset($_SESSION['msg'])) {
            include '../../../func/Message.php';

            echo showMessage($_SESSION['type'], $_SESSION['msg']);
        }
        ?>

        function eliminarPrestamo(id, id_cliente) {
            let confirmacion = confirm("¿Está seguro que desea eliminar un préstamo?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>/prestamos/eliminar/?id=' + id + '&id_cliente=' + id_cliente
            }
        }

        function editarPrestamo(id) {
            window.location.href = '<?= $_SESSION['path'] ?>/prestamos/actualizar/?id=' + id
        }

        function imprimirPrestamo(id) {
            var nuevaVentana = window.open('<?= $_SESSION['path'] ?>/prestamos/imprimir/?id=' + id, '_blank');
            nuevaVentana.focus();
        }

        function nuevoPrestamo(id) {
            window.location.href = '<?= $_SESSION['path'] ?>/prestamos/nuevo/?id=' + id
        }

        function pagoCuota(id) {
            window.location.href = '<?= $_SESSION['path'] ?>/prestamos/pago-cuota/?id=' + id
        }

        function logout(path) {
            window.location.href = path + '/func/SessionDestroy.php';
        }
    </script>

    <?php include '../../../utils/initDropzoneConfiguration.php' ?>



</body>

</html>