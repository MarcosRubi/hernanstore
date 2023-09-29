<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Inversores.php';
require_once '../class/TransaccionesInversores.php';
require_once '../class/Reset.php';


$Obj_Inversores = new Inversores();
$Obj_TransaccionesInversores = new TransaccionesInversores();
$Obj_Reset = new Reset();

$Res_Inversor = $Obj_Inversores->buscarPorId($_GET['id']);
$DatosInversor = $Res_Inversor->fetch_assoc();

$Res_TransaccionesInversor = $Obj_TransaccionesInversores->listarMovimientosInversor($_GET['id']);


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transacciones del inversor <?= $DatosInversor['nombre_inversor'] ?> | Hernan Store</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="../plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once '../components/Navbar.php' ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once '../components/Sidebar.php' ?>
        <!-- Main content -->
        <div class="content-wrapper pt-3">
            <section class="content">
                <?php if ($Res_Inversor->num_rows <= 0) {
                    echo '<div class="align-middle d-flex justify-content-center" style="height:calc(100vh - 130px)"><div class="d-flex justify-content-center flex-column">';
                    echo '<h1 class=" font-weight-bold">Lo sentimos, este inversor no existe o ha sido eliminado</h1>';
                    echo '<a href="' . $_SESSION['path'] . '/inversores/" class="btn btn-primary btn-lg">Listar inversores</a>';
                    echo '</div></div>';
                } else { ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="mt-3 mb-2 d-flex justify-content-between">
                                            <h3 class="card-title">Transacciones del inversor <b><?= $DatosInversor['nombre_inversor'] ?></b> </h3>
                                            <a href="../inversores/" class="btn btn-primary">Listar todos los inversores</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="table-transactions" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Capital de transacción</th>
                                                    <th>Fecha de transacción</th>
                                                    <th>Tipo de transacción</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($DatosTransaccion = $Res_TransaccionesInversor->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td>
                                                            <p><?= $Obj_Reset->FormatoDinero($DatosTransaccion['monto']) ?></p>
                                                        </td>
                                                        <td>
                                                            <p><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($DatosTransaccion['fecha'])) ?></p>
                                                        </td>
                                                        <td>
                                                            <p><?= $DatosTransaccion['nombre_tipo_movimiento'] ?></p>
                                                        </td>
                                                        <td>
                                                            <?php if (intval($_SESSION['id_rol']) <= 3) {
                                                            ?>
                                                                <a href="#" class=" btn bg-orange mx-2 my-2" title="Editar" onclick="javascript:editarTransaccion(<?php echo $DatosTransaccion['id_movimiento_inversor'] . "," .  $DatosInversor['id_inversor'] ?>);">
                                                                    <i class="fa fa-edit "></i>
                                                                </a>
                                                                <a href="#" class=" btn btn-danger mx-2 my-2" title="Eliminar" onclick="javascript:eliminarTransaccion(<?= $DatosTransaccion['id_movimiento_inversor'] ?>);">
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
                <?php  } ?>
                <!-- /.container-fluid -->
            </section>
        </div>
        <?php require_once '../components/Footer.php' ?>
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <!-- dropzonejs -->
    <script src="../plugins/dropzone/min/dropzone.min.js"></script>
    <!-- Toastr -->
    <script src="../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->
    <script src="../dist/js/demo.js"></script>
    <script>
        $(function() {
            $('#table-transactions').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#table-transactions_wrapper .col-md-6:eq(0)');

        });
    </script>
    <script>
        <?php
        if (isset($_SESSION['msg'])) {
            include '../func/Message.php';

            echo showMessage($_SESSION['type'], $_SESSION['msg']);
        }
        ?>

        function eliminarTransaccion(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar la transacción?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>/inversor/transaccion/eliminar/?id=' + id
            }
        }

        function editarTransaccion(id, id_inversor) {
            const ventanaAncho = 1000;
            const ventanaAlto = 800;
            const ventanaX = (screen.availWidth - ventanaAncho) / 2;
            const ventanaY = (screen.availHeight - ventanaAlto) / 2;

            window.open(
                '<?= $_SESSION['path'] ?>/inversor/transaccion/actualizar/?id=' + id + '&id_inversor=' + id_inversor,
                'Editar datos de transacción',
                'width=' + ventanaAncho + ',height=' + ventanaAlto + ',left=' + ventanaX + ',top=' + ventanaY
            );
        }

        function logout(path) {
            window.location.href = path + '/func/SessionDestroy.php';
        }
    </script>

    <?php include '../utils/initDropzoneConfiguration.php' ?>



</body>

</html>