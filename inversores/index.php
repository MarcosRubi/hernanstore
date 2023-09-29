<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Inversores.php';

$Obj_Inversores = new Inversores();

$Res_Inversores = $Obj_Inversores->listarTodo();

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
    <title>Empleados | Hernan Store</title>

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
                                    <h3 class="card-title">Listado de inversores</h3>
                                    <a href="<?= $_SESSION['path'] ?>/inversores/nuevo/" class=" btn btn-primary d-flex align-items-center">
                                        <i class="pr-1 nav-icon fas fa-user-plus"></i>
                                        Nuevo inversor
                                    </a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table_investors" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Capital invertido</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($DatosInversor = $Res_Inversores->fetch_assoc()) { ?>
                                                <tr data-widget="expandable-table" aria-expanded="false">
                                                    <td><a href="<?= $_SESSION['path'] . '/inversor/?id=' . $DatosInversor['id_inversor'] ?>"><?= $DatosInversor['nombre_inversor'] ?></a></td>
                                                    <td>$4,500.00</td>
                                                    <td style="width:25%">
                                                        <div class="d-flex justify-content-around">
                                                            <?php if ($_SESSION['id_rol'] <= 3) { ?>
                                                                <a class="mx-1 btn btn-md bg-success" title="Transacción" onclick="javascript:realizarTransaccion(<?= $DatosInversor['id_inversor'] ?>);">
                                                                    <i class="fa fa-hand-holding-usd"></i>
                                                                </a>
                                                                <a class="mx-1 btn btn-md bg-lightblue" title="Editar" onclick="javascript:abrirFormEditar(<?= $DatosInversor['id_inversor'] ?>);">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a class="mx-1 btn btn-md bg-danger" title="Eliminar" onclick="javascript:eliminarInversor(<?= $DatosInversor['id_inversor'] ?>);">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                        </div>
                                                    <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr class="expandable-body">
                                                    <td colspan="3">
                                                        <p>
                                                            <?= $DatosInversor['detalles'] ?>
                                                        </p>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
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
        function abrirFormEditar(id) {
            const ventanaAncho = 1000;
            const ventanaAlto = 800;
            const ventanaX = (screen.availWidth - ventanaAncho) / 2;
            const ventanaY = (screen.availHeight - ventanaAlto) / 2;

            window.open(
                '<?= $_SESSION['path'] ?>/inversores/editar/?id=' + id,
                'Editar datos del inversor',
                'width=' + ventanaAncho + ',height=' + ventanaAlto + ',left=' + ventanaX + ',top=' + ventanaY
            );
        }

        function realizarTransaccion(id) {
            const ventanaAncho = 1000;
            const ventanaAlto = 800;
            const ventanaX = (screen.availWidth - ventanaAncho) / 2;
            const ventanaY = (screen.availHeight - ventanaAlto) / 2;

            window.open(
                '<?= $_SESSION['path'] ?>/inversores/transaccion/?id=' + id,
                'Transacción',
                'width=' + ventanaAncho + ',height=' + ventanaAlto + ',left=' + ventanaX + ',top=' + ventanaY
            );
        }

        function eliminarInversor(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar este inversor?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>/inversores/eliminar/?id=' + id
            }
        }

        function logout(path) {
            window.location.href = path + '/func/SessionDestroy.php';
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