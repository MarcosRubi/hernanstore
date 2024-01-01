<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Excedente.php';
require_once '../class/Reset.php';


if (intval($_SESSION['id_rol']) > 3) {
    $_SESSION['msg'] = 'Acción no autorizada.';
    $_SESSION['type'] = 'error';
    header("Location:" . $_SESSION['path']);
    return;
}

$Obj_Excedente = new Excedente();
$Obj_Reset = new Reset();

$Res_Excedente = $Obj_Excedente->ListarTodo();
$Res_Balance = $Obj_Excedente->ObtenerBalance();

$balance = $Res_Balance->fetch_assoc()['balance'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excedente en efectivo | Hernan Store</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Toastr -->
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
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
                                    <h3 class="card-title">Registro de acciones</h3>
                                    <div class="d-flex align-items-center">
                                        <a onclick="javascript:realizarMovimiento()" class=" btn btn-primary d-flex align-items-center">
                                            <i class="pr-2 nav-icon fas fa-plus-square"></i>
                                            Nuevo excedente
                                        </a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="h3">Balance: <span><?= $Obj_Reset->FormatoDinero($balance) ?></span></p>
                                    </div>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Descripción</th>
                                                <th>Monto</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($DatosExcedente = $Res_Excedente->fetch_assoc()) {
                                            ?>
                                                <tr data-widget="expandable-table" aria-expanded="false">
                                                    <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($DatosExcedente['fecha'])) ?></td>
                                                    <td><?= $DatosExcedente['descripcion'] ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($DatosExcedente['monto']) ?></td>
                                                    <td>
                                                        <a href="#" class=" btn btn-danger mx-2 my-2" title="Eliminar" onclick="javascript:eliminarExcedente(<?= $DatosExcedente['id_excedente'] ?>);">
                                                            <i class="fa fa-trash"></i>
                                                            <span>Eliminar</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr class="expandable-body">
                                                    <td colspan="7">
                                                        <form action="./actualizar.php" method="post" id="formulario-actualizacion-<?= $DatosExcedente['id_excedente'] ?>">
                                                            <p class="font-weight-bold mx-3 mt-3 mb-1">Agregar notas</p>
                                                            <div class="form-group px-3">
                                                                <textarea class="summernote" name="txtNotas">
                                                                    <?= $DatosExcedente['notas'] ?>
                                                                    </textarea>
                                                            </div>
                                                            <div class="form-group px-3 pt-3">
                                                                <label>Monto</label>
                                                                <input type="number" class="form-control" value="<?= $DatosExcedente['monto'] ?>" name="txtMonto">
                                                            </div>
                                                            <input type="hidden" name="id_excedente" value="<?= $DatosExcedente['id_excedente'] ?>">
                                                            <div class="d-flex justify-content-center">
                                                                <button class="btn btn-primary btn-lg font-weight-bold btn-actualizar" data-id="<?= $DatosExcedente['id_excedente'] ?>">
                                                                    <i class="fas fa-pen-square pr-2"></i>
                                                                    <span>Actualizar</span></button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
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
    <!-- Summernote -->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
    <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Toastr -->
    <script src="../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $('.summernote').summernote()

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
                '<?= $_SESSION['path'] ?>/excedente/nuevo-excedente/',
                'Transacción',
                'width=' + ventanaAncho + ',height=' + ventanaAlto + ',left=' + ventanaX + ',top=' + ventanaY
            );
        }

        function eliminarExcedente(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar el excedente?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>/excedente/eliminar/?id=' + id
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".btn-actualizar").click(function(e) {
                e.preventDefault(); // Evita que se envíe el formulario de manera tradicional

                // Obtén el ID del botón clicado
                var id = $(this).data('id');

                // Obtén los datos del formulario
                var formData = $("#formulario-actualizacion-" + id).serialize();

                // Realiza una solicitud AJAX para actualizar los detalles del préstamo
                $.ajax({
                    type: "POST",
                    url: "./actualizar.php",
                    data: formData,
                    success: function(response) {
                        // Verifica si la respuesta indica éxito
                        if (response.success) {
                            // Muestra el mensaje de éxito
                            toastr.success(response.message);
                        } else {
                            // Muestra el mensaje de error
                            toastr.error(response.message);
                        }
                    },
                });
            });
        });
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