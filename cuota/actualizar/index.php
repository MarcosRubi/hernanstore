<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Cuotas.php';
require_once '../../class/Prestamos.php';
require_once '../../class/Reset.php';


$Obj_Prestamos = new Prestamos();
$Obj_Cuotas = new Cuotas();
$Obj_Reset = new Reset();


$Res_DatosCuotas = $Obj_Cuotas->buscarPorIdCuota($_GET['id']);
$Res_EstadosCuotas = $Obj_Prestamos->listarEstadosCuotas();

$DatosCuota = $Res_DatosCuotas->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de préstamos | Hernan Store</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="pt-3">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title w-100 font-weight-bold text-center">Actualizar cuota #<?= $DatosCuota['num_cuota'] ?></h3>
                            </div>
                            <div class="card-body">
                                <form action="./actualizar.php" method="post" class="card-body" id="frmEditCuota">
                                    <table id="table-payments" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha de pago</th>
                                                <th>Valor cuota</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group container-fluid">
                                                        <div class="input-group date" id="dateStart" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input" data-target="#dateStart" data-inputmask-alias="datetime" placeholder="dd-mm-yyyy" name="txtFechaPago" id="date-start" value="<?= $Obj_Reset->FechaInvertir($DatosCuota['fecha_pago']) ?>">
                                                            <div class="input-group-append" data-target="#dateStart" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-form">
                                                        <input type="text" class="form-control" name="txtPagoCuota" value="<?= $DatosCuota['pago_cuota']  ?>" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group container-fluid">
                                                        <select class="form-control select2" style="width: 100%;" name="txtIdEstadoCuota">
                                                            <option value="<?= $DatosCuota['id_estado_cuota'] ?>"><?= $DatosCuota['estado_cuota'] ?></option>
                                                            <?php while ($EstadosCuotas = $Res_EstadosCuotas->fetch_assoc()) {
                                                                if ($EstadosCuotas['id_estado_cuota'] !== $DatosCuota['id_estado_cuota']) { ?>
                                                                    <option value="<?= $EstadosCuotas['id_estado_cuota'] ?>"><?= $EstadosCuotas['estado_cuota'] ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- /.form group -->
                                    <input type="hidden" value="<?= $_GET['id'] ?>" name="txtIdCuota" class="form-control">
                                    <div class="d-flex flex-wrap justify-content-center align-items-center">
                                        <div class="form-group pr-1 flex-grow-1 ">
                                            <button onclick="javascript:window.close();" class="btn btn-lg btn-secondary text-center btn-block d-flex align-items-center justify-content-center" type="reset">
                                                <i class="fa fa-times pr-2"></i>
                                                <span>Cancelar</span></button>
                                        </div>
                                        <div class="form-group pl-1 flex-grow-1">
                                            <button class="btn btn-primary btn-lg btn-block d-flex align-items-center justify-content-center" type="submit">
                                                <i class="fas fa-plus-square pr-2"></i>
                                                <span>Actualizar cuota</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

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
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
    $(function() {
        // Summernote
        $('.select2').select2()

        $('#dateStart').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('#frmEditCuota').validate({
            rules: {
                txtPagoCuota: {
                    required: true
                },
                txtFechaPago: {
                    required: true
                },
            },
            messages: {
                txtPagoCuota: {
                    required: "El valor de la cuota es obligatorio",
                },
                txtFechaPago: {
                    required: "La fecha del pago es obligatorio",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        document.querySelectorAll('.card-body')[1].childNodes[0].remove()

    })
    $('#table-payments').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": true,
        "responsive": true,
    });
</script>
<script>
    function logout(path) {
        window.location.href = path + '/func/SessionDestroy.php';
    }
    <?php
    if (isset($_SESSION['msg'])) {
        include '../../func/Message.php';

        echo showMessage($_SESSION['type'], $_SESSION['msg']);
    }
    ?>
</script>