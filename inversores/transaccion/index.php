<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Inversores.php';

$Obj_Inversores = new Inversores();
$Res_TiposMovimientos = $Obj_Inversores->listarTiposMovimientos();

$Res_Inversor = $Obj_Inversores->buscarPorId($_GET['id']);

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
    <title>Realizar transacción</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="pt-3 wrapper d-flex justify-content-center">
        <!-- Main content -->
        <div class="content" style="min-width:90vw;">
            <div class="container-fluid">
                <div class="row">
                    <form action="./insertar.php" method="POST" class="card card-info" id="frnNewTransaction" style="min-width:90vw;">
                        <div class="card-header">
                            <h3 class="text-center card-title w-100">Nueva transacción para <b> <?= $DatosInversor['nombre_inversor'] ?> </b></h3>
                        </div>
                        <div class="card-body ">
                            <!-- Primer nombre -->
                            <div class="form-group container-fluid">
                                <label>Monto</label>
                                <input type="number" class="form-control" placeholder="Monto ..." name="txtMonto">
                            </div>

                            <!-- Tipo -->
                            <div class="form-group container-fluid">
                                <label>Tipo de transacción</label>
                                <select class="form-control select2" style="width: 100%;" name="txtIdTipoMovimiento">
                                    <?php
                                    while ($TipoMovimiento = $Res_TiposMovimientos->fetch_assoc()) { ?>
                                        <option value="<?= $TipoMovimiento['id_tipo_movimiento'] ?>"><?= $TipoMovimiento['nombre_tipo_movimiento'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group container-fluid">
                                <label>Detalles de la transacción</label>
                                <textarea id="summernote" name="txtDetalles">
                                        </textarea>
                            </div>

                        </div>
                        <input type="hidden" name="id_inversor" value="<?= $DatosInversor['id_inversor'] ?>">
                        <div class="form-group container-fluid">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Agregar transacción</button>
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
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Summernote -->
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->

    <script>
        $(function() {
            $('#summernote').summernote()
            $('#frmEditarEmpleado').validate({
                rules: {
                    txtMonto: {
                        required: true
                    },
                },
                messages: {
                    txtMonto: {
                        required: "El monto es obligatorio",
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
            include '../../func/Message.php';

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