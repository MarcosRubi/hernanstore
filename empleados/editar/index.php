<?php
require_once '../../func/LoginValidator.php';
require_once '../../bd/bd.php';
require_once '../../class/Empleados.php';

$Obj_Empleados = new Empleados();
$Res_Roles = $Obj_Empleados->listarRoles();

$Res_Empleado = $Obj_Empleados->buscarPorId($_GET['id']);

$DatosEmpleado = $Res_Empleado->fetch_assoc();

if (($_SESSION['id_rol'] === 2 && intval($DatosEmpleado['id_rol']) === 2) ||
    ($_SESSION['id_rol'] === 3 && intval($DatosEmpleado['id_rol']) <= 3) ||
    $_SESSION['id_rol'] > 3
) {
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
    <title>Editar Empleado</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        .img-user {
            border-radius: 50%;
            max-width: 5rem;
            cursor: pointer;
            margin: .5rem;
        }

        .img-user-container {
            display: flex;
            justify-content: center;
        }

        .img-user {
            opacity: .5;
        }

        .img-user-selected img {
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, #0d47a1 0px 0px 0px 3px;
            opacity: 1;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="pt-3 wrapper d-flex justify-content-center">
        <!-- Main content -->
        <div class="content" style="min-width:90vw;">
            <div class="container-fluid">
                <div class="row">
                    <form action="./editar.php" method="POST" class="card card-info" id="frmEditarEmpleado" style="min-width:90vw;">
                        <div class="card-header">
                            <h3 class="text-center card-title w-100">Editar datos de <b> <?= $DatosEmpleado['nombre_empleado'] ?> </b></h3>
                        </div>
                        <div class="card-body ">
                            <!-- Primer nombre -->
                            <div class="form-group container-fluid">
                                <label>Nombre del empleado</label>
                                <input type="text" class="form-control" placeholder="Nombre del empleado ..." name="txtNombreEmpleado" value="<?= $DatosEmpleado['nombre_empleado'] ?>">
                            </div>
                            <!-- Correo -->
                            <div class="form-group container-fluid">
                                <label>Correo</label>
                                <input type="email" class="form-control" placeholder="correo ..." name="txtCorreo" value="<?= $DatosEmpleado['correo'] ?>">
                            </div>
                            <!-- Rol -->
                            <div class="form-group container-fluid">
                                <label>Cargo</label>
                                <select class="form-control select2" style="width: 100%;" name="txtIdRol">
                                    <option value="<?= $DatosEmpleado['id_rol'] ?>"><?= $DatosEmpleado['nombre_rol'] ?></option>
                                    <?php
                                    while ($Rol = $Res_Roles->fetch_assoc()) {
                                        if ($DatosEmpleado['id_rol'] !== $Rol['id_rol'] && intval($Rol['id_rol']) !== 2) { ?>
                                            <option value="<?= $Rol['id_rol'] ?>"><?= $Rol['nombre_rol'] ?></option>
                                        <?php }
                                    }
                                    if (intval($_SESSION['id_rol']) === 2) { ?>
                                        <option value="2">Administrador (Super)</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mt-4 form-group container-fluid">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="chkImgDefault" name="chkImgDefault">
                                    <label for="chkImgDefault">
                                        Restablecer foto de perfil
                                    </label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_empleado" value="<?= $DatosEmpleado['id_empleado'] ?>">
                        <input type="hidden" name="url_foto" value="<?= $DatosEmpleado['url_foto'] ?>">
                        <label class="mb-3 text-sm text-center text-danger">El empleado debe cerrar sesión y volver a ingresar para visualizar los cambios</label>
                        <div class="form-group container-fluid">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Actualizar datos</button>
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
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Page specific script -->

    <script>
        $(function() {
            $('#frmEditarEmpleado').validate({
                rules: {
                    txtNombreEmpleado: {
                        required: true
                    },
                    txtCorreo: {
                        required: true,
                        email: true
                    },

                },
                messages: {
                    txtNombreEmpleado: {
                        required: "El nombre es obligatorio",
                    },
                    txtCorreo: {
                        required: "El correo es obligatorio",
                        email: "El correo no es válido"
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

        function closeForm() {
            window.close()
        }
    </script>
</body>

</html>