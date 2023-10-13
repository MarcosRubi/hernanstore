<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/TransaccionesAdicionales.php';
require_once '../../class/Reset.php';

$Obj_TransaccionesAdicionales = new TransaccionesAdicionales();
$Obj_Reset = new Reset();

$Res_TransaccionesAdicionales = $Obj_TransaccionesAdicionales->listarTodo();

if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    header("Location:" . $_SESSION['path']);
    return;
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transacciones | Hernan Store</title>

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
    <!-- Content Wrapper. Contains page content -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="mt-5 col-12">
                    <div class="card ">
                        <div class="flex-wrap px-4 py-2 d-flex align-items-center justify-content-between">
                            <h3 class="card-title">Listado de transacciones</h3>
                            <a href="#" onclick="window.close();" class=" btn btn-primary d-flex align-items-center">
                                <i class="pr-1 nav-icon fas fa-times-circle"></i>
                                <span>Cerrar</span>
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table_investors" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                        <th>Tipo transacción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($Transaccion = $Res_TransaccionesAdicionales->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $Transaccion['descripcion'] ?></td>
                                            <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($Transaccion['fecha'])) ?></td>
                                            <td><?= $Obj_Reset->FormatoDinero($Transaccion['monto']) ?></td>
                                            <td><?= $Transaccion['nombre_tipo_movimiento'] ?></td>
                                            <td style="width:25%">
                                                <div class="d-flex justify-content-around">
                                                    <?php if ($_SESSION['id_rol'] <= 3) { ?>
                                                        <a class="mx-1 btn btn-md bg-danger d-flex align-items-center" title="Eliminar" onclick="javascript:eliminar(<?= $Transaccion['id_transaccion_adicional'] ?>);">
                                                            <i class="fa fa-trash mr-1"></i>
                                                            <span>Eliminar</span>
                                                        </a>
                                                </div>
                                            <?php } ?>
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
    <!-- /.content -->
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
        function eliminar(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar este inversor?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>/caja-chica/transacciones/eliminar/?id=' + id
            }
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