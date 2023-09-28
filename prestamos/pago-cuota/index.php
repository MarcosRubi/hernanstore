<?php
require_once '../../func/LoginValidator.php';

require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';
require_once '../../class/Cuotas.php';
require_once '../../class/Reset.php';

// Crear objetos
$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();
$Obj_Reset = new Reset();

// Obtener datos del préstamo
$id_prestamo = $_GET['id'];
$Res_DatosPrestamos = $Obj_Prestamos->ListarDatosParaDocumento($id_prestamo);
$DatosPrestamo = $Res_DatosPrestamos->fetch_assoc();

$Res_CapitalPagado = $Obj_Cuotas->CapitalPagado($id_prestamo);

$capitalPagado = $Res_CapitalPagado->fetch_assoc()['total'];
$CapitalRestante = $DatosPrestamo['capital_prestamo'] + $DatosPrestamo['ganancias'] - $capitalPagado;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factura <?= $DatosPrestamo['nombre_cliente'] ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">
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
        <div class="content-wrapper pt-3">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Main content -->
                            <div class="p-3 mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="text-center py-2">DETALLES DEL PRÉSTAMO</h5>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>Fecha Solicitud</th>
                                                    <th>Monto a pagar</th>
                                                    <th>Monto restante</th>
                                                    <th>Cuotas</th>
                                                    <th>Período Pagos</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr data-widget="expandable-table" aria-expanded="false">
                                                    <td><a href="<?= $_SESSION['path'] ?>/prestamos/listar/cliente/?id=<?= $DatosPrestamo['id_cliente'] ?>"><?= $DatosPrestamo['nombre_cliente'] ?></a></td>
                                                    <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($DatosPrestamo['fecha_prestamo'])) ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($DatosPrestamo['capital_prestamo'] + $DatosPrestamo['ganancias']) ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($CapitalRestante) ?></td>
                                                    <td><?= $DatosPrestamo['num_cuotas'] ?></td>
                                                    <td><?= $DatosPrestamo['plazo_pago'] ?></td>
                                                    <td><?= $DatosPrestamo['nombre_estado'] ?></td>
                                                </tr>
                                                <tr class="expandable-body">
                                                    <td colspan="7">
                                                        <form action="./actualizar-detalles.php" method="post" id="formulario-actualizacion">
                                                            <p>
                                                            <div class="form-group px-3 pt-3">
                                                                <textarea id="summernote" name="txtInformacion">
                                                                    <?= $DatosPrestamo['detalles'] ?>
                                                                    </textarea>
                                                            </div>
                                                            <input type="hidden" name="id_prestamo" value="<?= $DatosPrestamo['id_prestamo'] ?>">
                                                            <div class="d-flex justify-content-center">
                                                                <button class="btn btn-primary btn-lg font-weight-bold" id="btn-actualizar">Actualizar detalles del préstamo</button>
                                                            </div>
                                                            </p>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="row mt-5">
                                            <!-- /.col -->
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <div id="table-results"></div>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->


                            </div>
                            <!-- /.invoice -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.control-sidebar -->
        <?php require_once '../../components/Footer.php' ?>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- dropzonejs -->
    <script src="../../plugins/dropzone/min/dropzone.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <!-- Summernote -->
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->
    <script src="../../dist/js/demo.js"></script>
    <script>
        $('#summernote').summernote()

        function getTable() {
            $.ajax({
                url: '../../utils/tableLendingForm.php?id=' + <?= $id_prestamo ?>,
                method: 'POST',
                success: function(response) {
                    $('#table-results').html(response);
                }
            });
        }

        window.addEventListener("load", () => {
            getTable()
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#btn-actualizar").click(function(e) {
                e.preventDefault(); // Evita que se envíe el formulario de manera tradicional

                // Obtén los datos del formulario
                var formData = $("#formulario-actualizacion").serialize();

                // Realiza una solicitud AJAX para actualizar los detalles del préstamo
                $.ajax({
                    type: "POST",
                    url: "./actualizar-detalles.php",
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
        function logout(path) {
            window.location.href = path + '/func/SessionDestroy.php';
        }
    </script>

    <?php include '../../utils/initDropzoneConfiguration.php' ?>
</body>

</html>