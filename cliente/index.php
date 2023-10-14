<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Clientes.php';

$Obj_Clientes = new Clientes();

if (!isset($_GET['id'])) {
    header("Location:" . $_SESSION['path']);
}

$Res_Clientes = $Obj_Clientes->buscarPorId($_GET['id']);
$DatosCliente = $Res_Clientes->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio | Legacy Multiservice LLC</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <style>
        #logs_wrapper .row:last-child {
            display: none !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include_once '../components/Navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include_once '../components/Sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="pt-3 content-wrapper">
            <!-- Main content -->
            <div class="content">
                <?php if ($Res_Clientes->num_rows <= 0) {
                    echo '<div class="align-middle d-flex justify-content-center" style="height:calc(100vh - 130px)"><div class="d-flex justify-content-center flex-column">';
                    echo '<h1 class=" font-weight-bold">Lo sentimos, este cliente no existe o ha sido eliminado</h1>';
                    echo '<a href="' . $_SESSION['path'] . '/clientes/" class="btn btn-primary btn-lg">Listar clientes</a>';
                    echo '</div></div>';
                } else { ?>
                    <div class="container-fluid">
                        <h3 class='display-5'>Datos de: <strong><?= $DatosCliente['nombre_cliente'] ?></strong></h3>
                        <div class="mt-3 row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="mt-3 mb-2 d-flex justify-content-between">
                                            <h5 class='display-5'>Información personal</h5>
                                            <a href="../clientes/" class="btn btn-primary d-flex align-items-center">
                                                <i class="pr-2 nav-icon fas fa-list"></i>
                                                <span>Listar todos los clientes</span>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <form action="./actualizar/" method="POST" id="frmEditClient">
                                            <table id="logs" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Número De Teléfono</th>
                                                        <th>Residencia</th>
                                                        <th>Correo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="Nombre ..." name="txtNombre" value="<?= $DatosCliente['nombre_cliente'] ?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" data-inputmask='"mask": "(999) 9999-9999"' placeholder="(XXX) XXXX-XXXX" data-mask name="txtTelefono" onkeypress="javascript:typeNumber();" value="<?= $DatosCliente['telefono'] ?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="Dirección ..." name="txtDireccion" value="<?= $DatosCliente['direccion'] ?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control" placeholder="Correo ..." name="txtCorreo" value="<?= $DatosCliente['correo'] ?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php if (intval($_SESSION['id_rol']) <= 3) { ?>
                                                                <a href="#" class=" btn btn-danger d-inline-flex align-items-center" title="Eliminar" onclick="javascript:eliminarCliente(<?= $DatosCliente['id_cliente'] ?>);">
                                                                    <i class="fa fa-trash pr-2"></i>
                                                                    <span>Eliminar</span>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>


                            <!-- /.col -->
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="display-5">Información adicional</h5>
                            </div>
                            <div class="card-body">
                                <div class="col">
                                    <div class="form-group">
                                        <textarea id="summernote" name="txtInformacion">
                                    <?= $DatosCliente['descripcion'] ?>
                                        </textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?= $DatosCliente['id_cliente'] ?>">
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary btn-lg font-weight-bold" id="btn-actualizar">Actualizar información</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                <?php  } ?>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php include_once '../components/Footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <!-- InputMask -->
    <script src="../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- jquery-validation -->
    <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Toastr -->
    <script src="../plugins/toastr/toastr.min.js"></script>
    <!-- Summernote -->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- dropzonejs -->
    <script src="../plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            //Phone Number
            $('[data-mask]').inputmask()
            // Summernote
            $('#summernote').summernote()

            <?php include '../utils/frmEditEmployeeValidate.php' ?>
            <?php include '../utils/frmEditClientValidate.php' ?>

            $('#logs').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            $('#list-results').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>
        function eliminarCliente(id) {
            let confirmacion = confirm("¿Está seguro que desea eliminar este cliente?");

            if (confirmacion) {
                window.location.href = '<?= $_SESSION['path'] ?>/cliente/eliminar/?id=' + id
            }
        }

        function logout(path) {
            window.location.href = path + '/func/SessionDestroy.php';
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#btn-actualizar").click(function(e) {
                e.preventDefault(); // Evita que se envíe el formulario de manera tradicional

                // Obtén los datos del formulario
                var formData = $("#frmEditClient").serialize();

                // Realiza una solicitud AJAX para actualizar los detalles del préstamo
                $.ajax({
                    type: "POST",
                    url: "./actualizar/index.php",
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
    <?php include '../utils/initDropzoneConfiguration.php' ?>

</body>

</html>