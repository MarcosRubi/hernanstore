<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Clientes.php';
require_once '../../class/Prestamos.php';


$Obj_Clientes = new Clientes();
$Obj_Prestamos = new Prestamos();

$Res_Clientes = $Obj_Clientes->buscarPorId($_GET['id']);
$Res_EstadosPrestamos = $Obj_Prestamos->listarEstadosPrestamos();
$Res_PlazosPrestamos = $Obj_Prestamos->listarPlazoPrestamos();

$DatosCliente = $Res_Clientes->fetch_assoc();

if (!isset($_GET['id'])) {
    echo "<script>window.location.replace('" . $_SESSION['path'] . "/clientes/');</script>";
    return;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo préstamo</title>

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
    <!-- summernote -->
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed" onload="changeData()">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once '../../components/Navbar.php' ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once '../../components/Sidebar.php' ?>
        <!-- Main content -->
        <div class="content-wrapper ">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="mt-5 col-12 col-md-8  mx-auto">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title w-100 font-weight-bold text-center">Agregar nuevo préstamo</h3>
                                </div>
                                <form action="./insertar.php" method="post" class="card-body" id="frmNuevoPrestamo">
                                    <div class="px-2 mb-3 rounded">
                                        <div class="d-flex flex-wrap flex-md-nowrap pt-3">
                                            <!-- Cliente -->
                                            <div class="form-group mx-1 container-fluid">
                                                <label>Cliente</label>
                                                <input type="text" class="form-control" value="<?= $DatosCliente['nombre_cliente'] ?>" readonly>
                                            </div>
                                            <!-- Cantidad del préstamo -->
                                            <div class="form-group mx-1 container-fluid">
                                                <label>Cantidad del préstamo</label>
                                                <input type="number" class="form-control update-table" placeholder="0.0" name="txtValor">
                                            </div>
                                        </div>
                                        <div class=" mb-3 p-3  rounded">
                                            <div class="card">
                                                <!-- /.card-header -->
                                                <div class="card-body py-2 px-3">
                                                    <h3 class=" text-center">Información del préstamo</h3>

                                                    <div class="form-group container-fluid">
                                                        <label for="txtFecha" class="">Fecha del préstamo</label>
                                                        <div class="form-group">
                                                            <div class="input-group date" id="dateStart" data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateStart" data-inputmask-alias="datetime" placeholder="dd-mm-yyyy" name="txtFechaInicio" id="date-start" value="<?= date('d-m-Y') ?>">
                                                                <div class=" input-group-append" data-target="#dateStart" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group container-fluid">
                                                        <label for="txtNumCuotas" class=""># de cuotas</label>
                                                        <div class="form-group ">
                                                            <input type="number" class="form-control update-table" placeholder="0" name="txtNumCuotas">
                                                        </div>
                                                    </div>

                                                    <div class="form-group container-fluid">
                                                        <label for="txtIdPlazoPago" class="">Período de pagos</label>
                                                        <div class="form-group">
                                                            <select class="form-control select2" style="width: 100%;" name="txtIdPlazoPago" onchange="javascript:changeData();">
                                                                <?php
                                                                while ($PlazosPrestamos = $Res_PlazosPrestamos->fetch_assoc()) { ?>
                                                                    <option value="<?= $PlazosPrestamos['id_plazo_pago'] ?>"><?= $PlazosPrestamos['plazo_pago'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group container-fluid">
                                                        <label for="txtFecha" class="">Fecha pago de primer cuota</label>
                                                        <div class="form-group">
                                                            <div class="input-group date" id="dateStartPay" data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input" data-target="#dateStartPay" data-inputmask-alias="datetime" placeholder="dd-mm-yyyy" name="txtFechaPrimerPago" id="date-start-pay">
                                                                <div class="input-group-append" data-target="#dateStartPay" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group container-fluid">
                                                        <label for="txtFecha" class="">Estado del préstamo</label>
                                                        <div class="form-group">
                                                            <select class="form-control select2" style="width: 100%;" name="txtIdEstado">
                                                                <?php
                                                                while ($EstadosPrestamos = $Res_EstadosPrestamos->fetch_assoc()) { ?>
                                                                    <option value="<?= $EstadosPrestamos['id_estado'] ?>"><?= $EstadosPrestamos['nombre_estado'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group container-fluid">
                                                        <label for="txtInteres" class="">Interés (Ganancia)</label>
                                                        <div class="form-group ">
                                                            <input type="number" class="form-control update-table" placeholder="0.0" name="txtInteres">
                                                        </div>
                                                    </div>

                                                    <div class="card card-info collapsed-card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Asistencia para el cálculo de interés</h3>

                                                            <div class="card-tools">
                                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                            <!-- /.card-tools -->
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="form-group container-fluid">
                                                                <label for="txtInteres" class="">% de interés</label>
                                                                <div class="form-group ">
                                                                    <input type="number" class="form-control update-table" placeholder="0.0" name="txtPorcentajeInteres">
                                                                </div>
                                                            </div>

                                                            <div class="form-group container-fluid icheck-primary">
                                                                <input type="checkbox" id="chkRecalcular" name="chkRecalcular" onchange="javascript:changeData();">
                                                                <label for="chkRecalcular" style="cursor: pointer;">
                                                                    Recalcular interés cada mes
                                                                </label>
                                                            </div>
                                                            <div id="tableInterestAssistant"></div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>

                                                    <div class="form-group container-fluid">
                                                        <label for="summernote" class="">Detalles sobre el préstamo</label>
                                                        <textarea id="summernote" name="txtDetalles">
                                                        </textarea>
                                                    </div>

                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>

                                        <input type="text" class="form-control d-none" value="<?= $DatosCliente['id_cliente'] ?>" name="txtIdCliente" readonly>
                                        <!-- /.form group -->
                                        <div class="d-flex flex-wrap justify-content-center align-items-center">
                                            <div class="form-group pr-1 flex-grow-1 ">
                                                <button class="btn btn-lg btn-secondary text-center btn-block" type="reset" onclick="javascript:history.back();">Cancelar</button>
                                            </div>
                                            <div class="form-group pl-1 flex-grow-1">
                                                <button class="btn btn-primary btn-lg btn-block" type="submit">Agregar préstamo</button>
                                            </div>
                                        </div>
                                        <!-- /.form group -->
                                    </div>

                                    <!-- /.card-body -->
                            </div>

                            </form>


                            <!-- /.card -->
                            <div class="mb-3 rounded">
                                <div id="table-results"></div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <?php require_once '../../components/Footer.php' ?>
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

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
    <!-- Page specific script -->
    <script>
        $(function() {
            // Summernote
            $('.select2').select2()
            $('#summernote').summernote()

            $('#dateStartPay').datetimepicker({
                format: 'DD-MM-YYYY'
            });
            $('#dateStart').datetimepicker({
                format: 'DD-MM-YYYY'
            });
            $('#date-start-pay').on('input', function() {
                changeData();
            });
        })
    </script>
    <?php include '../../utils/frmNewLendingValidate.php' ?>
    <script>
        <?php
        if (isset($_SESSION['msg'])) {
            include '../../func/Message.php';

            echo showMessage($_SESSION['type'], $_SESSION['msg']);
        }
        ?>
    </script>

    <script>
        function changeData() {
            const formData = obtenerDatosFormulario(); // Obtener los datos del formulario del modal
            getTable(formData);
        }

        function obtenerDatosFormulario() {
            const formData = new FormData(document.getElementById('frmNuevoPrestamo'));
            const datosFormulario = Object.fromEntries(formData.entries());
            return datosFormulario;
        }

        function getTable(formData) {
            $.ajax({
                url: '../../utils/tableLending.php',
                method: 'POST',
                data: {
                    formData
                },
                success: function(response) {
                    $('#table-results').html(response);
                }
            });

            $.ajax({
                url: '../../utils/tableInterestAssistan.php',
                method: 'POST',
                data: {
                    formData
                },
                success: function(response) {
                    $('#tableInterestAssistant').html(response);
                }
            });
        }

        function logout(path) {
            window.location.href = path + '/func/SessionDestroy.php';
        }


        const camposCambio = document.querySelectorAll('.update-table');
        camposCambio.forEach(function(campo) {
            campo.addEventListener('input', changeData);
        });
    </script>
    <?php include '../../utils/initDropzoneConfiguration.php' ?>
</body>

</html>