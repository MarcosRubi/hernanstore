<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hernan Store | Iniciar sesión</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <p class="text-center card-header h1">
        <b>Hernan</b>Store</a>
      </p>
      <div class="card-body">
        <p class="login-box-msg">Inicia sesión para acceder al sistema</p>

        <form action="../func/SessionInitializer.php" method="post" id="frmLogin">
          <div class="mb-3 form-group">
            <div class="input-group">
              <input type="email" class="py-4 form-control" placeholder="Email" name="txtCorreo" value="<?php echo isset($_SESSION['correo']) ? $_SESSION['correo'] : ''; ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-3 form-group">
            <div class="input-group">
              <input type="password" class="py-4 form-control" placeholder="Contraseña" name="txtContrasenna" value="<?php echo isset($_SESSION['contrasenna']) ? $_SESSION['contrasenna'] : ''; ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="py-2 row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="chkRemember" name="chkRemember" <?php if (isset($_SESSION['contrasenna']) || isset($_SESSION['remember'])) {
                                                                              echo 'checked';
                                                                            } ?>>
                <label for="chkRemember">
                  Recordar credenciales
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="#" class="mb-1" data-toggle="modal" data-target="#modal-reset-password">
          Olvide mi contraseña
        </a>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="modal fade" id="modal-reset-password">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Cambiar contraseña</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card card-outline card-primary">
              <div class="card-body">
                <p class="login-box-msg">Ingrese su dirección de correo electrónico vinculado a su cuenta para enviar un código.</p>
                <form id="form-reset-password" method="post">
                  <div class="mb-3 input-group">
                    <input type="email" name="txtEmailVerify" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">

                    <div class="col-12">
                      <button type="submit" class="btn btn-primary btn-block" id="btn-reset-password">Enviar código</a>
                        <button class="btn text-primary btn-block mt-3" id="btn-show-step-2">Tengo un código</button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
              </div>
              <!-- /.login-card-body -->
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-request-code">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Ingresar código</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card card-outline card-primary">
              <div class="card-body">
                <p class="login-box-msg">Ingrese el código enviado a su dirección de correo electrónico vinculado a su cuenta.</p>
                <form id="form-validate-key" method="post">
                  <div class="mb-3 input-group">
                    <input type="text" name="txtCodeVerify" class="form-control" placeholder="Código">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-unlock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary btn-block" id="btn-validate-key">Verificar código</button>
                      <span class="text-danger small text-center mt-2 d-block">El código es de un solo uso, en caso de no usarse expira en 10 minutos desde que fue enviado</span>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
              </div>
              <!-- /.login-card-body -->
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-new-password">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Actualizar contraseña</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="login-box-msg">Ingrese su nueva contraseña.</p>
            <div class="card card-outline card-primary">
              <div class="card-body">
                <form id="form-new-password" method="post">
                  <div class="mb-3 input-group">
                    <input type="password" name="txtNewPassword" class="form-control" placeholder="Nueva contraseña">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary btn-block" id="btn-new-password">Actualizar contraseña</button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
              </div>
              <!-- /.login-card-body -->
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- jquery-validation -->
  <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- Toastr -->
  <script src="../plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <script>
    $(function() {
      <?php include '../utils/frmLoginValidate.php' ?>
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
  <script>
    $(document).ready(function() {
      $("#btn-reset-password").click(function(e) {
        e.preventDefault(); // Evita que se envíe el formulario de manera tradicional

        // Obtén los datos del formulario
        var formData = $("#form-reset-password").serialize();

        // Realiza una solicitud AJAX para actualizar los detalles del préstamo
        $.ajax({
          type: "POST",
          url: "../func/verifyEmail.php",
          data: formData,
          success: function(response) {
            // Verifica si la respuesta indica éxito
            if (response.success) {
              // Muestra el mensaje de éxito
              toastr.success(response.message);
              $("#modal-reset-password").modal("hide");
              $("#modal-request-code").modal("show");
            } else {
              // Muestra el mensaje de error
              toastr.error(response.message);
            }
          },
        });
      });
      $("#btn-validate-key").click(function(e) {
        e.preventDefault(); // Evita que se envíe el formulario de manera tradicional

        // Obtén los datos del formulario
        var formData = $("#form-validate-key").serialize();

        // Realiza una solicitud AJAX para actualizar los detalles del préstamo
        $.ajax({
          type: "POST",
          url: "../func/verifyCode.php",
          data: formData,
          success: function(response) {
            // Verifica si la respuesta indica éxito
            if (response.success) {
              // Muestra el mensaje de éxito
              $("#modal-new-password").modal("show");
              $("#modal-request-code").modal("hide");
            } else {
              // Muestra el mensaje de error
              toastr.error(response.message);
            }
          },
        });
      });
      $("#btn-new-password").click(function(e) {
        e.preventDefault(); // Evita que se envíe el formulario de manera tradicional

        // Obtén los datos del formulario
        var formData = $("#form-new-password").serialize();

        console.log(formData)

        // Realiza una solicitud AJAX para actualizar los detalles del préstamo
        $.ajax({
          type: "POST",
          url: "../func/resetPassword.php",
          data: formData,
          success: function(response) {
            // Verifica si la respuesta indica éxito
            if (response.success) {
              // Muestra el mensaje de éxito
              toastr.success(response.message);
              $("#modal-new-password").modal("hide");
            } else {
              // Muestra el mensaje de error
              toastr.error(response.message);
            }
          },
        });
      });

      $("#btn-show-step-2").click(function(e) {
        e.preventDefault()
        $("#modal-reset-password").modal("hide");
        $("#modal-request-code").modal("show");
      })
    });
  </script>
</body>

</html>