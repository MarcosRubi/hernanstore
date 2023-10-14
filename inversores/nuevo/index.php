<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Inversores.php';

$Obj_Inversores = new Inversores();

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
    <title>Nuevo Inversor</title>

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
    <!-- dropzonejs -->
    <link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include_once '../../components/Navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include_once '../../components/Sidebar.php'; ?>
        <!-- Main content -->
        <div class="pt-3 content-wrapper d-flex justify-content-center align-items-center">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <form action="./insertar.php" method="POST" class="card card-info" id="frmNuevoInversor" style="min-width:30vw;">
                            <div class="card-header">
                                <h3 class="text-center card-title w-100 font-weight-bold">Agregar nuevo inversor</h3>
                            </div>
                            <div class="card-body ">
                                <!-- Primer nombre -->
                                <div class="form-group container-fluid">
                                    <label>Nombre del inversor</label>
                                    <input type="text" class="form-control" placeholder="Nombre del inversor ..." name="txtNombreInversor">
                                </div>
                                <!-- Rol -->
                                <div class="form-group container-fluid">
                                    <label>Detalles</label>
                                    <textarea id="summernote" name="txtDetalles">
                                        </textarea>
                                </div>
                            </div>
                            <div class="form-group container-fluid">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">
                                    <i class="fa fa-user-plus pr-2"></i>
                                    <span>Crear nuevo inversor</span>
                                </button>
                            </div>
                            <div class="form-group container-fluid">
                                <button class="text-center btn btn-block" type="reset" onclick="javascript:goBack();">Cancelar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.container-fluid -->
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- Navbar -->
        <?php include_once '../../components/Footer.php'; ?>
        <!-- /.navbar -->
    </div>
    <!-- /.content-wrapper -->

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- Summernote -->
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- dropzonejs -->
    <script src="../../plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- dropzonejs -->
    <script src="../../plugins/dropzone/min/dropzone.min.js"></script>
    <!-- Page specific script -->
    <script src="../../dist/js/demo.js"></script>

    <script>
        $(function() {
            //Phone Number
            $('[data-mask]').inputmask()
            $('#summernote').summernote()

            $('#frmNuevoInversor').validate({
                rules: {
                    txtNombreInversor: {
                        required: true
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
        function goBack() {
            history.back();
        }
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
    </script>
    <?php include '../../utils/initDropzoneConfiguration.php' ?>
</body>



</html>