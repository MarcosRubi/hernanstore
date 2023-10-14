<?php
require_once '../../../func/LoginValidator.php';
require_once '../../../bd/bd.php';
require_once '../../../class/Inversores.php';
require_once '../../../class/TransaccionesInversores.php';
require_once '../../../class/Reset.php';

$Obj_Inversores = new Inversores();
$Obj_TransaccionesInversores = new TransaccionesInversores();
$Obj_Reset = new Reset();

$Res_TiposMovimientos = $Obj_Inversores->listarTiposMovimientos();
$Res_MovimientoInversor = $Obj_TransaccionesInversores->buscarMovimientoPorId($_GET['id']);

$DatosMovimientoInversor = $Res_MovimientoInversor->fetch_assoc();
$Res_Inversor = $Obj_Inversores->buscarPorId($_GET['id_inversor']);
$DatosInversor = $Res_Inversor->fetch_assoc();

if ($_SESSION['id_rol'] > 3) {
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
    <title>Editar transacción</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../../plugins/toastr/toastr.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../../plugins/summernote/summernote-bs4.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="pt-3 wrapper d-flex justify-content-center">
        <!-- Main content -->
        <div class="content" style="min-width:90vw;">
            <div class="container-fluid">
                <div class="row">
                    <form action="./actualizar.php" method="POST" class="card card-info" id="frnTransaction" style="min-width:90vw;">
                        <div class="card-header">
                            <h3 class="text-center card-title w-100">Editar transacción de <b> <?= $DatosInversor['nombre_inversor'] ?> </b></h3>
                        </div>
                        <div class="card-body ">
                            <!-- Primer nombre -->
                            <div class="form-group container-fluid">
                                <label>Monto</label>
                                <input type="number" class="form-control" placeholder="Monto ..." name="txtMonto" value="<?= $DatosMovimientoInversor['monto'] ?>">
                            </div>

                            <!-- Tipo -->
                            <div class="form-group container-fluid">
                                <label>Tipo de transacción</label>
                                <select class="form-control select2" style="width: 100%;" name="txtIdTipoMovimiento">
                                    <option value="<?= $DatosMovimientoInversor['id_tipo_movimiento'] ?>"><?= $DatosMovimientoInversor['nombre_tipo_movimiento'] ?></option>
                                    <?php
                                    while ($TipoMovimiento = $Res_TiposMovimientos->fetch_assoc()) {
                                        if ($TipoMovimiento['id_tipo_movimiento'] !== $DatosMovimientoInversor['id_tipo_movimiento']) {
                                    ?>
                                            <option value="<?= $TipoMovimiento['id_tipo_movimiento'] ?>"><?= $TipoMovimiento['nombre_tipo_movimiento'] ?></option>
                                    <?php
                                        }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group container-fluid">
                                <label for="txtFecha" class="">Fecha de transacción</label>
                                <div class="form-group">
                                    <div class="input-group date" id="dateStart" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#dateStart" data-inputmask-alias="datetime" placeholder="dd-mm-yyyy" name="txtFechaInicio" id="date-start" value="<?= $Obj_Reset->FechaInvertir($DatosMovimientoInversor['fecha']) ?>">
                                        <div class=" input-group-append" data-target="#dateStart" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group container-fluid">
                                <label>Detalles de la transacción</label>
                                <textarea id="summernote" name="txtDetalles">
                                <?= $DatosMovimientoInversor['detalles'] ?>
                                        </textarea>
                            </div>

                        </div>
                        <input type="hidden" name="id_movimiento_inversor" value="<?= $DatosMovimientoInversor['id_movimiento_inversor'] ?>">
                        <input type="hidden" name="id_inversor" value="<?= $_GET['id_inversor'] ?>">
                        <div class="form-group container-fluid">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">
                                <i class="fa fa-edit pr-2"></i>
                                <span>Actualizar transacción</span>
                            </button>
                        </div>
                        <div class="form-group container-fluid">
                            <button class="text-center btn btn-block" type="reset" onclick="javascript:closeForm();">Cancelar</button>
                        </div>
                </div>
                <!-- /.form group -->
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- InputMask -->
    <script src="../../../plugins/moment/moment.min.js"></script>
    <script src="../../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Summernote -->
    <script src="../../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Toastr -->
    <script src="../../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->

    <script>
        $(function() {
            $('#summernote').summernote()
            $('#dateStart').datetimepicker({
                format: 'DD-MM-YYYY'
            });
            $('#frnTransaction').validate({
                rules: {
                    txtMonto: {
                        required: true
                    },
                    txtFechaInicio: {
                        required: true
                    },
                },
                messages: {
                    txtMonto: {
                        required: "El monto es obligatorio",
                    },
                    txtFechaInicio: {
                        required: "La fecha es obligatoria",
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
        })
    </script>
    <script>
        <?php
        if (isset($_SESSION['msg'])) {
            include '../../../func/Message.php';

            echo showMessage($_SESSION['type'], $_SESSION['msg']);
        }
        ?>

        function logout(path) {
            window.location.href = path + '/func/SessionDestroy.php';
        }

        function closeForm() {
            window.close()
        }
    </script>
</body>

</html>