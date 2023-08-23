<?php
require_once '../../func/LoginValidator.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Cliente | Hernan Store</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
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
                        <form action="./insertar.php" method="POST" class="card card-info" id="frmNuevo">
                            <div class="card-header">
                                <h3 class="text-center card-title w-100 font-weight-bold">Agregar nuevo cliente</h3>
                            </div>
                            <div class="card-body ">
                                <!-- Nombre -->
                                <div class="mx-1 form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" placeholder="Nombre ..." name="txtNombre">
                                </div>
                                <!-- Dirección -->
                                <div class="mx-1 form-group">
                                    <label>Dirección</label>
                                    <input type="text" class="form-control" placeholder="Dirección ..." name="txtDireccion">
                                </div>
                                <!-- Teléfono -->
                                <div class="mx-1 form-group">
                                    <label>Teléfono:</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" data-inputmask='"mask": "(999) 9999-9999"' placeholder="(XXX) XXXX-XXXX" data-mask name="txtTelefono" onkeypress="javascript:typeNumber();">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Agregar</button>
                                </div>
                                <div class="form-group">
                                    <button class="text-center btn btn-block" type="reset" onclick="javascript:goBack();">Cancelar</button>
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
        </div>
        <!-- /.content -->
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
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->
    <script src="../../dist/js/demo.js"></script>

    <script>
        $(function() {
            //Phone Number
            $('[data-mask]').inputmask()

            $('#frmNuevo').validate({
                rules: {
                    txtNombre: {
                        required: true
                    },
                    txtDireccion: {
                        required: true
                    },
                    txtTelefono: {
                        required: true
                    },
                },
                messages: {
                    txtNombre: {
                        required: "El nombre es obligatorio",
                    },
                    txtDireccion: {
                        required: "La dirección es obligatoria",
                    },
                    txtTelefono: {
                        required: "El teléfono es obligatorio",
                    }
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
</body>

</html>