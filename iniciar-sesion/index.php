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
                <form action="recover-password.html" method="post">
                  <div class="mb-3 input-group">
                    <input type="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-request-code" data-dismiss="modal">Envíar código</a>
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
                <form action="#" method="post">
                  <div class="mb-3 input-group">
                    <input type="text" class="form-control" placeholder="Código">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-unlock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-new-password" data-dismiss="modal">Verificar código</button>
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
                <form action="#" method="post">
                  <div class="mb-3 input-group">
                    <input type="password" class="form-control" placeholder="Nueva contraseña">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-new-password" data-dismiss="modal">Actualizar contraseña</button>
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
</body>

</html>